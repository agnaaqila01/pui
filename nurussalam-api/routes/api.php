<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\JadwalController;
use App\Http\Controllers\Api\SantriController;
use App\Http\Controllers\Api\AbsensiController;
use App\Http\Controllers\Api\DashboardController;
use App\Http\Controllers\Api\PengumumanController;

// Auth
Route::post('/admin/login', [AuthController::class, 'loginAdmin']);
Route::post('/login', [AuthController::class, 'loginSantri']);

// Absensi
Route::get('/absensi/santri/{id}', [AbsensiController::class, 'showBySantri']);
Route::get('/absensi', [AbsensiController::class, 'index']); // Note: index method might be missing in AbsensiController based on previous view, but keeping route if it exists
Route::post('/absensi', [AbsensiController::class, 'store']);
Route::get('/absensi/rekap', [AbsensiController::class, 'rekapHariIni']);

// Jadwal
Route::get('/jadwal', [JadwalController::class, 'index']);
Route::post('/jadwal', [JadwalController::class, 'store']);
Route::put('/jadwal/{id}', [JadwalController::class, 'update']);
Route::delete('/jadwal/{id}', [JadwalController::class, 'destroy']);

// Santri
Route::get('/santri', [SantriController::class, 'index']);
Route::post('/santri', [SantriController::class, 'store']);
Route::put('/santri/{id}', [SantriController::class, 'update']);
Route::delete('/santri/{id}', [SantriController::class, 'destroy']);
Route::post('/santri/import', [SantriController::class, 'import'])->middleware('auth:api');

// Dashboard
Route::get('/dashboard/summary', [DashboardController::class, 'summary']);

// Pengumuman
Route::get('/pengumuman', [PengumumanController::class, 'index']);
Route::post('/pengumuman', [PengumumanController::class, 'store']);
Route::delete('/pengumuman/{id}', [PengumumanController::class, 'destroy']);