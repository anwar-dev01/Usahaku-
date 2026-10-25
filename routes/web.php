<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [\App\Http\Controllers\DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'role:owner,admin'])->group(function () {
    Route::resource('karyawan', \App\Http\Controllers\KaryawanController::class);
    Route::resource('transaksi', \App\Http\Controllers\TransaksiController::class)->except(['show', 'edit', 'update']);
    Route::get('/transaksi-export-exel', [\App\Http\Controllers\TransaksiController::class, 'exportexel'])->name('transaksi.exportexel');
    Route::get('/transaksi-export-pdf', [\App\Http\Controllers\TransaksiController::class, 'exportPdf'])->name('transaksi.export.pdf');
    Route::get('/payroll', [\App\Http\Controllers\PayrollController::class, 'index'])->name('payroll.index');
    Route::post('/payroll/generate', [\App\Http\Controllers\PayrollController::class, 'generate'])->name('payroll.generate');
    Route::post('/payroll/{payroll}/bayar', [\App\Http\Controllers\PayrollController::class, 'bayar'])->name('payroll.bayar');
    Route::resource('kategori', \App\Http\Controllers\KategoriController::class)->except(['show']);
});

Route::middleware(['auth'])->group(function () {
    Route::get('/absensi', [\App\Http\Controllers\AbsensiController::class, 'index'])->name('absensi.index');
    Route::post('/absensi', [\App\Http\Controllers\AbsensiController::class, 'store'])->name('absensi.store');
    Route::delete('/absensi/{absensi}', [\App\Http\Controllers\AbsensiController::class, 'destroy'])->name('absensi.destroy');
});

Route::middleware(['auth', 'role:karyawan'])->group(function () {
    Route::get('/absensi-saya', function () {
        return 'Halaman khusus Karyawan';
    });
});

require __DIR__.'/auth.php';