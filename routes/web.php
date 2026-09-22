<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\GuruController;
use App\Http\Controllers\KelasController;
use App\Http\Controllers\NilaiController;
use App\Http\Controllers\PengajuanController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SiswaController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('siswa', SiswaController::class);
    Route::resource('guru', GuruController::class);
    Route::resource('kelas', KelasController::class);
    Route::resource('nilai', NilaiController::class);
    Route::resource('pengajuan', PengajuanController::class);

    // Middleware custom EnsureCanReviewPengajuan applied to approval/rejection routes
    Route::middleware('can.review.pengajuan')->group(function () {
        Route::get('/pengajuan/{pengajuan}/review', [PengajuanController::class, 'reviewForm'])->name('pengajuan.review');
        Route::post('/pengajuan/{pengajuan}/process', [PengajuanController::class, 'processReview'])->name('pengajuan.process');
    });

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
