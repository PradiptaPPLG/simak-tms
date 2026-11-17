<?php

namespace App\Http\Controllers;

use App\Models\Batch;
use App\Models\DailyJournal;
use App\Models\Evaluation;
use App\Models\ShowcaseProject;
use App\Models\Task;
use App\Models\TaskSubmission;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class SimakController extends Controller
{
    // ==========================================
    // AUTHENTICATION
    // ==========================================
    public function showLogin()
    {
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'login_id' => 'required|string',
            'password' => 'required|string',
        ]);

        $loginId = trim($request->login_id);

        // Cari berdasarkan 5-digit account_id, username, atau email
        $user = User::where('account_id', $loginId)
                    ->orWhere('username', $loginId)
                    ->orWhere('email', $loginId)
                    ->first();

        $remember = $request->boolean('remember') || $request->filled('remember');

        if ($user && Hash::check($request->password, $user->password)) {
            Auth::login($user, $remember);
            $request->session()->regenerate();
            return redirect()->intended(route('dashboard'));
        }

        return back()->withErrors([
            'login_id' => 'ID Pengguna / Email atau Kata Sandi salah. Gunakan ID 5-digit Anda (contoh: 19364) dan kata sandi: tmshebatsukses.',
        ])->onlyInput('login_id');
    }

    private function generateUniqueAccountId(): string
    {
        do {
            $code = (string) rand(10000, 99999);
        } while (User::where('account_id', $code)->orWhere('username', $code)->exists());

        return $code;
    }

    // Quick Login Demo Helper for Siswa / Mentor / Admin
    public function quickLogin($role)
    {
        $user = User::where('role', $role)->first();
        if ($user) {
            Auth::login($user, true);
            request()->session()->regenerate();
            return redirect()->route('dashboard')->with('success', 'Selamat datang, ' . $user->name . ' (' . strtoupper($user->role) . ')');
        }
        
        $roleName = $role === 'mentor' ? 'Staff Mentor' : ($role === 'siswa' ? 'Siswa PKL' : 'Admin');
        return redirect()->route('login')->with('error', "Belum ada akun {$roleName} terdaftar. Silakan login sebagai Admin TMS terlebih dahulu untuk mendaftarkan akun baru.");
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login')->with('success', 'Anda telah keluar dari sistem.');
    }

    // ==========================================
    // DASHBOARD UTAMA (ROLE-AWARE)
    // ==========================================
    public function dashboard()
    {
        $user = Auth::user() ?? User::first();

        // 1. Jika Admin TMS: Monitoring Global Seluruh Siswa & Seluruh Arsip Proyek
        if ($user->role === 'admin_tms') {
            return $this->adminDashboard();
        }

        // 2. Jika Staff Mentor: Monitoring Batch Aktif yang Berjalan Sekarang (Tanpa Presensi Masuk Kerja & Tanpa Jurnal)
        if ($user->role === 'mentor') {
            return $this->mentorDashboard();
        }

        // 3. Jika Siswa: Dashboard Aktivitas, Presensi Masuk Kerja & Logbook Harian
        $tasks = Task::with('mentor')->where('status', 'aktif')->latest()->take(3)->get();
        $pendingTasksCount = Task::where('status', 'aktif')->count();
        $todayJournal = DailyJournal::where('user_id', $user->id)
            ->whereDate('journal_date', today())
            ->first();
        $totalJournalsCount = DailyJournal::where('user_id', $user->id)->count();
        $approvedJournalsCount = DailyJournal::where('user_id', $user->id)->where('status', 'approved')->count();
        $pendingJournalsCount = DailyJournal::where('user_id', $user->id)->where('status', 'pending')->count();
        $showcaseCount = ShowcaseProject::count();
        $evaluation = Evaluation::where('user_id', $user->id)->first();

        return view('dashboard', compact(
            'user',
            'tasks',
            'pendingTasksCount',
            'todayJournal',
            'totalJournalsCount',
            'approvedJournalsCount',
            'pendingJournalsCount',
            'showcaseCount',
            'evaluation'
        ));
    }

    // ==========================================
    // LMS & TASK BOARD
    // ==========================================
    public function tasks(Request $request)
    {
        $user = Auth::user();
        $filter = $request->get('filter', 'all');

        $query = Task::with(['mentor', 'submissions' => function ($q) use ($user) {
            $q->where('user_id', $user->id);
        }]);

        if ($filter === 'aktif') {
            $query->where('status', 'aktif');
        } elseif ($filter === 'selesai') {
            $query->where('status', 'selesai');
        }

        $tasks = $query->latest()->get();

        return view('tasks.index', compact('user', 'tasks', 'filter'));
    }

    public function submitTask(Request $request, $id)
    {
        $request->validate([
            'repo_url' => 'nullable|url',
            'demo_url' => 'nullable|url',
            'submission_notes' => 'required|string',
        ]);

        $user = Auth::user();

        TaskSubmission::updateOrCreate(
            [
                'task_id' => $id,
                'user_id' => $user->id,
            ],
            [
                'repo_url' => $request->repo_url,
                'demo_url' => $request->demo_url,
                'submission_notes' => $request->submission_notes,
                'status' => 'submitted',
                'submitted_at' => now(),
            ]
        );

        return back()->with('success', 'Tugas berhasil dikumpulkan untuk direview oleh Mentor!');
    }

    // ==========================================
    // JURNAL HARIAN (LOGBOOK)
    // ==========================================
    public function journals(Request $request)
    {
        $user = Auth::user();
        $journals = DailyJournal::with('mentor')
            ->where('user_id', $user->id)
            ->orderBy('journal_date', 'desc')
            ->get();

        $journalsByDate = $journals->keyBy(function($j) {
            return $j->journal_date instanceof \Carbon\Carbon 
                ? $j->journal_date->toDateString() 
                : substr((string)$j->journal_date, 0, 10);
        });

        $selectedDate = $request->get('date', now()->toDateString());
        $selectedJournal = $journalsByDate->get($selectedDate);
        $todayJournal = $journalsByDate->get(now()->toDateString());

        return view('journals.index', compact('user', 'journals', 'journalsByDate', 'selectedDate', 'selectedJournal', 'todayJournal'));
    }

    public function storeJournal(Request $request)
    {
        $request->validate([
            'journal_date' => 'required|date',
            'activity_title' => 'required|string|max:200',
            'activity_detail' => 'required|string',
            'commit_url' => 'nullable|string',
        ]);

        $user = Auth::user();
        $mentorId = $user->mentor_id ?? User::where('role', 'mentor')->value('id');

        $existing = DailyJournal::where('user_id', $user->id)
            ->where('journal_date', $request->journal_date)
            ->first();

        DailyJournal::updateOrCreate(
            [
                'user_id' => $user->id,
                'journal_date' => $request->journal_date,
            ],
            [
                'activity_title' => $request->activity_title,
                'activity_detail' => $request->activity_detail,
                'commit_url' => $request->commit_url,
                'mentor_id' => $existing ? $existing->mentor_id : $mentorId,
                'mentor_feedback' => $existing ? $existing->mentor_feedback : null,
                'status' => ($existing && $existing->mentor_feedback) ? 'approved' : 'pending',
            ]
        );

        return redirect()->route('journals.index', ['date' => $request->journal_date])->with('success', 'Catatan jurnal kegiatan berhasil disimpan!');
    }

    // ==========================================
    // ARSIP SHOWCASE ANGKATAN
    // ==========================================
    public function showcase(Request $request)
    {
        $batches = Batch::withCount('showcaseProjects')->get();
        $selectedBatchId = $request->get('batch_id', null);

        $query = ShowcaseProject::with(['batch', 'creator']);
        if ($selectedBatchId) {
            $query->where('batch_id', $selectedBatchId);
        }
        $projects = $query->latest()->get();

        return view('showcase.index', compact('batches', 'selectedBatchId', 'projects'));
    }

    // ==========================================
    // EVALUASI & NILAI
    // ==========================================
    public function evaluation()
    {
        $user = Auth::user();
        $evaluation = Evaluation::with('mentor')->where('user_id', $user->id)->first();
        $completedTasksCount = TaskSubmission::where('user_id', $user->id)->where('status', 'approved')->count();
        $approvedJournalsCount = DailyJournal::where('user_id', $user->id)->where('status', 'approved')->count();

        return view('evaluation.index', compact('user', 'evaluation', 'completedTasksCount', 'approvedJournalsCount'));
    }

    // ==========================================
    // REVIEW & SISIPKAN CATATAN KHUSUS MENTOR
    // ==========================================
    public function mentorReview()
    {
        $journals = DailyJournal::with(['user', 'mentor'])->latest('journal_date')->get();
        $pendingJournalsCount = DailyJournal::whereNull('mentor_feedback')->orWhere('mentor_feedback', '')->count();
        $reviewedJournalsCount = DailyJournal::whereNotNull('mentor_feedback')->where('mentor_feedback', '!=', '')->count();
        $pendingSubmissions = TaskSubmission::with(['task', 'user'])->where('status', 'submitted')->latest()->get();

        return view('mentor.review', compact('journals', 'pendingJournalsCount', 'reviewedJournalsCount', 'pendingSubmissions'));
    }

    public function mentorAddNote(Request $request, $id)
    {
        $request->validate([
            'mentor_feedback' => 'required|string',
        ]);

        $journal = DailyJournal::findOrFail($id);
        $mentor = Auth::user();
        $journal->update([
            'mentor_id' => $mentor ? $mentor->id : $journal->mentor_id,
            'mentor_feedback' => $request->mentor_feedback,
            'status' => 'approved',
        ]);

        return back()->with('success', 'Catatan & arahan bimbingan mentor berhasil disisipkan untuk siswa!');
    }

    public function approveJournal($id)
    {
        $journal = DailyJournal::findOrFail($id);
        $mentor = Auth::user();
        $journal->update([
            'status' => 'approved',
            'mentor_id' => $mentor ? $mentor->id : $journal->mentor_id,
            'mentor_feedback' => $journal->mentor_feedback ?: 'Aktivitas terverifikasi dan memenuhi standar dokumentasi kerja PT. Teknologi Multi Sistem.',
        ]);

        return back()->with('success', 'Jurnal berhasil ditandai dan disetujui!');
    }

    public function gradeSubmission(Request $request, $id)
    {
        $submission = TaskSubmission::findOrFail($id);
        $submission->update([
            'status' => 'approved',
            'score' => $request->score ?? 95,
            'feedback' => $request->feedback ?? 'Pengerjaan modul sesuai spesifikasi.',
        ]);

        return back()->with('success', 'Nilai tugas berhasil disimpan!');
    }

    public function informasi()
    {
        return redirect()->route('faq');
    }

    public function faq()
    {
        return view('help.faq');
    }

    // ==========================================
    // DEVELOPER / INTERN PROFILE ALA GITHUB
    // ==========================================
    public function profile()
    {
        $user = Auth::user() ?? User::first();
        $projects = ShowcaseProject::where('creator_id', $user->id)->get();
        $journals = DailyJournal::where('user_id', $user->id)->latest()->take(10)->get();
        $submissions = TaskSubmission::with('task')->where('user_id', $user->id)->latest()->get();
        $evaluation = Evaluation::where('user_id', $user->id)->first();
        
        $totalCommits = 47;
        $totalJournals = DailyJournal::where('user_id', $user->id)->count();
        $totalSubmissions = TaskSubmission::where('user_id', $user->id)->count();
        $totalContributions = $totalCommits + $totalJournals + $totalSubmissions;

        // Matrix heatmap gaya GitHub (35 hari terakhir)
        $heatmap = [];
        for ($i = 34; $i >= 0; $i--) {
            $date = now()->subDays($i);
            $count = ($i % 3 == 0 || $i % 7 == 2 || $i == 0) ? rand(2, 6) : ($i % 4 == 0 ? rand(1, 2) : 0);
            $heatmap[] = [
                'date' => $date->format('Y-m-d'),
                'label' => $date->translatedFormat('d M Y'),
                'count' => $count,
                'level' => $count == 0 ? 0 : ($count <= 2 ? 1 : ($count <= 4 ? 2 : 3))
            ];
        }

        return view('profile.index', compact(
            'user',
            'projects',
            'journals',
            'submissions',
            'evaluation',
            'totalContributions',
            'totalCommits',
            'totalJournals',
            'heatmap'
        ));
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();
        $validated = $request->validate([
            'username' => 'nullable|string|max:60',
            'headline' => 'nullable|string|max:180',
            'bio' => 'nullable|string',
            'github_url' => 'nullable|url',
            'linkedin_url' => 'nullable|url',
            'instagram_url' => 'nullable|url',
            'website_url' => 'nullable|url',
            'skills' => 'nullable|string',
            'location' => 'nullable|string|max:100',
            'avatar' => 'nullable|string',
        ]);

        $user->update($validated);

        return back()->with('success', 'Profil Developer & Tautan Media Sosial berhasil diperbarui!');
    }

    // ==========================================
    // MENTOR DASHBOARD (MONITORING BATCH YANG SEKARANG)
    // ==========================================
    public function mentorDashboard()
    {
        $mentor = Auth::user() ?? User::where('role', 'mentor')->first();
        $activeBatch = Batch::where('is_active', true)->first() ?? Batch::first();
        
        // Siswa aktif bimbingan saat ini (Yang Sekarang)
        $activeInterns = User::where('role', 'siswa')
            ->with(['submissions.task', 'evaluation', 'showcaseProjects', 'journals' => function ($q) {
                $q->latest()->take(1);
            }])
            ->get();
        
        $pendingJournals = DailyJournal::with('user')
            ->where('status', 'pending')
            ->latest()
            ->get();
            
        $pendingSubmissions = TaskSubmission::with(['task', 'user'])
            ->where('status', 'submitted')
            ->latest()
            ->get();

        $activeTasks = Task::where('status', 'aktif')->latest()->get();
        $recentEvaluations = Evaluation::with('user')->latest()->take(5)->get();

        return view('mentor.dashboard', compact(
            'mentor',
            'activeBatch',
            'activeInterns',
            'pendingJournals',
            'pendingSubmissions',
            'activeTasks',
            'recentEvaluations'
        ));
    }

    // ==========================================
    // ADMIN PANEL (MONITORING SEMUA & SEMUA ARSIP)
    // ==========================================
    public function adminDashboard()
    {
        $interns = User::where('role', 'siswa')->with(['mentor', 'batch', 'evaluation', 'showcaseProjects', 'submissions'])->get();
        $mentors = User::where('role', 'mentor')->get();
        $batches = Batch::withCount('showcaseProjects')->get();
        $tasks = Task::with('mentor')->latest()->get();
        $allProjects = ShowcaseProject::with(['batch', 'creator'])->latest()->get();
        
        $totalInterns = $interns->count();
        $totalMentors = $mentors->count();
        $totalJournals = DailyJournal::count();
        $pendingJournals = DailyJournal::where('status', 'pending')->count();
        $totalTasks = Task::count();
        $totalProjects = $allProjects->count();

        return view('admin.dashboard', compact(
            'interns',
            'mentors',
            'batches',
            'tasks',
            'allProjects',
            'totalInterns',
            'totalMentors',
            'totalJournals',
            'pendingJournals',
            'totalTasks',
            'totalProjects'
        ));
    }

    public function adminStudents(Request $request)
    {
        $query = User::where('role', 'siswa')->with(['mentor', 'batch', 'evaluation', 'showcaseProjects', 'submissions']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('school_origin', 'like', "%{$search}%")
                  ->orWhere('major', 'like', "%{$search}%");
            });
        }

        if ($request->filled('mentor_id')) {
            $query->where('mentor_id', $request->mentor_id);
        }

        $interns = $query->latest()->get();
        $mentors = User::where('role', 'mentor')->get();
        $batches = Batch::all();
        $totalInterns = User::where('role', 'siswa')->count();
        $assignedInterns = User::where('role', 'siswa')->whereNotNull('mentor_id')->count();
        $evaluatedInterns = Evaluation::count();

        return view('admin.students', compact(
            'interns',
            'mentors',
            'batches',
            'totalInterns',
            'assignedInterns',
            'evaluatedInterns'
        ));
    }

    public function adminCreateTask(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:200',
            'description' => 'required|string',
            'deadline' => 'required|date',
            'priority' => 'required|in:rendah,sedang,tinggi',
        ]);

        $batch = Batch::first();
        $mentor = User::where('role', 'mentor')->first();

        Task::create([
            'mentor_id' => $mentor ? $mentor->id : Auth::id(),
            'batch_id' => $batch ? $batch->id : 1,
            'title' => $request->title,
            'description' => $request->description,
            'deadline' => $request->deadline,
            'priority' => $request->priority,
            'status' => 'aktif',
        ]);

        return back()->with('success', 'Modul penugasan koding baru berhasil diterbitkan untuk siswa!');
    }

    // ==========================================
    // PENDAFTARAN PENGGUNA (ROLE HIERARCHY)
    // ==========================================
    // 1. Admin: Bisa mendaftarkan Mentor & Siswa
    public function adminStoreUser(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'nullable|string|max:150',
            'role' => 'required|in:mentor,siswa',
            'school_origin' => 'nullable|string|max:150',
            'major' => 'nullable|string|max:100',
            'mentor_id' => 'nullable|exists:users,id',
            'batch_id' => 'nullable|exists:batches,id',
        ]);

        $batch = Batch::first();
        $avatarBg = $validated['role'] === 'mentor' ? '090d16' : 'ef4444';
        $accountId = $this->generateUniqueAccountId();

        $email = !empty($validated['email'])
            ? (str_contains($validated['email'], '@') ? strtolower(trim($validated['email'])) : strtolower(trim($validated['email'])) . '@tms.co.id')
            : ($validated['role'] === 'mentor' ? "mentor.{$accountId}@tms.co.id" : "siswa.{$accountId}@tms.co.id");

        $user = User::create([
            'name' => $validated['name'],
            'account_id' => $accountId,
            'username' => $accountId,
            'email' => $email,
            'password' => Hash::make('tmshebatsukses'),
            'role' => $validated['role'],
            'school_origin' => $validated['school_origin'] ?? ($validated['role'] === 'mentor' ? 'PT. Teknologi Multi Sistem' : 'SMKN 1 Ciamis'),
            'major' => $validated['major'] ?? ($validated['role'] === 'mentor' ? 'Software Engineering' : 'PPLG'),
            'mentor_id' => $validated['role'] === 'siswa' ? ($validated['mentor_id'] ?? null) : null,
            'batch_id' => $validated['batch_id'] ?? ($batch ? $batch->id : 1),
            'must_change_password' => 1,
            'avatar' => 'https://ui-avatars.com/api/?name=' . urlencode($validated['name']) . '&background=' . $avatarBg . '&color=ffffff&bold=true&size=256',
        ]);

        $roleLabel = $validated['role'] === 'mentor' ? 'Staff Mentor' : 'Siswa PKL';
        return back()->with('success', "Akun {$roleLabel} {$user->name} ({$accountId}) berhasil didaftarkan! ID Login: {$accountId} | Kata Sandi: tmshebatsukses");
    }

    // ==========================================
    // MENTOR STUDENTS INSPECT & STATS
    // ==========================================
    public function mentorStudents()
    {
        $mentor = Auth::user() ?? User::where('role', 'mentor')->first();
        $students = User::where('role', 'siswa')
            ->with(['journals' => function($q) {
                $q->latest();
            }, 'showcaseProjects', 'evaluation', 'mentor'])
            ->get();
        
        $totalStudents = $students->count();
        $totalApprovedJournals = DailyJournal::where('status', 'approved')->count();

        return view('mentor.students', compact('mentor', 'students', 'totalStudents', 'totalApprovedJournals'));
    }

    // ==========================================
    // ADMIN STUDENT MANAGEMENT (EDIT & DELETE)
    // ==========================================
    public function adminUpdateStudent(Request $request, $id)
    {
        $student = User::where('role', 'siswa')->findOrFail($id);
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|unique:users,email,' . $student->id,
            'school_origin' => 'nullable|string|max:150',
            'major' => 'nullable|string|max:100',
            'mentor_id' => 'nullable|exists:users,id',
        ]);

        $student->update($validated);

        return back()->with('success', "Data siswa {$student->name} berhasil diperbarui oleh Admin!");
    }

    public function adminDeleteStudent($id)
    {
        $student = User::where('role', 'siswa')->findOrFail($id);
        $name = $student->name;
        
        // Clean up related records
        $student->journals()->delete();
        $student->submissions()->delete();
        if ($student->evaluation) {
            $student->evaluation()->delete();
        }
        $student->delete();

        return back()->with('success', "Data siswa {$name} berhasil dihapus dari sistem oleh Admin.");
    }

    // ==========================================
    // ADMIN MENTOR MANAGEMENT (MASTER DATA MENTOR)
    // ==========================================
    public function adminMentors(Request $request)
    {
        $query = User::where('role', 'mentor')->with(['students.evaluation', 'tasks']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('major', 'like', "%{$search}%")
                  ->orWhere('headline', 'like', "%{$search}%")
                  ->orWhere('phone_number', 'like', "%{$search}%");
            });
        }

        $mentors = $query->latest()->get();
        $totalMentors = User::where('role', 'mentor')->count();
        $totalStudents = User::where('role', 'siswa')->count();
        $assignedStudentsCount = User::where('role', 'siswa')->whereNotNull('mentor_id')->count();
        $ratio = $totalMentors > 0 ? round($totalStudents / $totalMentors, 1) : 0;

        return view('admin.mentors', compact(
            'mentors',
            'totalMentors',
            'totalStudents',
            'assignedStudentsCount',
            'ratio'
        ));
    }

    public function adminStoreMentor(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'nullable|string|max:150',
            'headline' => 'nullable|string|max:150',
            'phone_number' => 'nullable|string|max:30',
            'bio' => 'nullable|string',
            'location' => 'nullable|string|max:100',
        ]);

        $batch = Batch::first();
        $accountId = $this->generateUniqueAccountId();

        $email = !empty($validated['email'])
            ? (str_contains($validated['email'], '@') ? strtolower(trim($validated['email'])) : strtolower(trim($validated['email'])) . '@tms.co.id')
            : "mentor.{$accountId}@tms.co.id";

        $mentor = User::create([
            'name' => $validated['name'],
            'account_id' => $accountId,
            'username' => $accountId,
            'email' => $email,
            'password' => Hash::make('tmshebatsukses'),
            'role' => 'mentor',
            'school_origin' => 'PT. Teknologi Multi Sistem',
            'major' => $validated['headline'] ?? 'Senior Software Engineer',
            'headline' => $validated['headline'] ?? 'Senior Software Engineer',
            'phone_number' => $validated['phone_number'] ?? '081234567890',
            'bio' => $validated['bio'] ?? 'Staff Mentor Pembimbing Industri PT. TMS',
            'location' => $validated['location'] ?? 'IT / Software Engineering',
            'batch_id' => $batch ? $batch->id : 1,
            'must_change_password' => 1,
            'avatar' => 'https://ui-avatars.com/api/?name=' . urlencode($validated['name']) . '&background=090d16&color=ffffff&bold=true&size=256',
        ]);

        return back()->with('success', "Akun Staff Mentor {$mentor->name} ({$accountId}) berhasil didaftarkan! ID Login: {$accountId} | Divisi: {$mentor->location} | Kata Sandi: tmshebatsukses");
    }

    public function adminUpdateMentor(Request $request, $id)
    {
        $mentor = User::where('role', 'mentor')->findOrFail($id);
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'nullable|string|max:150',
            'headline' => 'nullable|string|max:150',
            'phone_number' => 'nullable|string|max:30',
            'bio' => 'nullable|string',
            'location' => 'nullable|string|max:100',
        ]);

        $mentor->update([
            'name' => $validated['name'],
            'email' => $validated['email'] ?? $mentor->email,
            'major' => $validated['headline'] ?? $mentor->major,
            'headline' => $validated['headline'] ?? $mentor->headline,
            'phone_number' => $validated['phone_number'] ?? $mentor->phone_number,
            'bio' => $validated['bio'] ?? $mentor->bio,
            'location' => $validated['location'] ?? $mentor->location ?? 'IT / Software Engineering',
        ]);

        return back()->with('success', "Data mentor {$mentor->name} berhasil diperbarui oleh Admin!");
    }

    public function adminDeleteMentor($id)
    {
        $mentor = User::where('role', 'mentor')->findOrFail($id);
        $name = $mentor->name;

        // Reassign or unassign students who have this mentor
        User::where('mentor_id', $mentor->id)->update(['mentor_id' => null]);

        $mentor->delete();

        return back()->with('success', "Akun mentor {$name} berhasil dihapus dari sistem.");
    }

    // ==========================================
    // RESET PASSWORD PENGGUNA OLEH ADMIN TMS
    // ==========================================
    public function adminResetPassword($id)
    {
        if (Auth::user()->role !== 'admin_tms') {
            abort(403, 'Akses terbatas khusus Administrator TMS.');
        }

        $target = User::findOrFail($id);
        $target->update([
            'password' => Hash::make('tmshebatsukses'),
            'must_change_password' => 1,
        ]);

        $roleLabel = $target->role === 'mentor' ? 'Staff Mentor' : ($target->role === 'siswa' ? 'Siswa Magang' : 'Pengguna');
        return back()->with('success', "Kata sandi {$roleLabel} {$target->name} ({$target->account_id}) berhasil direset ke default: tmshebatsukses! Akun akan diminta memperbarui kata sandi saat masuk.");
    }

    // ==========================================
    // GANTI PASSWORD PENGGUNA (UNIVERSAL DEFAULT: tmshebatsukses)
    // ==========================================
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|min:6|confirmed',
        ], [
            'current_password.required' => 'Kata sandi saat ini wajib diisi.',
            'password.required' => 'Kata sandi baru wajib diisi.',
            'password.min' => 'Kata sandi baru minimal 6 karakter.',
            'password.confirmed' => 'Konfirmasi kata sandi baru tidak cocok.',
        ]);

        $user = Auth::user();

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Kata sandi saat ini tidak cocok dengan akun Anda.']);
        }

        $user->update([
            'password' => Hash::make($request->password),
            'must_change_password' => 0,
        ]);

        return back()->with('success', 'Kata sandi akun Anda berhasil diperbarui!');
    }
}
