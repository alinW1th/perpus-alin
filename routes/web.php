<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PublicController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Inilah tempat di mana Anda mendaftarkan rute web untuk aplikasi Anda.
|
*/

// 1. Halaman Depan (Landing Page)
Route::get('/', [PublicController::class, 'index'])->name('landing');

// 2. Halaman Detail Buku (Untuk melihat detail & meminjam)
Route::get('/book/{slug}', [PublicController::class, 'show'])->name('book.show');

// 3. Dashboard Utama (Logic pemisahan role ada di HomeController)
Route::get('/dashboard', [HomeController::class, 'index'])
    ->middleware(['auth'])
    ->name('dashboard');

// 4. Manajemen Profil Pengguna
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// 5. Memuat Rute Autentikasi (Login, Register, Admin Routes, dll)
require __DIR__.'/auth.php';