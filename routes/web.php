<?php

use App\Http\Controllers\SimakController;
use Illuminate\Support\Facades\Route;

// Root URL: Jika sesi sudah tersimpan / aktif, langsung buka dashboard; jika belum, ke login
Route::get('/', function () {
    if (\Illuminate\Support\Facades\Auth::check()) {
        return redirect()->route('dashboard');
    }
    return redirect()->route('login');
});

// Pusat Bantuan, SOP & FAQ Resmi SIMAK-TMS (Aman, Solutif, Publik & Bebas Akses)
Route::get('/faq', [SimakController::class, 'faq'])->name('faq');
Route::get('/support', function () {
    return redirect()->route('faq');
})->name('support');
Route::get('/informasi', function () {
    return redirect()->route('faq');
})->name('informasi');

// Verifikasi Sertifikat Publik & E-Sertifikat DUDI (Akses Publik Tanpa Login)
Route::get('/verifikasi', [SimakController::class, 'verifyIndex'])->name('verify.index');
Route::get('/verifikasi/{certificate_number}', [SimakController::class, 'verifyShow'])->name('verify.show');
Route::get('/api/verify/{certificate_number}', [SimakController::class, 'apiVerify'])->name('api.verify');
Route::get('/verify/{certificate_number}', function ($certificate_number) {
    return redirect()->route('verify.show', $certificate_number);
});
Route::get('/sertifikat/{certificate_number}', function ($certificate_number) {
    return redirect()->route('verify.show', $certificate_number);
});
Route::get('/sertifikat/{certificate_number}/cetak', [SimakController::class, 'printCertificate'])->name('certificate.print');

// Preview routes for testing (Auto-login & redirect to real named routes)
Route::get('/preview/verifikasi', function () {
    $eval = \App\Models\Evaluation::first();
    $cert = $eval ? $eval->certificate_number : 'TMS-CERT-2026-20239';
    return redirect()->route('verify.show', $cert);
})->name('preview.verifikasi');

Route::get('/preview/sertifikat', function () {
    $eval = \App\Models\Evaluation::first();
    $cert = $eval ? $eval->certificate_number : 'TMS-CERT-2026-20239';
    return redirect()->route('certificate.print', $cert);
})->name('preview.sertifikat');

Route::get('/preview/admin/angkatan', function () {
    $admin = \App\Models\User::where('role', 'admin_tms')->first();
    \Illuminate\Support\Facades\Auth::login($admin);
    return redirect()->route('admin.batches');
})->name('preview.admin.batches');

Route::get('/preview/admin/instansi', function () {
    $admin = \App\Models\User::where('role', 'admin_tms')->first();
    \Illuminate\Support\Facades\Auth::login($admin);
    return redirect()->route('admin.institutions');
})->name('preview.admin.institutions');

// Preview routes for testing (Auto-login & redirect to real named routes)
Route::get('/preview/dashboard', function () {
    $user = \App\Models\User::first();
    \Illuminate\Support\Facades\Auth::login($user);
    return redirect()->route('dashboard');
})->name('preview.dashboard');

Route::get('/preview/informasi', function () {
    $user = \App\Models\User::first();
    \Illuminate\Support\Facades\Auth::login($user);
    return redirect()->route('informasi');
})->name('preview.informasi');

Route::get('/preview/tugas', function () {
    $user = \App\Models\User::first();
    \Illuminate\Support\Facades\Auth::login($user);
    return redirect()->route('showcase.index');
})->name('preview.tugas');

Route::get('/preview/jurnal', function () {
    $user = \App\Models\User::first();
    \Illuminate\Support\Facades\Auth::login($user);
    return redirect()->route('journals.index');
})->name('preview.jurnal');

Route::get('/preview/jurnal/cetak', function () {
    $user = \App\Models\User::where('role', 'siswa')->first();
    \Illuminate\Support\Facades\Auth::login($user);
    return redirect()->route('journals.print');
})->name('preview.journals.print');

Route::get('/preview/jurnal/portofolio', function () {
    $user = \App\Models\User::where('role', 'siswa')->first();
    \Illuminate\Support\Facades\Auth::login($user);
    return redirect()->route('journals.portfolio.print');
})->name('preview.journals.portfolio.print');

Route::get('/preview/arsip', function () {
    $user = \App\Models\User::first();
    \Illuminate\Support\Facades\Auth::login($user);
    return redirect()->route('showcase.index');
})->name('preview.arsip');

Route::get('/preview/evaluasi', function () {
    $user = \App\Models\User::first();
    \Illuminate\Support\Facades\Auth::login($user);
    return redirect()->route('evaluation.index');
})->name('preview.evaluasi');

Route::get('/preview/review', function () {
    $mentor = \App\Models\User::where('role', 'mentor')->first();
    \Illuminate\Support\Facades\Auth::login($mentor);
    return redirect()->route('mentor.review');
})->name('preview.review');

Route::get('/preview/mentor', function () {
    $mentor = \App\Models\User::where('role', 'mentor')->first();
    \Illuminate\Support\Facades\Auth::login($mentor);
    return redirect()->route('mentor.dashboard');
})->name('preview.mentor');

Route::get('/preview/mentor/siswa', function () {
    $mentor = \App\Models\User::where('role', 'mentor')->first();
    \Illuminate\Support\Facades\Auth::login($mentor);
    return redirect()->route('mentor.students');
})->name('preview.mentor.students');

Route::get('/preview/profile', function () {
    $user = \App\Models\User::where('role', 'siswa')->first();
    \Illuminate\Support\Facades\Auth::login($user);
    return redirect()->route('profile');
})->name('preview.profile');

Route::get('/preview/admin/profile', function () {
    $admin = \App\Models\User::where('role', 'admin_tms')->first();
    \Illuminate\Support\Facades\Auth::login($admin);
    return redirect()->route('profile');
})->name('preview.admin.profile');

Route::get('/preview/admin', function () {
    $admin = \App\Models\User::where('role', 'admin_tms')->first();
    \Illuminate\Support\Facades\Auth::login($admin);
    return redirect()->route('admin.dashboard');
})->name('preview.admin');

Route::get('/preview/admin/siswa', function () {
    $admin = \App\Models\User::where('role', 'admin_tms')->first();
    \Illuminate\Support\Facades\Auth::login($admin);
    return redirect()->route('admin.students');
})->name('preview.admin.students');

Route::get('/preview/admin/mentor', function () {
    $admin = \App\Models\User::where('role', 'admin_tms')->first();
    \Illuminate\Support\Facades\Auth::login($admin);
    return redirect()->route('admin.mentors');
})->name('preview.admin.mentors');

// Authentication routes
Route::get('/login', [SimakController::class, 'showLogin'])->name('login');
Route::post('/login', [SimakController::class, 'login'])->name('login.post');
Route::get('/login/quick/{role}', [SimakController::class, 'quickLogin'])->name('login.quick');
Route::post('/logout', [SimakController::class, 'logout'])->name('logout');

// Public View-Only Profile Mode & Dynamic QR Code (Aman & Bebas Akses Tanpa Login)
Route::get('/p/{identifier}', [SimakController::class, 'publicProfile'])->name('profile.public');
Route::get('/qr/{identifier}', [SimakController::class, 'generateQr'])->name('qr.generate');

// Protected routes (Must be logged in!)
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [SimakController::class, 'dashboard'])->name('dashboard');
    Route::get('/panduan', [SimakController::class, 'guide'])->name('guide.index');
    
    // LMS & Tasks (Deprecated - Redirected to Showcase Portofolio)
    Route::get('/tugas', function () {
        return redirect()->route('showcase.index');
    })->name('tasks.index');

    // Daily Journals (Logbook)
    Route::get('/jurnal', [SimakController::class, 'journals'])->name('journals.index');
    Route::get('/jurnal/cetak', [SimakController::class, 'printJournal'])->name('journals.print');
    Route::get('/jurnal/portofolio/cetak', [SimakController::class, 'printPortfolio'])->name('journals.portfolio.print');
    Route::post('/jurnal', [SimakController::class, 'storeJournal'])->name('journals.store');

    // Showcase & Archive
    Route::get('/arsip', [SimakController::class, 'showcase'])->name('showcase.index');

    // Evaluations & Score
    Route::get('/evaluasi', [SimakController::class, 'evaluation'])->name('evaluation.index');

    // Mentor Review & Monitoring Hub
    Route::get('/mentor/monitoring', [SimakController::class, 'mentorDashboard'])->name('mentor.dashboard');
    Route::get('/mentor/siswa', [SimakController::class, 'mentorStudents'])->name('mentor.students');
    Route::get('/mentor/review', [SimakController::class, 'mentorReview'])->name('mentor.review');
    Route::post('/mentor/jurnal/{id}/approve', [SimakController::class, 'approveJournal'])->name('mentor.journal.approve');
    Route::post('/mentor/jurnal/{id}/catatan', [SimakController::class, 'mentorAddNote'])->name('mentor.journal.note');
    Route::post('/mentor/tugas/{id}/grade', [SimakController::class, 'gradeSubmission'])->name('mentor.task.grade');

    // Developer Profile ala GitHub
    Route::get('/profil', [SimakController::class, 'profile'])->name('profile');
    Route::post('/profil', [SimakController::class, 'updateProfile'])->name('profile.update');
    Route::post('/password/update', [SimakController::class, 'updatePassword'])->name('password.update');

    // Admin TMS Management Hub
    Route::get('/admin', [SimakController::class, 'adminDashboard'])->name('admin.dashboard');
    Route::get('/admin/siswa', [SimakController::class, 'adminStudents'])->name('admin.students');
    Route::put('/admin/siswa/{id}', [SimakController::class, 'adminUpdateStudent'])->name('admin.students.update');
    Route::delete('/admin/siswa/{id}', [SimakController::class, 'adminDeleteStudent'])->name('admin.students.destroy');
    Route::get('/admin/mentor', [SimakController::class, 'adminMentors'])->name('admin.mentors');
    Route::post('/admin/mentor', [SimakController::class, 'adminStoreMentor'])->name('admin.mentors.store');
    Route::put('/admin/mentor/{id}', [SimakController::class, 'adminUpdateMentor'])->name('admin.mentors.update');
    Route::delete('/admin/mentor/{id}', [SimakController::class, 'adminDeleteMentor'])->name('admin.mentors.destroy');
    Route::post('/admin/users/{id}/reset-password', [SimakController::class, 'adminResetPassword'])->name('admin.users.reset_password');
    Route::post('/admin/tugas', [SimakController::class, 'adminCreateTask'])->name('admin.tasks.store');
    Route::post('/admin/users', [SimakController::class, 'adminStoreUser'])->name('admin.users.store');

    // Admin Angkatan & Project per Angkatan (1 Angkatan > 1 Project)
    Route::get('/admin/angkatan', [SimakController::class, 'adminBatches'])->name('admin.batches');
    Route::post('/admin/angkatan', [SimakController::class, 'adminStoreBatch'])->name('admin.batches.store');
    Route::put('/admin/angkatan/{id}', [SimakController::class, 'adminUpdateBatch'])->name('admin.batches.update');
    Route::post('/admin/projects', [SimakController::class, 'adminStoreProject'])->name('admin.projects.store');
    Route::put('/admin/projects/{id}', [SimakController::class, 'adminUpdateProject'])->name('admin.projects.update');
    Route::delete('/admin/projects/{id}', [SimakController::class, 'adminDeleteProject'])->name('admin.projects.destroy');

    // Admin Data Asal Instansi (Sekolah / Kampus Mitra & Kontak Pembimbing)
    Route::get('/admin/instansi', [SimakController::class, 'adminInstitutions'])->name('admin.institutions');
    Route::post('/admin/instansi', [SimakController::class, 'adminStoreInstitution'])->name('admin.institutions.store');
    Route::put('/admin/instansi/{id}', [SimakController::class, 'adminUpdateInstitution'])->name('admin.institutions.update');
    Route::delete('/admin/instansi/{id}', [SimakController::class, 'adminDeleteInstitution'])->name('admin.institutions.destroy');

    // Admin Evaluasi & Penilaian Nilai Sertifikat Siswa
    Route::post('/admin/evaluasi/{userId}', [SimakController::class, 'adminSaveEvaluation'])->name('admin.evaluation.save');
});
