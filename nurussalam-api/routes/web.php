<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\AuthController;
use App\Http\Controllers\Web\DashboardController;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/login', [AuthController::class, 'authenticate'])->name('login.post');
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('santri', \App\Http\Controllers\Web\SantriController::class);
    Route::resource('jadwal', \App\Http\Controllers\Web\JadwalController::class);
    Route::resource('pengumuman', \App\Http\Controllers\Web\PengumumanController::class);
    Route::get('/absensi', [\App\Http\Controllers\Web\AbsensiController::class, 'index'])->name('absensi.index');
});
