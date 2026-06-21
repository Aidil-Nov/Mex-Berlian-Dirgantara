<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KargoController;
use App\Http\Controllers\KomplainController;
use App\Http\Controllers\LaporanController;
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
    Route::prefix('manager')->name('manager.')->group(function () {
        Route::get('/dashboard', function () {
            return view('manager.dashboard');
        })->name('dashboard');

        Route::get('/monitoring', function () {
            return view('manager.monitoring');
        })->name('monitoring');

        Route::get('/laporan', function () {
            return view('manager.laporan');
        })->name('laporan');
    });

    // -----------------------------------------------------
    // GRUP ROUTE ADMIN OPERASIONAL
    // -----------------------------------------------------
    Route::prefix('admin')->name('admin.')->group(function () {

        // GANTI CLOSURE DENGAN CONTROLLER
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        // Route::get('/kelola-data-kargo', function () {
        //     return view('admin.kelola-data-kargo');
        // })->name('kelola-data-kargo');

        // Route::get('/kelola-status-pengiriman', function () {
        //     return view('admin.kelola-status-pengiriman');
        // })->name('kelola-status-pengiriman');

        // Route::get('/kelola-data-kargo', function () {
        //     return view('admin.kelola-data-kargo');
        // })->name('kelola-data-kargo'); 

        // Route::get('/kelola-status-pengiriman', function () {
        //     return view('admin.kelola-status-pengiriman');
        // })->name('kelola-status-pengiriman');

        // Route::get('/tracking-pengiriman', function () {
        //     return view('admin.tracking-pengiriman');
        // })->name('tracking-pengiriman');

        // Route::get('/laporan', function () {
        //     return view('admin.kelola-laporan');
        // })->name('kelola-laporan');

        // Route::get('/komplain', function () {
        //     return view('admin.komplain');
        // })->name('komplain');
    });

    // Pengaturan Profil Bawaan Breeze
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/admin/kelola-data-kargo', [KargoController::class, 'create'])->name('admin.kelola-data-kargo');
    Route::post('/admin/kelola-data-kargo', [KargoController::class, 'store'])->name('admin.kelola-data-kargo.store');

    Route::get('/kelola-status-pengiriman', [StatusPengirimanController::class, 'index'])->name('admin.kelola-status-pengiriman');
    Route::post('/kelola-status-pengiriman/update', [StatusPengirimanController::class, 'update'])->name('admin.kelola-status-pengiriman.update');

    Route::get('/tracking-pengiriman', [TrackingController::class, 'index'])->name('admin.tracking-pengiriman');

    Route::get('/laporan', [LaporanController::class, 'index'])->name('admin.kelola-laporan');
    Route::post('/laporan/generate', [LaporanController::class, 'generate'])->name('admin.kelola-laporan.generate');
    Route::get('/laporan/download/{id}', [LaporanController::class, 'download'])->name('admin.kelola-laporan.download');

    Route::get('/komplain', [App\Http\Controllers\KomplainController::class, 'index'])->name('admin.komplain');
    Route::get('/komplain/cek-resi', [App\Http\Controllers\KomplainController::class, 'cekResi'])->name('admin.komplain.cek-resi');
    Route::post('/komplain', [App\Http\Controllers\KomplainController::class, 'store'])->name('admin.komplain.store');


});

// Memanggil route autentikasi (Login, Forgot Password, dll)
require __DIR__ . '/auth.php';