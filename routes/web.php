<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ThemeController;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/profile/edit', [AuthController::class, 'editProfile'])->name('profile.edit');
    Route::put('/profile', [AuthController::class, 'updateProfile'])->name('profile.update');

    // Theme routes
    Route::post('/theme/switch', [ThemeController::class, 'switch'])->name('theme.switch');

    Route::prefix('admin')->middleware('admin')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'admin'])->name('admin.dashboard');
        Route::get('/reports', [ReportController::class, 'index'])->name('admin.reports');
        Route::get('/reports/{report}', [ReportController::class, 'show'])->name('admin.reports.show');
        Route::get('/reports/{report}/edit', [ReportController::class, 'edit'])->name('admin.reports.edit');
        Route::put('/reports/{report}', [ReportController::class, 'update'])->name('admin.reports.update');
        Route::delete('/reports/{report}', [ReportController::class, 'destroy'])->name('admin.reports.destroy');
        Route::get('/reports/export', [ReportController::class, 'export'])->name('admin.reports.export');
    });

    Route::prefix('siswa')->middleware('siswa')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'siswa'])->name('siswa.dashboard');
        Route::get('/reports', [ReportController::class, 'index'])->name('siswa.reports');
        Route::get('/reports/create', [ReportController::class, 'create'])->name('siswa.reports.create');
        Route::post('/reports', [ReportController::class, 'store'])->name('siswa.reports.store');
        Route::get('/reports/{report}', [ReportController::class, 'show'])->name('siswa.reports.show');
    });
});
