<?php

use App\Http\Controllers\Admin;
use App\Http\Controllers\Guru;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Siswa;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/login');

Route::get('/dashboard', function () {
    $user = auth()->user();

    if ($user->hasRole('admin')) return redirect()->route('admin.dashboard');
    if ($user->hasRole('guru'))  return redirect()->route('guru.dashboard');
    if ($user->hasRole('siswa')) return redirect()->route('siswa.dashboard');

    abort(403);
})->middleware('auth')->name('dashboard');

/* ADMIN */
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [Admin\DashboardController::class, 'index'])->name('dashboard');
    Route::resource('classrooms', Admin\ClassroomController::class)->except('show');
    Route::resource('users', Admin\UserController::class)->except('show');

    Route::resource('missions', Admin\MissionController::class)->except('show');
    Route::get('missions/{mission}/tantangan/create', [Admin\ChallengeController::class, 'create'])->name('challenges.create');
    Route::post('missions/{mission}/tantangan', [Admin\ChallengeController::class, 'store'])->name('challenges.store');
    Route::get('missions/{mission}/tantangan/{challenge}/edit', [Admin\ChallengeController::class, 'edit'])->name('challenges.edit');
    Route::put('missions/{mission}/tantangan/{challenge}', [Admin\ChallengeController::class, 'update'])->name('challenges.update');
    Route::delete('missions/{mission}/tantangan/{challenge}', [Admin\ChallengeController::class, 'destroy'])->name('challenges.destroy');

    Route::get('uji-fungsi', [Admin\FunctionCheckController::class, 'index'])->name('checks.index');
    Route::put('uji-fungsi', [Admin\FunctionCheckController::class, 'update'])->name('checks.update');
});

/* GURU */
Route::middleware(['auth', 'role:guru'])->prefix('guru')->name('guru.')->group(function () {
    Route::get('/', [Guru\DashboardController::class, 'index'])->name('dashboard');

    Route::get('refleksi', [Guru\ReflectionController::class, 'index'])->name('reflections.index');
    Route::get('refleksi/{reflection}', [Guru\ReflectionController::class, 'show'])->name('reflections.show');
    Route::post('refleksi/{reflection}/umpan-balik', [Guru\ReflectionController::class, 'feedback'])->name('reflections.feedback');

    Route::get('progres', [Guru\ProgressController::class, 'index'])->name('progress.index');

    Route::get('observasi', [Guru\ObservationController::class, 'index'])->name('observations.index');
    Route::post('observasi', [Guru\ObservationController::class, 'store'])->name('observations.store');
    Route::delete('observasi/{observation}', [Guru\ObservationController::class, 'destroy'])->name('observations.destroy');

    Route::get('angket', [Guru\SurveyRecapController::class, 'index'])->name('survey.index');

    Route::get('konsultasi', [Guru\ConsultationController::class, 'index'])->name('consultations.index');
    Route::patch('konsultasi/{consultation}', [Guru\ConsultationController::class, 'update'])->name('consultations.update');
});

/* SISWA */
Route::middleware(['auth', 'role:siswa'])->prefix('siswa')->name('siswa.')->group(function () {
    Route::get('/', [Siswa\DashboardController::class, 'index'])->name('dashboard');

    Route::get('petunjuk', [Siswa\AdventureController::class, 'guide'])->name('guide');
    Route::get('petualangan', [Siswa\AdventureController::class, 'map'])->name('missions.map');
    Route::get('misi/{mission}', [Siswa\AdventureController::class, 'show'])->name('missions.show');
    Route::post('misi/{mission}/tantangan/{challenge}/jawab', [Siswa\AdventureController::class, 'answer'])->name('missions.answer');
    Route::post('misi/{mission}/tantangan/{challenge}/ulang', [Siswa\AdventureController::class, 'retry'])->name('missions.retry');
    Route::post('misi/{mission}/refleksi', [Siswa\ReflectionController::class, 'store'])->name('reflections.store');

    Route::get('ringkasan', [Siswa\ProgressController::class, 'index'])->name('progress.index');

    Route::get('angket', [Siswa\SurveyController::class, 'show'])->name('survey.show');
    Route::post('angket', [Siswa\SurveyController::class, 'store'])->name('survey.store');

    Route::get('konsultasi', [Siswa\ConsultationController::class, 'index'])->name('consultations.index');
    Route::post('konsultasi', [Siswa\ConsultationController::class, 'store'])->name('consultations.store');

    Route::get('profil', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::match(['PUT', 'PATCH'], 'profil', [ProfileController::class, 'update'])->name('profile.update');
});

// Ganti password saja
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::match(['PUT', 'PATCH'], '/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';