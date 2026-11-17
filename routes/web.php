<?php

use App\Http\Controllers\SimakController;
use Illuminate\Support\Facades\Route;

// Root URL ALWAYS goes to Login!
Route::get('/', function () {
    return redirect()->route('login');
});

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

Route::get('/preview/profile', function () {
    $user = \App\Models\User::first();
    \Illuminate\Support\Facades\Auth::login($user);
    return redirect()->route('profile');
})->name('preview.profile');

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

// Authentication routes
Route::get('/login', [SimakController::class, 'showLogin'])->name('login');
Route::post('/login', [SimakController::class, 'login'])->name('login.post');
Route::get('/login/quick/{role}', [SimakController::class, 'quickLogin'])->name('login.quick');
Route::post('/logout', [SimakController::class, 'logout'])->name('logout');

// Protected routes (Must be logged in!)
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [SimakController::class, 'dashboard'])->name('dashboard');
    
    // Informasi KOCI/TMS (FAQ & Hotline)
    Route::get('/informasi', [SimakController::class, 'informasi'])->name('informasi');

    // LMS & Tasks (Deprecated - Redirected to Showcase Portofolio)
    Route::get('/tugas', function () {
        return redirect()->route('showcase.index');
    })->name('tasks.index');

    // Daily Journals (Logbook)
    Route::get('/jurnal', [SimakController::class, 'journals'])->name('journals.index');
    Route::post('/jurnal', [SimakController::class, 'storeJournal'])->name('journals.store');

    // Showcase & Archive
    Route::get('/arsip', [SimakController::class, 'showcase'])->name('showcase.index');

    // Evaluations & Score
    Route::get('/evaluasi', [SimakController::class, 'evaluation'])->name('evaluation.index');

    // Mentor Review & Monitoring Hub
    Route::get('/mentor/monitoring', [SimakController::class, 'mentorDashboard'])->name('mentor.dashboard');
    Route::get('/mentor/review', [SimakController::class, 'mentorReview'])->name('mentor.review');
    Route::post('/mentor/jurnal/{id}/approve', [SimakController::class, 'approveJournal'])->name('mentor.journal.approve');
    Route::post('/mentor/tugas/{id}/grade', [SimakController::class, 'gradeSubmission'])->name('mentor.task.grade');
    Route::post('/mentor/students', [SimakController::class, 'mentorStoreStudent'])->name('mentor.students.store');

    // Developer Profile ala GitHub
    Route::get('/profil', [SimakController::class, 'profile'])->name('profile');
    Route::post('/profil', [SimakController::class, 'updateProfile'])->name('profile.update');

    // Admin TMS Management Hub
    Route::get('/admin', [SimakController::class, 'adminDashboard'])->name('admin.dashboard');
    Route::get('/admin/siswa', [SimakController::class, 'adminStudents'])->name('admin.students');
    Route::post('/admin/tugas', [SimakController::class, 'adminCreateTask'])->name('admin.tasks.store');
    Route::post('/admin/users', [SimakController::class, 'adminStoreUser'])->name('admin.users.store');
});
