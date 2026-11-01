<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController; // Akan dibuat di Fase 4, kita placeholder dulu
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Route tamu (belum login)
Route::middleware('guest')->group(function () {
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.store');
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.store');

    // Tambahkan throttle:5,1 untuk membatasi 5 percobaan per menit (PRD F-02)
    Route::post('/login', [AuthController::class, 'login'])
        ->name('login.store')
        ->middleware('throttle:5,1');
});

// Route terproteksi (sudah login)
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    
     // Ganti closure dengan controller
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
});