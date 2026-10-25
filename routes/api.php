<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\KaryawanController;
use App\Http\Controllers\Api\KategoriController;
use App\Http\Controllers\Api\TransaksiController;
use App\Http\Controllers\Api\AbsensiController;

// Route Publik (Bisa diakses siapa saja tanpa token)
Route::post('/login', [AuthController::class, 'login']);

// Route Privat (Wajib pakai Bearer Token / Harus Login)
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/me', [AuthController::class, 'me']); // Cek akun sendiri
    Route::post('/logout', [AuthController::class, 'logout']); // Keluar aplikasi

  // Pake apiResource = Otomatis dapat 5 fitur sekaligus (Lihat Sem ua, Tambah, Detail, Edit, Hapus)
    Route::apiResource('karyawan', KaryawanController::class);
    Route::apiResource('kategori', KategoriController::class);
    Route::apiResource('transaksi', TransaksiController::class);
    Route::apiResource('absensi', AbsensiController::class);
});