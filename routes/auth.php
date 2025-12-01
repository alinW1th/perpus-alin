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
use App\Http\Controllers\BookController;
use App\Http\Controllers\BookDonationController; // Pastikan ini ada
use App\Http\Controllers\LoanController;
use App\Http\Controllers\ManagerLoanController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ReservationController;
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
    // Verifikasi Email & Password
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
    
    // Logout
    Route::any('logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

    // ==========================================
    // FITUR MAHASISWA (USER)
    // ==========================================
    
    // 1. Peminjaman & Pengembalian
    Route::post('/loans', [LoanController::class, 'store'])->name('loans.store');
    Route::post('/loans/{id}/return-user', [LoanController::class, 'returnBook'])->name('loans.user_return');
    
    // 2. Pembayaran Denda
    Route::get('/loans/{id}/pay', [LoanController::class, 'payFine'])->name('loans.pay');
    Route::post('/loans/{id}/pay', [LoanController::class, 'storePayment'])->name('loans.store_payment');

    // 3. Review & Rating
    Route::post('/reviews', [ReviewController::class, 'store'])->name('reviews.store');

    // 4. Rute Balas Komentar
    Route::post('/reviews/{id}/reply', [ReviewController::class, 'reply'])->name('reviews.reply');
    
    // 5. Rute Hapus Review
    Route::delete('/reviews/{id}', [ReviewController::class, 'destroy'])->name('reviews.destroy');

    // 6. Reservasi (Antrian)
    Route::post('/reservations', [ReservationController::class, 'store'])->name('reservations.store');
    Route::delete('/reservations/{id}', [ReservationController::class, 'destroy'])->name('reservations.destroy');

    // 7. Waqaf / Donasi Buku (INI YANG TADI HILANG)
    Route::get('/donations', [BookDonationController::class, 'index'])->name('donations.index');
    Route::post('/donations', [BookDonationController::class, 'store'])->name('donations.store');


    // ==========================================
    // FITUR ADMIN (FULL AKSES)
    // ==========================================
    Route::resource('books', BookController::class)->middleware('admin'); 
    Route::resource('users', AdminUserController::class)->middleware('admin');
    Route::get('/reports', [ReportController::class, 'index'])->middleware('admin')->name('reports.index');
    // Halaman Riwayat Denda (Admin)
    Route::get('/admin/fines', [ReportController::class, 'fines'])->name('admin.fines');
    Route::delete('/admin/fines/{id}', [ReportController::class, 'destroyFine'])->name('admin.fines.destroy');


    // ==========================================
    // FITUR PEGAWAI (MANAGER)
    // ==========================================
    Route::middleware('manager')->group(function () {
        // Validasi Peminjaman
        Route::get('/manager/loans', [ManagerLoanController::class, 'index'])->name('manager.loans');
        Route::post('/manager/loans/{id}/return', [ManagerLoanController::class, 'returnBook'])->name('manager.return');
        Route::post('/manager/loans/{id}/overdue', [ManagerLoanController::class, 'forceOverdue'])->name('manager.overdue');

        // Rute untuk Manager Menyetujui Pembayaran Denda
        Route::post('/manager/loans/{id}/approve-fine', [ManagerLoanController::class, 'approveFine'])->name('manager.approve_fine');
        
        // Validasi Waqaf
        Route::get('/manager/donations', [BookDonationController::class, 'managerIndex'])->name('manager.donations');
        Route::patch('/manager/donations/{id}', [BookDonationController::class, 'updateStatus'])->name('manager.donations.update');
    });
});