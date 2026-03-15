<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ChildController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/login');
});

Route::middleware(['auth', 'verified'])->group(function () {

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
    
    // 1. DASHBOARD & PROFILE (Semua Role Bisa)
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // 2. KHUSUS ORANG TUA
    Route::get('/anak-saya', [ChildController::class, 'index'])->name('my.children');

    // 3. KHUSUS ADMIN (Manajemen User)
    Route::resource('users', UserController::class);

// 4. MANAJEMEN DATA ANAK (Petugas & Admin)
    Route::prefix('children')->group(function () {
        Route::get('/', [ChildController::class, 'index'])->name('children.index'); 
        Route::post('/', [ChildController::class, 'store'])->name('children.store'); 

        // Jalur Spesifik (Check & PDF)
        Route::post('/{id}/check', [ChildController::class, 'check'])->name('children.check'); 
        Route::get('/{id}/download-pdf', [ChildController::class, 'downloadPDF'])->name('children.pdf'); 

        // Jalur CRUD Umum
        Route::get('/{id}', [ChildController::class, 'show'])->name('children.show'); 
        Route::get('/{id}/edit', [ChildController::class, 'edit'])->name('children.edit'); 
        Route::put('/{id}', [ChildController::class, 'update'])->name('children.update'); 
        
        // --- TAMBAHKAN BARIS INI ---
        Route::delete('/{id}', [ChildController::class, 'destroy'])->name('children.destroy');
        // ---------------------------
    });

    // Hapus Riwayat
    Route::delete('/growth-record/{id}', [ChildController::class, 'destroyRecord'])->name('record.destroy');
});

require __DIR__.'/auth.php';