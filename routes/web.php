<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// ==========================================
// 1. ROUTE PUBLIC (CUSTOMER / PENGUNJUNG)
// ==========================================

// Halaman Utama Landing Page (Default Domain)
Route::get('/', function () {
    return view('customer.welcome');
})->name('home');

// Halaman Tracking Kargo
Route::get('/tracking', function (Request $request) {
    // Menangkap nomor resi dari URL (?no_resi=MEX9526001)
    $no_resi = $request->query('no_resi');

    // Me-return halaman view khusus tracking
    return view('customer.partials.tracking-result', compact('no_resi'));
})->name('tracking.show');


// ==========================================
// 2. ROUTE PROTECTED (KHUSUS ADMIN & AUTH)
// ==========================================

// Halaman Dashboard Admin
Route::get('/dashboard', function () {
    return view('admin.dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Pengaturan Profil Bawaan Breeze
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';