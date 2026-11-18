<?php

namespace App\Http\Controllers;

use App\Models\Batch;
use App\Models\DailyJournal;
use App\Models\Evaluation;
use App\Models\PartnerInstitution;
use App\Models\PklRegistration;
use App\Models\ShowcaseProject;
use App\Models\Task;
use App\Models\TaskSubmission;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class SimakController extends Controller
{
    // ==========================================
    // AUTHORIZATION HELPERS (DEFENSE IN DEPTH)
    // ==========================================
    /**
     * Pastikan pengguna saat ini adalah Administrator TMS
     */
    private function authorizeAdmin(): User
    {
        $user = Auth::user();
        if (!$user || $user->role !== 'admin_tms') {
            abort(403, 'Akses Ditolak: Modul ini hanya dapat diakses oleh Administrator TMS.');
        }
        return $user;
    }

    /**
     * Pastikan pengguna saat ini adalah Mentor atau Administrator TMS
     */
    private function authorizeMentorOrAdmin(): User
    {
        $user = Auth::user();
        if (!$user || !in_array($user->role, ['mentor', 'admin_tms'], true)) {
            abort(403, 'Akses Ditolak: Modul ini hanya dapat diakses oleh Staff Mentor atau Administrator TMS.');
        }
        return $user;
    }

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
        $throttleKey = Str::lower($loginId) . '|' . $request->ip();

        // Rate limit: Maksimal 5 percobaan gagal per 1 menit
        if (RateLimiter::tooManyAttempts($throttleKey, 5)) {
            $seconds = RateLimiter::availableIn($throttleKey);
            return back()->withErrors([
                'login_id' => "Terlalu banyak percobaan login gagal. Demi keamanan, silakan tunggu {$seconds} detik lagi.",
            ])->onlyInput('login_id');
        }

        // Cari berdasarkan account_id, username, atau email
        $user = User::where('account_id', $loginId)
                    ->orWhere('username', $loginId)
                    ->orWhere('email', $loginId)
                    ->first();

        $remember = $request->boolean('remember') || $request->filled('remember');

        if ($user && Hash::check($request->password, $user->password)) {
            // Mencegah siswa yang belum resmi terdaftar (menunggu penetapan mentor & penerbitan ID) masuk ke sistem
            if ($user->role === 'siswa' && (empty($user->account_id) || empty($user->mentor_id))) {
                return back()->withErrors([
                    'login_id' => 'Pendaftaran Anda telah diterima, namun akun Anda saat ini sedang dalam proses penetapan mentor pembimbing dan penerbitan ID resmi 5-digit oleh Administrator. Silakan cek status pendaftaran secara berkala di menu Cek Status Pendaftaran.',
                ])->onlyInput('login_id');
            }

            RateLimiter::clear($throttleKey);
            Auth::login($user, $remember);
            $request->session()->regenerate();
            return redirect()->intended(route('dashboard'));
        }

        // Catat percobaan gagal (lockout 60 detik)
        RateLimiter::hit($throttleKey, 60);

        $attemptsLeft = RateLimiter::remaining($throttleKey, 5);
        $warningMsg = $attemptsLeft > 0
            ? "ID Pengguna atau Kata Sandi salah. (Sisa percobaan: {$attemptsLeft})"
            : "ID Pengguna atau Kata Sandi salah. Percobaan login terkunci sementara selama 60 detik.";

        return back()->withErrors([
            'login_id' => $warningMsg,
        ])->onlyInput('login_id');
    }

    private function generateUniqueAccountId(): string
    {
        do {
            $code = (string) rand(10000, 99999);
        } while (User::where('account_id', $code)->orWhere('username', $code)->exists());

        return $code;
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
        $user = Auth::user();
        if ($user->role !== 'siswa') {
            abort(403, 'Akses Ditolak: Hanya siswa magang yang dapat mengumpulkan tugas.');
        }

        $request->validate([
            'repo_url' => 'nullable|url',
            'demo_url' => 'nullable|url',
            'submission_notes' => 'required|string',
        ]);

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
        $user = Auth::user();
        if ($user->role !== 'siswa') {
            return redirect()->route('dashboard')->with('error', 'Hanya siswa magang yang dapat mengisi logbook kegiatan harian.');
        }

        $request->validate([
            'journal_date' => 'required|date|before_or_equal:today',
            'activity_title' => 'required|string|max:200',
            'activity_detail' => 'required|string',
            'commit_url' => 'nullable|string',
        ], [
            'journal_date.before_or_equal' => 'Pengisian logbook tidak dapat dilakukan untuk tanggal di masa depan.',
        ]);

        $today = now()->toDateString();
        // Mencegah kecurangan siswa mengisi jurnal untuk hari esok / masa depan
        if ($request->journal_date > $today) {
            return redirect()->route('journals.index')->withErrors([
                'activity_title' => 'Pengisian logbook tidak dapat dilakukan untuk tanggal di masa depan.',
            ]);
        }

        $isPast = ($request->journal_date < $today);
        $existing = DailyJournal::where('user_id', $user->id)
            ->where('journal_date', $request->journal_date)
            ->first();

        // Mencegah kecurangan siswa mengisi mundur tanggal yang terlewat dan belum diisi
        if ($isPast && !$existing) {
            return redirect()->route('journals.index')->withErrors([
                'activity_title' => 'Batas waktu pengisian logbook untuk tanggal tersebut telah ditutup.',
            ]);
        }

        $mentorId = $user->mentor_id ?? User::where('role', 'mentor')->value('id');

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

    public function printJournal(Request $request)
    {
        $currentUser = Auth::user();
        if ($currentUser->role !== 'siswa' && $request->filled('student_id')) {
            $user = User::find($request->student_id) ?? $currentUser;
        } else {
            $user = $currentUser;
        }

        $user->loadMissing(['mentor', 'batch']);
        $mentor = $user->mentor ?? User::where('role', 'mentor')->first();

        $jurnals = DailyJournal::where('user_id', $user->id)
            ->orderBy('journal_date', 'asc')
            ->get();

        $startDate = $jurnals->first() 
            ? \Carbon\Carbon::parse($jurnals->first()->journal_date)->startOfWeek(\Carbon\Carbon::MONDAY) 
            : now()->startOfWeek(\Carbon\Carbon::MONDAY);

        $groupedJurnals = $jurnals->groupBy(function($row) use ($startDate) {
            $rowDate = \Carbon\Carbon::parse($row->journal_date);
            $weekNum = (int) ($startDate->diffInWeeks($rowDate->copy()->startOfWeek(\Carbon\Carbon::MONDAY))) + 1;
            $monthName = $rowDate->locale('id')->translatedFormat('F Y');
            return "Minggu Ke: {$weekNum}|Bulan: {$monthName}";
        });

        return view('journals.print', compact('user', 'mentor', 'jurnals', 'groupedJurnals'));
    }

    public function printPortfolio(Request $request)
    {
        $currentUser = Auth::user();
        if ($currentUser->role !== 'siswa' && $request->filled('student_id')) {
            $user = User::find($request->student_id) ?? $currentUser;
        } else {
            $user = $currentUser;
        }

        $user->loadMissing(['mentor', 'batch']);
        $mentor = $user->mentor ?? User::where('role', 'mentor')->first();

        $projects = ShowcaseProject::where('creator_id', $user->id)->get();
        if ($projects->isEmpty() && $user->batch_id) {
            $projects = ShowcaseProject::where('batch_id', $user->batch_id)->get();
        }

        $jurnals = DailyJournal::where('user_id', $user->id)
            ->orderBy('journal_date', 'asc')
            ->get();

        return view('journals.portfolio_print', compact('user', 'mentor', 'projects', 'jurnals'));
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
        $this->authorizeMentorOrAdmin();

        $journals = DailyJournal::with(['user', 'mentor'])->latest('journal_date')->get();
        $pendingJournalsCount = DailyJournal::whereNull('mentor_feedback')->orWhere('mentor_feedback', '')->count();
        $reviewedJournalsCount = DailyJournal::whereNotNull('mentor_feedback')->where('mentor_feedback', '!=', '')->count();
        $pendingSubmissions = TaskSubmission::with(['task', 'user'])->where('status', 'submitted')->latest()->get();

        return view('mentor.review', compact('journals', 'pendingJournalsCount', 'reviewedJournalsCount', 'pendingSubmissions'));
    }

    public function mentorAddNote(Request $request, $id)
    {
        $user = $this->authorizeMentorOrAdmin();

        $journal = DailyJournal::with('user')->findOrFail($id);

        // Mencegah mentor lain atau siswa mengedit catatan logbook siswa yang bukan bimbingannya
        if ($user->role === 'mentor' && $journal->user && $journal->user->mentor_id && $journal->user->mentor_id !== $user->id) {
            abort(403, 'Akses Ditolak: Anda bukan mentor pembimbing resmi untuk siswa pemilik logbook ini.');
        }

        $request->validate([
            'mentor_feedback' => 'required|string',
        ]);

        $journal->update([
            'mentor_id' => $user->id,
            'mentor_feedback' => $request->mentor_feedback,
            'status' => 'approved',
        ]);

        return back()->with('success', 'Catatan & arahan bimbingan mentor berhasil disisipkan untuk siswa!');
    }

    public function approveJournal($id)
    {
        $user = $this->authorizeMentorOrAdmin();

        $journal = DailyJournal::with('user')->findOrFail($id);

        // Mencegah kecurangan self-approval atau mentor lain menyetujui di luar penugasannya
        if ($user->role === 'mentor' && $journal->user && $journal->user->mentor_id && $journal->user->mentor_id !== $user->id) {
            abort(403, 'Akses Ditolak: Anda bukan mentor pembimbing resmi untuk siswa pemilik logbook ini.');
        }

        $journal->update([
            'status' => 'approved',
            'mentor_id' => $user->role === 'mentor' ? $user->id : ($journal->mentor_id ?? $user->id),
            'mentor_feedback' => $journal->mentor_feedback ?: 'Aktivitas terverifikasi dan memenuhi standar dokumentasi kerja PT. Teknologi Multi Sistem.',
        ]);

        return back()->with('success', 'Jurnal berhasil ditandai dan disetujui!');
    }

    public function gradeSubmission(Request $request, $id)
    {
        $user = $this->authorizeMentorOrAdmin();

        $submission = TaskSubmission::with('user')->findOrFail($id);

        // Mencegah kecurangan self-grading siswa atau intervensi mentor yang tidak berwenang
        if ($user->role === 'mentor' && $submission->user && $submission->user->mentor_id && $submission->user->mentor_id !== $user->id) {
            abort(403, 'Akses Ditolak: Anda bukan mentor pembimbing untuk siswa pemilik tugas ini.');
        }

        $request->validate([
            'score' => 'required|numeric|min:0|max:100',
            'feedback' => 'nullable|string|max:1000',
        ]);

        $submission->update([
            'status' => 'approved',
            'score' => $request->score,
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

    public function guide()
    {
        $role = auth()->user()->role ?? 'siswa';
        return view('guide.index', compact('role'));
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

        $publicUrl = route('profile.public', $user->account_id ?? $user->username ?? $user->id);
        $qrCodeUrl = route('qr.generate', $user->account_id ?? $user->username ?? $user->id);

        return view('profile.index', compact(
            'user',
            'projects',
            'journals',
            'submissions',
            'evaluation',
            'totalContributions',
            'totalCommits',
            'totalJournals',
            'publicUrl',
            'qrCodeUrl'
        ));
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();
        
        $reservedUsernames = ['admin', 'administrator', 'root', 'system', 'superuser', 'mentor', 'siswa', 'tms', 'simak', 'staff', 'support', 'help', 'api'];

        $validated = $request->validate([
            'username' => [
                'nullable',
                'string',
                'min:3',
                'max:50',
                'alpha_dash',
                Rule::unique('users', 'username')->ignore($user->id),
                function ($attribute, $value, $fail) use ($user, $reservedUsernames) {
                    if ($user->role !== 'admin_tms' && in_array(strtolower($value), $reservedUsernames, true)) {
                        $fail("Username '{$value}' dicadangkan untuk sistem dan tidak dapat digunakan.");
                    }
                    if (User::where('account_id', $value)->where('id', '!=', $user->id)->exists()) {
                        $fail("Username '{$value}' bertabrakan dengan ID pengguna lain di sistem.");
                    }
                },
            ],
            'headline' => 'nullable|string|max:180',
            'bio' => 'nullable|string|max:1000',
            'github_url' => 'nullable|url|max:200',
            'linkedin_url' => 'nullable|url|max:200',
            'instagram_url' => 'nullable|url|max:200',
            'website_url' => 'nullable|url|max:200',
            'skills' => 'nullable|string|max:300',
            'location' => 'nullable|string|max:100',
            'avatar' => 'nullable|string',
        ], [
            'username.unique' => 'Username tersebut sudah digunakan oleh pengguna lain. Silakan pilih username lain.',
            'username.alpha_dash' => 'Username hanya boleh berisi huruf, angka, tanda strip (-), dan garis bawah (_).',
            'username.min' => 'Username minimal terdiri dari 3 karakter.',
        ]);

        $user->update($validated);

        return back()->with('success', 'Profil Developer & Tautan Media Sosial berhasil diperbarui!');
    }

    /**
     * Upload & Crop Avatar (Kamera & File Upload - Max 2MB, Rasio 1:1)
     * Dilengkapi validasi ekstensi ketat, allowlist MIME, serta verifikasi integritas bitmap
     */
    public function updateAvatar(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'avatar_file' => 'nullable|file|mimes:jpeg,png,jpg,webp|max:2048',
            'avatar_base64' => 'nullable|string',
        ]);

        $avatarPath = null;
        $dir = public_path('uploads/avatars');
        if (!file_exists($dir)) {
            mkdir($dir, 0755, true);
        }

        $allowedExts = ['jpg', 'jpeg', 'png', 'webp'];
        $allowedMimes = ['image/jpeg', 'image/png', 'image/webp'];

        if ($request->hasFile('avatar_file')) {
            $file = $request->file('avatar_file');
            
            // Validasi ukuran maksimal 2MB
            if ($file->getSize() > 2048 * 1024) {
                return response()->json([
                    'success' => false,
                    'message' => 'Ukuran file foto melebihi batas maksimal 2MB!'
                ], 422);
            }

            $mime = $file->getMimeType();
            if (!in_array($mime, $allowedMimes, true)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Format file gambar tidak diizinkan. Hanya file JPG, PNG, dan WebP yang diperbolehkan.'
                ], 422);
            }

            $ext = strtolower($file->getClientOriginalExtension());
            if (!in_array($ext, $allowedExts, true)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Ekstensi file tidak valid!'
                ], 422);
            }
            if ($ext === 'jpeg') $ext = 'jpg';

            $filename = 'avatar_' . $user->id . '_' . bin2hex(random_bytes(10)) . '.' . $ext;
            $file->move($dir, $filename);
            $avatarPath = '/uploads/avatars/' . $filename;
        } elseif ($request->filled('avatar_base64')) {
            $base64 = $request->input('avatar_base64');
            
            // Validasi format data URL dengan ekstensi ketat
            if (!preg_match('/^data:image\/(jpeg|jpg|png|webp);base64,([A-Za-z0-9+\/=\r\n]+)$/', $base64, $matches)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Format payload gambar base64 tidak valid atau ekstensi tidak diizinkan!'
                ], 422);
            }

            $ext = strtolower($matches[1]);
            if (!in_array($ext, $allowedExts, true)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Ekstensi file gambar tidak diizinkan.'
                ], 422);
            }
            if ($ext === 'jpeg') $ext = 'jpg';

            $decoded = base64_decode($matches[2], true);
            if ($decoded === false) {
                return response()->json([
                    'success' => false,
                    'message' => 'Data base64 gambar rusak atau tidak valid.'
                ], 422);
            }

            if (strlen($decoded) > 2048 * 1024) {
                return response()->json([
                    'success' => false,
                    'message' => 'Ukuran file hasil pemotongan melebihi batas 2MB!'
                ], 422);
            }

            // Validasi integritas bitmap gambar nyata (mencegah script berbahaya diselipkan)
            $imageInfo = @getimagesizefromstring($decoded);
            if (!$imageInfo || !isset($imageInfo['mime']) || !in_array($imageInfo['mime'], $allowedMimes, true)) {
                return response()->json([
                    'success' => false,
                    'message' => 'File terindikasi rusak atau bukan format gambar valid!'
                ], 422);
            }

            $filename = 'avatar_' . $user->id . '_' . bin2hex(random_bytes(10)) . '.' . $ext;
            file_put_contents($dir . '/' . $filename, $decoded);
            $avatarPath = '/uploads/avatars/' . $filename;
        }

        if ($avatarPath) {
            // Hapus file avatar lokal lama jika ada (agar hemat storage)
            if ($user->avatar && str_starts_with($user->avatar, '/uploads/avatars/')) {
                $oldFile = public_path(ltrim($user->avatar, '/'));
                if (file_exists($oldFile) && is_file($oldFile)) {
                    @unlink($oldFile);
                }
            }

            $user->update(['avatar' => $avatarPath]);

            if ($request->expectsJson() || $request->ajax() || $request->isJson() || $request->wantsJson() || $request->header('Content-Type') === 'application/json') {
                return response()->json([
                    'success' => true,
                    'avatar_url' => $avatarPath,
                    'message' => 'Foto profil berhasil diperbarui!'
                ]);
            }

            return back()->with('success', 'Foto profil berhasil diperbarui!');
        }

        return response()->json([
            'success' => false,
            'message' => 'Tidak ada file gambar yang valid untuk diproses.'
        ], 422);
    }

    /**
     * Public View-Only Profile Mode (Bebas diakses publik / read-only)
     * Tidak membuka celah sesi ataupun form edit profil
     */
    public function publicProfile($identifier)
    {
        $user = User::where('account_id', $identifier)
            ->orWhere('username', $identifier)
            ->orWhere('id', $identifier)
            ->first();

        if (!$user) {
            abort(404, 'Profil pengguna SIMAK-TMS tidak ditemukan.');
        }

        // Siswa yang belum terdaftar (belum memiliki ID & pembimbing mentor) belum bisa dibuka profilnya
        if ($user->role === 'siswa' && empty($user->account_id)) {
            if (Auth::check() && Auth::user()->role === 'admin_tms') {
                return redirect()->route('admin.students')->with('error', "Profil {$user->name} belum dapat diakses karena masih berstatus (belum terdaftar). Silakan klik Edit Data untuk memilih mentor terlebih dahulu agar ID resmi siswa diterbitkan.");
            }
            abort(404, 'Profil siswa belum tersedia karena siswa belum terdaftar resmi di PT. TMS.');
        }

        $projects = ShowcaseProject::where('creator_id', $user->id)->get();
        $evaluation = Evaluation::where('user_id', $user->id)->first();

        $totalJournals = DailyJournal::where('user_id', $user->id)->count();
        $totalProjects = $projects->count();
        $totalCommits = 47;
        $totalContributions = $totalCommits + $totalJournals + $totalProjects;

        $isOwner = Auth::check() && Auth::id() === $user->id;
        $publicUrl = route('profile.public', $user->account_id ?? $user->username ?? $user->id);
        $qrCodeUrl = route('qr.generate', $user->account_id ?? $user->username ?? $user->id);

        return view('profile.public', compact(
            'user',
            'projects',
            'evaluation',
            'totalJournals',
            'totalProjects',
            'totalContributions',
            'isOwner',
            'publicUrl',
            'qrCodeUrl'
        ));
    }

    /**
     * Generate & Serve Dynamic QR Code PNG
     */
    public function generateQr($identifier)
    {
        $user = User::where('account_id', $identifier)
            ->orWhere('username', $identifier)
            ->orWhere('id', $identifier)
            ->first();

        $targetUrl = route('profile.public', $user ? ($user->account_id ?? $user->username ?? $user->id) : $identifier);
        $remoteQrUrl = "https://api.qrserver.com/v1/create-qr-code/?size=300x300&data=" . urlencode($targetUrl);

        try {
            $ctx = stream_context_create([
                'http' => ['timeout' => 3],
                'ssl' => ['verify_peer' => false, 'verify_peer_name' => false]
            ]);
            $imageContent = @file_get_contents($remoteQrUrl, false, $ctx);
            if ($imageContent) {
                return response($imageContent)
                    ->header('Content-Type', 'image/png')
                    ->header('Access-Control-Allow-Origin', '*')
                    ->header('Cache-Control', 'public, max-age=86400');
            }
        } catch (\Exception $e) {}

        return redirect($remoteQrUrl);
    }

    // ==========================================
    // MENTOR DASHBOARD (MONITORING BATCH YANG SEKARANG)
    // ==========================================
    public function mentorDashboard()
    {
        $mentor = $this->authorizeMentorOrAdmin();
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
        $this->authorizeAdmin();

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

        // Telemetri Mingguan Riil dari Database (Senin s/d Sabtu Minggu Ini)
        $startOfWeek = now()->startOfWeek();
        $chartDataWeekly = [
            'labels' => ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'],
            'journals' => [],
            'tasks' => [] // Presensi Masuk Lab (siswa unik yang mencatat aktivitas / logbook)
        ];

        for ($i = 0; $i < 6; $i++) {
            $dayDate = $startOfWeek->copy()->addDays($i)->toDateString();
            $journalCount = DailyJournal::whereDate('journal_date', $dayDate)->count();
            $presenceCount = DailyJournal::whereDate('journal_date', $dayDate)->distinct('user_id')->count();

            $chartDataWeekly['journals'][] = $journalCount;
            $chartDataWeekly['tasks'][] = $presenceCount;
        }

        // Telemetri Bulanan Riil dari Database (Minggu 1 s/d Minggu 4 Bulan Berjalan)
        $currentYear = now()->year;
        $currentMonth = now()->month;
        $chartDataMonthly = [
            'labels' => ['Minggu 1', 'Minggu 2', 'Minggu 3', 'Minggu 4'],
            'journals' => [],
            'tasks' => []
        ];

        $monthRanges = [
            [
                \Carbon\Carbon::create($currentYear, $currentMonth, 1)->toDateString(),
                \Carbon\Carbon::create($currentYear, $currentMonth, 7)->toDateString()
            ],
            [
                \Carbon\Carbon::create($currentYear, $currentMonth, 8)->toDateString(),
                \Carbon\Carbon::create($currentYear, $currentMonth, 14)->toDateString()
            ],
            [
                \Carbon\Carbon::create($currentYear, $currentMonth, 15)->toDateString(),
                \Carbon\Carbon::create($currentYear, $currentMonth, 21)->toDateString()
            ],
            [
                \Carbon\Carbon::create($currentYear, $currentMonth, 22)->toDateString(),
                now()->endOfMonth()->toDateString()
            ],
        ];

        foreach ($monthRanges as $range) {
            $jCount = DailyJournal::whereBetween('journal_date', [$range[0], $range[1]])->count();
            $pCount = DailyJournal::whereBetween('journal_date', [$range[0], $range[1]])->distinct('user_id')->count();

            $chartDataMonthly['journals'][] = $jCount;
            $chartDataMonthly['tasks'][] = $pCount;
        }

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
            'totalProjects',
            'chartDataWeekly',
            'chartDataMonthly'
        ));
    }

    public function adminStudents(Request $request)
    {
        $this->authorizeAdmin();

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

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $interns = $query->latest()->get();
        $mentors = User::where('role', 'mentor')->get();
        $batches = Batch::all();
        $totalInterns = User::where('role', 'siswa')->count();
        $totalAlumni = User::where('role', 'siswa')->where('status', 'alumni')->count();
        $assignedInterns = User::where('role', 'siswa')->whereNotNull('mentor_id')->count();
        $evaluatedInterns = Evaluation::count();

        return view('admin.students', compact(
            'interns',
            'mentors',
            'batches',
            'totalInterns',
            'totalAlumni',
            'assignedInterns',
            'evaluatedInterns'
        ));
    }

    public function adminCreateTask(Request $request)
    {
        $this->authorizeAdmin();

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
        $this->authorizeAdmin();

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
        $mentor = $this->authorizeMentorOrAdmin();
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
        $this->authorizeAdmin();

        $student = User::where('role', 'siswa')->findOrFail($id);
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|unique:users,email,' . $student->id,
            'school_origin' => 'nullable|string|max:150',
            'major' => 'nullable|string|max:100',
            'mentor_id' => 'nullable|exists:users,id',
            'status' => 'nullable|in:aktif,selesai,alumni',
            'alumni_status' => 'nullable|string|max:50',
            'alumni_current_at' => 'nullable|string|max:150',
        ]);

        $generatedMsg = '';
        // Jika sebelumnya belum memiliki ID Akun (belum terdaftar) dan sekarang mentor dipilih:
        if (empty($student->account_id) && !empty($validated['mentor_id'])) {
            $newAccountId = $this->generateUniqueAccountId();
            $validated['account_id'] = $newAccountId;
            $validated['username'] = $newAccountId;
            $generatedMsg = " ID Akun resmi ({$newAccountId}) telah berhasil diterbitkan dan aktif!";
        }

        $student->update($validated);

        return back()->with('success', "Data siswa {$student->name} berhasil diperbarui oleh Admin!{$generatedMsg}");
    }

    public function adminGraduateStudent(Request $request, $id)
    {
        $this->authorizeAdmin();

        $student = User::where('role', 'siswa')->findOrFail($id);
        $newStatus = $request->input('status', 'alumni');

        if ($newStatus === 'alumni') {
            $student->update([
                'status' => 'alumni',
                'alumni_status' => $request->input('alumni_status', $student->alumni_status ?? 'bekerja'),
                'alumni_current_at' => $request->input('alumni_current_at', $student->alumni_current_at)
            ]);
            return back()->with('success', "Siswa {$student->name} berhasil dialihkan menjadi Alumni Magang (Lulus PKL). Semua data portofolio, sertifikat, dan logbook tetap tersimpan aman!");
        } else {
            $student->update([
                'status' => 'aktif'
            ]);
            return back()->with('success', "Status siswa {$student->name} berhasil dikembalikan menjadi Siswa Aktif Magang.");
        }
    }

    public function adminDeleteStudent($id)
    {
        $this->authorizeAdmin();

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
        $this->authorizeAdmin();

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
        $this->authorizeAdmin();

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
        $this->authorizeAdmin();

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
        $this->authorizeAdmin();

        $mentor = User::where('role', 'mentor')->findOrFail($id);
        $name = $mentor->name;

        // Cari mentor pengganti atau admin sebagai penampung relasi data kritis
        $fallbackUser = User::where('role', 'mentor')->where('id', '!=', $mentor->id)->first()
            ?? User::where('role', 'admin_tms')->first();

        // Mencegah MySQL cascadeOnDelete menghapus sertifikat kelulusan siswa & tugas yang pernah dibuat
        if ($fallbackUser) {
            Evaluation::where('mentor_id', $mentor->id)->update(['mentor_id' => $fallbackUser->id]);
            Task::where('mentor_id', $mentor->id)->update(['mentor_id' => $fallbackUser->id]);
            DailyJournal::where('mentor_id', $mentor->id)->update(['mentor_id' => $fallbackUser->id]);
        }

        // Lepaskan siswa dari mentor yang dihapus agar dapat dipilihkan mentor baru
        User::where('mentor_id', $mentor->id)->update(['mentor_id' => null]);

        $mentor->delete();

        return back()->with('success', "Akun mentor {$name} berhasil dihapus dari sistem. Seluruh sertifikat & riwayat evaluasi siswa tetap aman dan dialihkan.");
    }

    // ==========================================
    // RESET PASSWORD PENGGUNA OLEH ADMIN TMS
    // ==========================================
    public function adminResetPassword($id)
    {
        $this->authorizeAdmin();

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

    // ==========================================
    // VERIFIKASI SERTIFIKAT PUBLIK DUDI PT. TMS
    // ==========================================
    public function verifyIndex(Request $request)
    {
        $search = trim($request->get('q', ''));
        if ($search) {
            return redirect()->route('verify.show', $search);
        }

        $recentVerifications = Evaluation::with(['user', 'mentor'])
            ->whereNotNull('certificate_number')
            ->latest('issue_date')
            ->take(5)
            ->get();

        return view('certificate.verify_search', compact('recentVerifications'));
    }

    public function verifyShow($certificate_number)
    {
        $certNo = trim($certificate_number);

        // Find evaluation by certificate_number or account_id / NIS
        $evaluation = Evaluation::with(['user.mentor', 'user.batch', 'mentor'])
            ->where('certificate_number', $certNo)
            ->orWhereHas('user', function ($q) use ($certNo) {
                $q->where('account_id', $certNo)
                  ->orWhere('nis_nim', $certNo)
                  ->orWhere('username', $certNo);
            })
            ->first();

        if (!$evaluation || empty($evaluation->user) || empty($evaluation->user->mentor_id) || empty($evaluation->user->account_id) || !$evaluation->is_published) {
            return response()->view('certificate.verify_not_found', ['certificate_number' => $certNo], 404);
        }

        $student = $evaluation->user;
        $mentor = $evaluation->mentor ?? $student->mentor;
        $batch = $student->batch ?? Batch::first();

        // Projects built by this student or in this batch (>1 project per batch)
        $projects = ShowcaseProject::where('batch_id', $batch ? $batch->id : 1)
            ->orWhere('creator_id', $student->id)
            ->get();

        return view('certificate.verify', compact('evaluation', 'student', 'mentor', 'batch', 'projects', 'certNo'));
    }

    public function apiVerify($certificate_number)
    {
        $certNo = trim($certificate_number);

        $evaluation = Evaluation::with(['user.mentor', 'user.batch', 'mentor'])
            ->where('certificate_number', $certNo)
            ->orWhereHas('user', function ($q) use ($certNo) {
                $q->where('account_id', $certNo)
                  ->orWhere('nis_nim', $certNo)
                  ->orWhere('username', $certNo);
            })
            ->first();

        if (!$evaluation || empty($evaluation->user) || empty($evaluation->user->mentor_id) || empty($evaluation->user->account_id) || !$evaluation->is_published) {
            return response()->json([
                'found' => false,
                'message' => 'Sertifikat tidak ditemukan atau belum diterbitkan secara resmi oleh PT. TMS.'
            ], 404);
        }

        $student = $evaluation->user;
        $mentor = $evaluation->mentor ?? $student->mentor;
        $batch = $student->batch ?? Batch::first();

        return response()->json([
            'found' => true,
            'certificate_number' => $evaluation->certificate_number,
            'student_name' => $student->name,
            'nis_nim' => $student->nis_nim ?? $student->account_id,
            'school_origin' => $student->school_origin ?? 'SMKN 1 Ciamis',
            'department' => $student->department ?? 'Pengembangan Perangkat Lunak & Gim (PPLG)',
            'batch_name' => $batch ? $batch->batch_name : 'Angkatan 2026 - Gelombang 1',
            'internship_period' => $student->internship_period ?? '16 Nov 2026 - 16 Apr 2027',
            'mentor_name' => $mentor ? $mentor->name : 'Mentor Teknis TMS',
            'final_score' => $evaluation->final_score ?? 92.5,
            'predicate' => $evaluation->predicate ?? 'Sangat Memuaskan (A)',
            'issue_date' => $evaluation->issue_date ? \Carbon\Carbon::parse($evaluation->issue_date)->translatedFormat('d F Y') : '16 April 2027',
            'verify_url' => route('verify.show', $evaluation->certificate_number),
            'print_url' => route('certificate.print', $evaluation->certificate_number),
        ]);
    }

    public function printCertificate($certificate_number)
    {
        $certNo = trim($certificate_number);

        $evaluation = Evaluation::with(['user.mentor', 'user.batch', 'mentor'])
            ->where('certificate_number', $certNo)
            ->orWhereHas('user', function ($q) use ($certNo) {
                $q->where('account_id', $certNo);
            })
            ->first();

        if (!$evaluation || empty($evaluation->user) || empty($evaluation->user->mentor_id) || empty($evaluation->user->account_id) || !$evaluation->is_published) {
            abort(403, 'Sertifikat kelulusan belum dapat dicetak. Siswa masih berstatus magang aktif atau belum menyelesaikan evaluasi nilai akhir oleh pembimbing mentor industri PT. TMS.');
        }

        $student = $evaluation->user;
        $mentor = $evaluation->mentor ?? $student->mentor;
        $batch = $student->batch ?? Batch::first();

        return view('certificate.print', compact('evaluation', 'student', 'mentor', 'batch', 'certNo'));
    }

    // ==========================================
    // ADMIN: ANGKATAN & PROJECT PER ANGKATAN
    // ==========================================
    public function adminBatches(Request $request)
    {
        $this->authorizeAdmin();

        $batches = Batch::withCount(['users', 'showcaseProjects'])->get();
        $selectedBatchId = $request->get('batch_id', $batches->first()->id ?? 1);
        $selectedBatch = Batch::find($selectedBatchId) ?? $batches->first();

        $projects = ShowcaseProject::with(['batch', 'creator'])
            ->where('batch_id', $selectedBatchId)
            ->latest()
            ->get();

        $students = User::where('role', 'siswa')->get();

        return view('admin.batches', compact('batches', 'selectedBatchId', 'selectedBatch', 'projects', 'students'));
    }

    public function adminStoreBatch(Request $request)
    {
        $this->authorizeAdmin();

        $request->validate([
            'batch_name' => 'required|string|max:100',
            'period_year' => 'required|integer|min:2020|max:2035',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        Batch::create([
            'batch_name' => $request->batch_name,
            'period_year' => $request->period_year,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'is_active' => $request->boolean('is_active', true),
        ]);

        return back()->with('success', 'Data angkatan PKL baru berhasil ditambahkan!');
    }

    public function adminUpdateBatch(Request $request, $id)
    {
        $this->authorizeAdmin();

        $batch = Batch::findOrFail($id);
        $batch->update([
            'batch_name' => $request->batch_name,
            'period_year' => $request->period_year,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'is_active' => $request->boolean('is_active', true),
        ]);

        return back()->with('success', 'Data angkatan berhasil diperbarui!');
    }

    public function adminStoreProject(Request $request)
    {
        $this->authorizeAdmin();

        $request->validate([
            'batch_id' => 'required|exists:batches,id',
            'title' => 'required|string|max:200',
            'tech_stack' => 'required|string|max:255',
            'project_category' => 'required|string|max:80',
            'team_members' => 'required|string|max:255',
            'short_description' => 'required|string|max:255',
            'status' => 'required|string|max:50',
            'live_url' => 'nullable|string',
            'repo_url' => 'nullable|string',
        ]);

        $creatorId = $request->creator_id ?? User::where('role', 'siswa')->value('id') ?? Auth::id();

        ShowcaseProject::create([
            'batch_id' => $request->batch_id,
            'creator_id' => $creatorId,
            'title' => $request->title,
            'tech_stack' => $request->tech_stack,
            'project_category' => $request->project_category,
            'team_members' => $request->team_members,
            'short_description' => $request->short_description,
            'full_description' => $request->full_description ?? $request->short_description,
            'status' => $request->status,
            'live_url' => $request->live_url,
            'repo_url' => $request->repo_url,
            'is_featured' => $request->boolean('is_featured', true),
        ]);

        return back()->with('success', 'Project baru untuk angkatan berhasil dipublikasikan!');
    }

    public function adminUpdateProject(Request $request, $id)
    {
        $this->authorizeAdmin();

        $project = ShowcaseProject::findOrFail($id);
        $project->update([
            'batch_id' => $request->batch_id ?? $project->batch_id,
            'title' => $request->title,
            'tech_stack' => $request->tech_stack,
            'project_category' => $request->project_category ?? $project->project_category,
            'team_members' => $request->team_members,
            'short_description' => $request->short_description,
            'status' => $request->status ?? $project->status,
            'live_url' => $request->live_url,
            'repo_url' => $request->repo_url,
        ]);

        return back()->with('success', 'Data project angkatan berhasil diperbarui!');
    }

    public function adminDeleteProject($id)
    {
        $this->authorizeAdmin();

        $project = ShowcaseProject::findOrFail($id);
        $title = $project->title;
        $project->delete();

        return back()->with('success', "Project \"{$title}\" berhasil dihapus.");
    }

    // ==========================================
    // ADMIN: ASAL INSTANSI (SEKOLAH / KAMPUS MITRA)
    // ==========================================
    public function adminInstitutions()
    {
        $this->authorizeAdmin();

        $institutions = PartnerInstitution::withCount('students')->get();
        $totalInstitutions = $institutions->count();
        $smkCount = $institutions->where('type', 'SMK')->count();
        $campusCount = $institutions->whereIn('type', ['Universitas', 'Politeknik'])->count();

        return view('admin.institutions', compact('institutions', 'totalInstitutions', 'smkCount', 'campusCount'));
    }

    public function adminStoreInstitution(Request $request)
    {
        $this->authorizeAdmin();

        $request->validate([
            'name' => 'required|string|max:150',
            'type' => 'required|string|max:50',
            'city' => 'required|string|max:100',
            'pic_name' => 'required|string|max:150',
            'pic_phone' => 'required|string|max:30',
        ]);

        PartnerInstitution::create([
            'name' => $request->name,
            'type' => $request->type,
            'address' => $request->address,
            'city' => $request->city,
            'pic_name' => $request->pic_name,
            'pic_phone' => $request->pic_phone,
            'pic_email' => $request->pic_email,
            'mou_number' => $request->mou_number ?? ('MoU/TMS-' . strtoupper(substr(preg_replace('/[^A-Za-z0-9]/', '', $request->name), 0, 6)) . '/' . date('Y') . '/' . rand(100, 999)),
            'mou_date' => $request->mou_date ?? now()->toDateString(),
            'status' => 'aktif',
        ]);

        return back()->with('success', 'Data sekolah/kampus mitra baru berhasil didaftarkan!');
    }

    public function adminUpdateInstitution(Request $request, $id)
    {
        $this->authorizeAdmin();

        $inst = PartnerInstitution::findOrFail($id);
        $inst->update([
            'name' => $request->name,
            'type' => $request->type,
            'address' => $request->address,
            'city' => $request->city,
            'pic_name' => $request->pic_name,
            'pic_phone' => $request->pic_phone,
            'pic_email' => $request->pic_email,
            'mou_number' => $request->mou_number,
            'status' => $request->status ?? 'aktif',
        ]);

        return back()->with('success', 'Data instansi mitra berhasil diperbarui!');
    }

    public function adminDeleteInstitution($id)
    {
        $this->authorizeAdmin();

        $inst = PartnerInstitution::findOrFail($id);
        $name = $inst->name;
        $inst->delete();

        return back()->with('success', "Data mitra {$name} berhasil dihapus.");
    }

    // ==========================================
    // ADMIN: SET / EVALUASI NILAI SERTIFIKAT SISWA
    // ==========================================
    public function adminSaveEvaluation(Request $request, $userId)
    {
        $this->authorizeAdmin();

        $user = User::where('role', 'siswa')->findOrFail($userId);

        if (empty($user->account_id) || empty($user->mentor_id)) {
            return back()->with('error', "Siswa {$user->name} berstatus (belum terdaftar) / belum memiliki mentor pembimbing. Silakan tentukan mentor dan terbitkan ID akun resmi 5-digit terlebih dahulu sebelum menerbitkan nilai rapor & sertifikat.");
        }

        $validated = $request->validate([
            'technical_skill' => 'required|numeric|min:0|max:100',
            'discipline' => 'required|numeric|min:0|max:100',
            'teamwork' => 'required|numeric|min:0|max:100',
            'initiative' => 'required|numeric|min:0|max:100',
            'certificate_number' => 'nullable|string|max:100',
            'issue_date' => 'nullable|date',
            'general_notes' => 'nullable|string|max:1000',
        ], [
            'technical_skill.required' => 'Nilai teknis wajib diisi (0-100).',
            'technical_skill.numeric' => 'Nilai teknis harus berupa angka.',
            'technical_skill.min' => 'Nilai teknis minimal 0.',
            'technical_skill.max' => 'Nilai teknis maksimal 100.',
            'discipline.required' => 'Nilai disiplin wajib diisi (0-100).',
            'teamwork.required' => 'Nilai teamwork wajib diisi (0-100).',
            'initiative.required' => 'Nilai inisiatif wajib diisi (0-100).',
        ]);

        $tech = (float)$validated['technical_skill'];
        $disc = (float)$validated['discipline'];
        $team = (float)$validated['teamwork'];
        $init = (float)$validated['initiative'];

        // Bobot Industri TMS: Teknis 35%, Disiplin 25%, Teamwork 20%, Inisiatif 20%
        $finalScore = round(($tech * 0.35) + ($disc * 0.25) + ($team * 0.20) + ($init * 0.20), 1);
        $certNo = !empty($validated['certificate_number']) 
            ? trim($validated['certificate_number']) 
            : ('TMS-CERT-' . date('Y') . '-' . $user->account_id);

        Evaluation::updateOrCreate(
            ['user_id' => $user->id],
            [
                'mentor_id' => $user->mentor_id ?? User::where('role', 'mentor')->value('id') ?? Auth::id(),
                'technical_skill' => $tech,
                'discipline' => $disc,
                'teamwork' => $team,
                'initiative' => $init,
                'final_score' => $finalScore,
                'certificate_number' => $certNo,
                'issue_date' => $validated['issue_date'] ?? now()->toDateString(),
                'is_published' => true,
                'general_notes' => $validated['general_notes'] ?? 'Peserta menunjukkan progres koding sangat baik dan integritas disiplin kerja industri memuaskan.',
            ]
        );

        return back()->with('success', "Nilai evaluasi & sertifikat resmi ({$certNo}) untuk {$user->name} berhasil disimpan dan diterbitkan!");
    }

    // ==========================================
    // PENDAFTARAN PKL ONLINE (/registry-pkl)
    // ==========================================
    private function generateUniqueRegistrationCode(): string
    {
        do {
            $code = 'TMS-REG-' . mt_rand(10000, 99999);
        } while (PklRegistration::where('registration_code', $code)->exists());

        return $code;
    }

    public function registryIndex(Request $request)
    {
        $activeTab = $request->get('tab', 'register');
        $searchedCode = $request->get('code', null);
        $searchResult = null;

        if ($searchedCode) {
            $searchResult = PklRegistration::with('user.mentor')
                ->where('registration_code', strtoupper(trim($searchedCode)))
                ->first();
        }

        $activeBatch = Batch::where('is_active', true)->first() ?? Batch::first();

        return view('registry.index', compact('activeTab', 'searchedCode', 'searchResult', 'activeBatch'));
    }

    public function registryStore(Request $request)
    {
        $validated = $request->validate([
            'full_name' => 'required|string|max:100',
            'gender' => 'required|in:Laki-laki,Perempuan',
            'nis' => 'required|string|max:40',
            'birth_place' => 'nullable|string|max:100',
            'birth_date' => 'nullable|date',
            'religion' => 'nullable|string|max:50',
            'skill_competency' => 'required|string|max:100',
            'school_origin' => 'nullable|string|max:150',
            'email' => 'required|email|max:150|unique:users,email',
            'phone_number' => 'required|string|max:30',
        ], [
            'email.unique' => 'Email ini sudah terdaftar sebagai akun aktif di SIMAK-TMS. Silakan login atau gunakan email lain.',
        ]);

        // Cek pendaftaran pending duplikat dengan email yang sama
        $existingPending = PklRegistration::where('email', $validated['email'])
            ->where('status', 'pending')
            ->first();

        if ($existingPending) {
            return redirect()->route('registry.index', [
                'tab' => 'check',
                'code' => $existingPending->registration_code,
            ])->with('info', "Anda sudah memiliki pendaftaran antrian aktif dengan kode: {$existingPending->registration_code}. Silakan tunggu verifikasi admin.");
        }

        $regCode = $this->generateUniqueRegistrationCode();

        $registration = PklRegistration::create([
            'registration_code' => $regCode,
            'full_name' => $validated['full_name'],
            'gender' => $validated['gender'],
            'nis' => $validated['nis'],
            'birth_place' => $validated['birth_place'] ?? null,
            'birth_date' => $validated['birth_date'] ?? null,
            'religion' => $validated['religion'] ?? null,
            'skill_competency' => $validated['skill_competency'],
            'school_origin' => $validated['school_origin'] ?? 'SMKN 1 Ciamis',
            'email' => $validated['email'],
            'phone_number' => $validated['phone_number'],
            'status' => 'pending',
        ]);

        return redirect()->route('registry.index', [
            'tab' => 'check',
            'code' => $regCode,
        ])->with('registration_success', [
            'code' => $regCode,
            'name' => $validated['full_name'],
            'nis' => $validated['nis'],
        ]);
    }

    public function registryCheck(Request $request)
    {
        $code = strtoupper(trim($request->get('code', '')));
        if (empty($code)) {
            return redirect()->route('registry.index', ['tab' => 'check'])->withErrors(['code' => 'Masukkan kode antrian pendaftaran Anda.']);
        }

        $searchResult = PklRegistration::with('user.mentor')
            ->where('registration_code', $code)
            ->first();

        return view('registry.index', [
            'activeTab' => 'check',
            'searchedCode' => $code,
            'searchResult' => $searchResult,
            'activeBatch' => Batch::where('is_active', true)->first() ?? Batch::first(),
        ]);
    }

    // ==========================================
    // ADMIN: MANAJEMEN PENDAFTARAN PKL
    // ==========================================
    public function adminRegistrations(Request $request)
    {
        $this->authorizeAdmin();

        $status = $request->get('status', 'all');

        $query = PklRegistration::with('user.mentor')->latest();
        if ($status !== 'all' && in_array($status, ['pending', 'approved', 'rejected'])) {
            $query->where('status', $status);
        }

        $registrations = $query->get();

        $counts = [
            'all' => PklRegistration::count(),
            'pending' => PklRegistration::where('status', 'pending')->count(),
            'approved' => PklRegistration::where('status', 'approved')->count(),
            'rejected' => PklRegistration::where('status', 'rejected')->count(),
        ];

        $mentors = User::where('role', 'mentor')->get();

        return view('admin.registrations', compact('registrations', 'counts', 'status', 'mentors'));
    }

    public function adminApproveRegistration(Request $request, $id)
    {
        $this->authorizeAdmin();

        $reg = PklRegistration::findOrFail($id);

        if ($reg->status === 'approved') {
            return back()->with('info', "Pendaftaran {$reg->full_name} sudah disetujui sebelumnya.");
        }

        // Mencegah crash SQL 1062 Integrity Constraint jika email sudah terdaftar di users
        if (User::where('email', $reg->email)->exists()) {
            return back()->with('error', "Gagal menyetujui: Email '{$reg->email}' sudah digunakan oleh pengguna lain di sistem. Silakan periksa atau ubah data pendaftar.");
        }

        $activeBatch = Batch::where('is_active', true)->first() ?? Batch::first();

        // 1. Autofill ke tabel User sebagai siswa PKL baru
        // Sesuai instruksi: mentor_id = null (belum memilih mentor), account_id = null (belum terdaftar)
        $user = User::create([
            'name' => $reg->full_name,
            'role' => 'siswa',
            'email' => $reg->email,
            'phone_number' => $reg->phone_number,
            'school_origin' => $reg->school_origin ?? 'SMKN 1 Ciamis',
            'major' => $reg->skill_competency,
            'nis_nim' => $reg->nis,
            'batch_id' => $activeBatch ? $activeBatch->id : 1,
            'mentor_id' => null,  // ALERT: Belum memilih mentor!
            'account_id' => null, // ALERT: (belum terdaftar)
            'username' => null,
            'password' => Hash::make('tmshebatsukses'),
            'must_change_password' => 1,
            'status' => 'aktif',
            'avatar' => 'https://ui-avatars.com/api/?name=' . urlencode($reg->full_name) . '&background=ef4444&color=ffffff&bold=true&size=256',
        ]);

        // 2. Update status pendaftaran
        $reg->update([
            'status' => 'approved',
            'user_id' => $user->id,
        ]);

        return redirect()->route('admin.students')->with('success', "Pendaftaran {$reg->full_name} berhasil disetujui! Siswa telah otomatis masuk ke Data Siswa dengan status (Belum Terdaftar). Silakan klik tombol 'Edit' untuk memilih mentor pembimbing dan menerbitkan ID akun resmi 5-digit.");
    }

    public function adminRejectRegistration(Request $request, $id)
    {
        $this->authorizeAdmin();

        $reg = PklRegistration::findOrFail($id);
        $reason = $request->input('rejection_reason', 'Mohon maaf, kuota penerimaan magang periode ini telah penuh / kualifikasi belum memenuhi.');

        $reg->update([
            'status' => 'rejected',
            'rejection_reason' => $reason,
        ]);

        return back()->with('success', "Pendaftaran atas nama {$reg->full_name} telah ditolak.");
    }

    public function adminDeleteRegistration($id)
    {
        $this->authorizeAdmin();

        $reg = PklRegistration::findOrFail($id);
        $name = $reg->full_name;
        $reg->delete();

        return back()->with('success', "Data antrian pendaftaran {$name} berhasil dihapus.");
    }
}
