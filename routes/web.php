<?php

use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/login');

Route::get('/dashboard', function () {
    $user = auth()->user();

    if ($user->hasRole('admin')) return redirect()->route('admin.dashboard');
    if ($user->hasRole('guru'))  return redirect()->route('guru.dashboard');
    if ($user->hasRole('siswa')) return redirect()->route('siswa.dashboard');

    abort(403);
})->middleware('auth')->name('dashboard');

Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::resource('classrooms', \App\Http\Controllers\Admin\ClassroomController::class)->except('show');
    Route::resource('users', \App\Http\Controllers\Admin\UserController::class)->except('show');
});

Route::middleware(['auth', 'role:guru'])->prefix('guru')->name('guru.')->group(function () {
    Route::view('/', 'guru.dashboard')->name('dashboard');

    Route::get('jurnal', [\App\Http\Controllers\Guru\JournalController::class, 'index'])->name('journals.index');
    Route::get('jurnal/{journal}', [\App\Http\Controllers\Guru\JournalController::class, 'show'])->name('journals.show');
    Route::post('jurnal/{journal}/umpan-balik', [\App\Http\Controllers\Guru\JournalController::class, 'feedback'])->name('journals.feedback');

    Route::get('konsultasi', [\App\Http\Controllers\Guru\ConsultationController::class, 'index'])->name('consultations.index');
    Route::patch('konsultasi/{consultation}', [\App\Http\Controllers\Guru\ConsultationController::class, 'update'])->name('consultations.update');
});

Route::middleware(['auth', 'role:siswa'])->prefix('siswa')->name('siswa.')->group(function () {
    Route::view('/', 'siswa.dashboard')->name('dashboard');

    Route::get('profil', [\App\Http\Controllers\Siswa\ProfileController::class, 'edit'])->name('profile.edit');
    Route::match(['PUT', 'PATCH'], 'profil', [\App\Http\Controllers\Siswa\ProfileController::class, 'update'])->name('profile.update');

    Route::resource('journals', \App\Http\Controllers\Siswa\JournalController::class)->except('show');

    Route::get('konsultasi', [\App\Http\Controllers\Siswa\ConsultationController::class, 'index'])->name('consultations.index');
    Route::post('konsultasi', [\App\Http\Controllers\Siswa\ConsultationController::class, 'store'])->name('consultations.store');

    Route::resource('strengths', \App\Http\Controllers\Siswa\StrengthController::class)
        ->only(['index', 'store', 'destroy']);

    Route::get('peta-kepribadian', [\App\Http\Controllers\Siswa\PersonalityMapController::class, 'index'])->name('personality.index');
    Route::put('peta-kepribadian', [\App\Http\Controllers\Siswa\PersonalityMapController::class, 'update'])->name('personality.update');

    Route::get('nilai-hidup', [\App\Http\Controllers\Siswa\LifeValueController::class, 'index'])->name('life_values.index');
    Route::match(['PUT', 'POST'], 'nilai-hidup', [\App\Http\Controllers\Siswa\LifeValueController::class, 'update'])->name('life_values.update');

    Route::get('ringkasan', [\App\Http\Controllers\Siswa\ProgressController::class, 'index'])->name('progress.index');
});

// Ganti password saja; update/hapus profil sengaja tidak disediakan
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
});

require __DIR__.'/auth.php';