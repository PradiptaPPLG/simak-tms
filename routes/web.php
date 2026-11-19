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

// Formulir Pendaftaran PKL Online & Cek Status Antrian (/registry-pkl)
// Rate limiting 10 requests per minute on POST to prevent bot spam
Route::get('/registry-pkl', [SimakController::class, 'registryIndex'])->name('registry.index');
Route::get('/registrasi-pkl', function () {
    return redirect()->route('registry.index');
});
Route::get('/daftar-pkl', function () {
    return redirect()->route('registry.index');
});
Route::post('/registry-pkl', [SimakController::class, 'registryStore'])->middleware('throttle:10,1')->name('registry.store');
Route::get('/registry-pkl/check', [SimakController::class, 'registryCheck'])->name('registry.check');

// Authentication routes (Rate-limited POST login to prevent brute force)
Route::get('/login', [SimakController::class, 'showLogin'])->name('login');
Route::post('/login', [SimakController::class, 'login'])->middleware('throttle:10,1')->name('login.post');
Route::post('/logout', [SimakController::class, 'logout'])->name('logout');

// Public View-Only Profile Mode & Dynamic QR Code (Aman & Bebas Akses Tanpa Login)
Route::get('/profile/{identifier}', [SimakController::class, 'publicProfile'])->name('profile.show');
Route::get('/p/{identifier}', [SimakController::class, 'publicProfile'])->name('profile.public');
Route::get('/profil/{identifier}', [SimakController::class, 'publicProfile']);
Route::get('/profile', function () {
    return redirect()->route('profile');
});
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

    // Task Submission
    Route::post('/tugas/{id}/submit', [SimakController::class, 'submitTask'])->name('tasks.submit');

    // Showcase & Archive
    Route::get('/arsip', [SimakController::class, 'showcase'])->name('showcase.index');

    // Direktori Alumni PKL
    Route::get('/alumni', [SimakController::class, 'adminAlumni'])->name('alumni.index');

    // Evaluations & Score
    Route::get('/evaluasi', [SimakController::class, 'evaluation'])->name('evaluation.index');

    // Developer Profile ala GitHub
    Route::get('/profil', [SimakController::class, 'profile'])->name('profile');
    Route::post('/profil', [SimakController::class, 'updateProfile'])->name('profile.update');
    Route::post('/profile/avatar', [SimakController::class, 'updateAvatar'])->name('profile.avatar.update');
    Route::post('/password/update', [SimakController::class, 'updatePassword'])->name('password.update');

    // Mentor Review & Monitoring Hub (Staff Mentor & Admin TMS)
    Route::middleware(['role:mentor,admin_tms'])->group(function () {
        Route::get('/mentor/monitoring', [SimakController::class, 'mentorDashboard'])->name('mentor.dashboard');
        Route::get('/mentor/siswa', [SimakController::class, 'mentorStudents'])->name('mentor.students');
        Route::get('/mentor/review', [SimakController::class, 'mentorReview'])->name('mentor.review');
        Route::post('/mentor/jurnal/{id}/approve', [SimakController::class, 'approveJournal'])->name('mentor.journal.approve');
        Route::post('/mentor/jurnal/{id}/catatan', [SimakController::class, 'mentorAddNote'])->name('mentor.journal.note');
        Route::post('/mentor/tugas/{id}/grade', [SimakController::class, 'gradeSubmission'])->name('mentor.task.grade');
    });

    // Admin TMS Management Hub (Khusus Administrator TMS)
    Route::middleware(['role:admin_tms'])->group(function () {
        Route::get('/admin', [SimakController::class, 'adminDashboard'])->name('admin.dashboard');
        Route::get('/admin/siswa', [SimakController::class, 'adminStudents'])->name('admin.students');
        Route::put('/admin/siswa/{id}', [SimakController::class, 'adminUpdateStudent'])->name('admin.students.update');
        Route::post('/admin/siswa/{id}/alumni', [SimakController::class, 'adminGraduateStudent'])->name('admin.students.alumni');
        Route::delete('/admin/siswa/{id}', [SimakController::class, 'adminDeleteStudent'])->name('admin.students.destroy');
        Route::get('/admin/alumni', [SimakController::class, 'adminAlumni'])->name('admin.alumni');
        Route::post('/admin/alumni/{id}/career', [SimakController::class, 'adminUpdateAlumniCareer'])->name('admin.alumni.career');
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

        // Admin Manajemen Pendaftaran PKL Online (/admin/pendaftaran)
        Route::get('/admin/pendaftaran', [SimakController::class, 'adminRegistrations'])->name('admin.registrations');
        Route::post('/admin/pendaftaran/{id}/approve', [SimakController::class, 'adminApproveRegistration'])->name('admin.registrations.approve');
        Route::post('/admin/pendaftaran/{id}/reject', [SimakController::class, 'adminRejectRegistration'])->name('admin.registrations.reject');
        Route::delete('/admin/pendaftaran/{id}', [SimakController::class, 'adminDeleteRegistration'])->name('admin.registrations.destroy');

        // Admin Evaluasi & Penilaian Nilai Sertifikat Siswa
        Route::post('/admin/evaluasi/{userId}', [SimakController::class, 'adminSaveEvaluation'])->name('admin.evaluation.save');
    });
});
