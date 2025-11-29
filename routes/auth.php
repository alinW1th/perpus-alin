<?php

use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\VerifyEmailController;
use App\Http\Controllers\LoanController;
use App\Http\Controllers\ManagerLoanController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\ReportController; // Controller Laporan
use App\Http\Controllers\ReservationController; // Controller Reservasi
use App\Http\Controllers\ReviewController;
use Illuminate\Support\Facades\Route;

// --- GUEST ROUTES (Belum Login) ---
Route::middleware('guest')->group(function () {
    Route::get('register', [RegisteredUserController::class, 'create'])->name('register');
    Route::post('register', [RegisteredUserController::class, 'store']);
    Route::get('login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('login', [AuthenticatedSessionController::class, 'store']);
    Route::get('forgot-password', [PasswordResetLinkController::class, 'create'])->name('password.request');
    Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])->name('password.email');
    Route::get('reset-password/{token}', [NewPasswordController::class, 'create'])->name('password.reset');
    Route::post('reset-password', [NewPasswordController::class, 'store'])->name('password.store');
});

// --- AUTH ROUTES (Sudah Login) ---
Route::middleware('auth')->group(function () {
    Route::get('verify-email', EmailVerificationPromptController::class)->name('verification.notice');
    Route::get('verify-email/{id}/{hash}', VerifyEmailController::class)
        ->middleware(['signed', 'throttle:6,1'])
        ->name('verification.verify');
    Route::post('email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
        ->middleware('throttle:6,1')
        ->name('verification.send');
    Route::get('confirm-password', [ConfirmablePasswordController::class, 'show'])->name('password.confirm');
    Route::post('confirm-password', [ConfirmablePasswordController::class, 'store']);
    Route::put('password', [PasswordController::class, 'update'])->name('password.update');
    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

    // --- FITUR UMUM USER ---
    // Proses Peminjaman Buku
    Route::post('/loans', [LoanController::class, 'store'])->name('loans.store');
    
    // Proses Kirim Review
    Route::post('/reviews', [ReviewController::class, 'store'])->name('reviews.store');

    // Proses Reservasi (Booking)
    Route::post('/reservations', [ReservationController::class, 'store'])->name('reservations.store');
    Route::delete('/reservations/{id}', [ReservationController::class, 'destroy'])->name('reservations.destroy');


    // --- ADMIN ROUTES ---
    // Manajemen Buku
    Route::resource('books', ProductsController::class)->middleware('admin');
    
    // Manajemen User
    Route::resource('users', AdminUserController::class)->middleware('admin');

    // Laporan Peminjaman (BARU)
    Route::get('/reports', [ReportController::class, 'index'])->middleware('admin')->name('reports.index');


    // --- MANAGER ROUTES (Pegawai) ---
    Route::middleware('manager')->group(function () {
        Route::get('/manager/loans', [ManagerLoanController::class, 'index'])->name('manager.loans');
        Route::post('/manager/loans/{id}/return', [ManagerLoanController::class, 'returnBook'])->name('manager.return');
        
        // Route Tombol Rahasia (Time Travel)
        Route::post('/manager/loans/{id}/overdue', [ManagerLoanController::class, 'forceOverdue'])->name('manager.overdue');
    });
});
