<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KargoController;
use App\Http\Controllers\KomplainController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\ManagerDashboardController;
use App\Http\Controllers\ManagerKomplainController;
use App\Http\Controllers\ManagerMonitoringController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StatusPengirimanController;
use App\Http\Controllers\TrackingController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;




// ==========================================
// 1. ROUTE PUBLIC (CUSTOMER / PENGUNJUNG)
// ==========================================

// Halaman Utama Landing Page
Route::get('/', function () {
    return view('customer.welcome');
})->name('home');

// Halaman Tracking Kargo (Proses 4.0 di DFD)
Route::get('/tracking', [TrackingController::class, 'publicTracking'])->name('tracking.show');


// ==========================================
// 2. ROUTE PROTECTED (KHUSUS PEGAWAI LOGIN)
// ==========================================

Route::middleware(['auth', 'verified'])->group(function () {

    // -----------------------------------------------------
    // PINTU GERBANG UTAMA (REDIRECTOR)
    // -----------------------------------------------------
    Route::get('/dashboard', function () {
        $role = Auth::user()->role;

        if ($role === 'manajer_cabang') {
            return redirect()->route('manager.dashboard');
        }

        // Jika bukan manajer, arahkan ke admin
        return redirect()->route('admin.dashboard');
    })->name('dashboard');


    // -----------------------------------------------------
    // GRUP ROUTE MANAJER CABANG
    // -----------------------------------------------------
    Route::middleware(['auth', 'checkRole:manajer_cabang'])->prefix('manager')->group(function () {

        // Ruang Lingkup 2: Dashboard Ringkasan
        Route::get('/dashboard', [ManagerDashboardController::class, 'index'])->name('manager.dashboard');

        // Ruang Lingkup 3: Modul Monitor Operasional
        // Jangan lupa tambahkan use App\Http\Controllers\ManagerMonitoringController; di bagian atas web.php ya!
        Route::get('/monitoring', [ManagerMonitoringController::class, 'index'])->name('manager.monitoring');
        Route::post('/komplain/{id}/solusi', [ManagerKomplainController::class, 'updateSolusi'])->name('manager.komplain.solusi');

        // PERBAIKAN: Diarahkan ke 'validasiIndex' agar tampilan halaman ini BERBEDA dengan Monitor Operasional
        Route::get('/validasi-komplain', [ManagerKomplainController::class, 'validasiIndex'])->name('manager.validasi-komplain');

        // Modul Manajemen Berkas Dokumen Laporan Operasional
        Route::get('/laporan', [LaporanController::class, 'index'])->name('manager.laporan');
        Route::post('/laporan/generate', [LaporanController::class, 'generate'])->name('manager.laporan.generate');
        Route::get('/laporan/download/{id}', [LaporanController::class, 'download'])->name('manager.laporan.download');
        // Tambahkan route ini di dalam grup route manajer
        Route::post('/laporan/{id}/validate', [LaporanController::class, 'validateReport'])->name('manager.laporan.validate');
    });

    // -----------------------------------------------------
    // GRUP ROUTE ADMIN OPERASIONAL
    // -----------------------------------------------------
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    });

    // Pengaturan Profil Bawaan Breeze
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Modul Kargo
    Route::get('/admin/kelola-data-kargo', [KargoController::class, 'create'])->name('admin.kelola-data-kargo');
    Route::post('/admin/kelola-data-kargo', [KargoController::class, 'store'])->name('admin.kelola-data-kargo.store');

    // Modul Status Pengiriman
    Route::get('/kelola-status-pengiriman', [StatusPengirimanController::class, 'index'])->name('admin.kelola-status-pengiriman');
    Route::post('/kelola-status-pengiriman/update', [StatusPengirimanController::class, 'update'])->name('admin.kelola-status-pengiriman.update');

    // Modul Tracking
    Route::get('/tracking-pengiriman', [TrackingController::class, 'index'])->name('admin.tracking-pengiriman');

    // Modul Cetak Laporan (Sisi Admin)
    Route::get('/laporan', [LaporanController::class, 'index'])->name('admin.kelola-laporan');
    Route::post('/laporan/generate', [LaporanController::class, 'generate'])->name('admin.kelola-laporan.generate');
    Route::get('/laporan/download/{id}', [LaporanController::class, 'download'])->name('admin.kelola-laporan.download');

    // Modul Input Komplain (Sisi Admin)
    Route::get('/komplain', [KomplainController::class, 'index'])->name('admin.komplain');
    Route::get('/komplain/cek-resi', [KomplainController::class, 'cekResi'])->name('admin.komplain.cek-resi');
    Route::post('/komplain', [KomplainController::class, 'store'])->name('admin.komplain.store');

});

// Memanggil route autentikasi (Login, Forgot Password, dll)
require __DIR__ . '/auth.php';