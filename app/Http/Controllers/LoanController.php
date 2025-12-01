<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Loan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoanController extends Controller
{
    // Proses Pinjam Buku
    public function store(Request $request)
    {
        $request->validate(['book_id' => 'required|exists:books,id']);
        $user = Auth::user();
        $book = Book::findOrFail($request->book_id);

        if ($user->hasUnpaidFines()) return back()->with('error', 'Lunasi denda dulu.');
        if ($book->available_stock < 1) return back()->with('error', 'Stok kosong.');
        
        $isBorrowing = Loan::where('user_id', $user->id)->where('book_id', $book->id)->where('status', 'borrowed')->exists();
        if ($isBorrowing) return back()->with('error', 'Sedang meminjam buku ini.');

        Loan::create([
            'user_id' => $user->id,
            'book_id' => $book->id,
            'loan_date' => Carbon::now(),
            'due_date' => Carbon::now()->addDays($book->max_loan_days),
            'status' => 'borrowed',
        ]);

        $book->decrement('available_stock');
        return redirect()->route('dashboard')->with('success', 'Berhasil meminjam buku!');
    }

    // User Mengajukan Pengembalian
    public function returnBook(Request $request, $id)
    {
        $loan = Loan::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        $isOverdue = Carbon::now()->gt(Carbon::parse($loan->due_date));

        $loan->update(['status' => 'return_pending', 'return_date' => now()]);

        if ($isOverdue) return back()->with('warning', 'Terima kasih, Jangan lupa bayar dendanya');
        return back()->with('success', 'Terima kasih anda telah mengembalikan tepat waktu');
    }

    // Halaman Bayar Denda
    public function payFine($id)
    {
        $loan = Loan::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        return view('dashboard.user.pay-fine', compact('loan'));
    }

    // Proses Upload Bukti Bayar
    public function storePayment(Request $request, $id)
    {
        $request->validate(['payment_proof' => 'required|image|max:2048']);
        $loan = Loan::findOrFail($id);
        
        $path = $request->file('payment_proof')->store('payments', 'public');

        $loan->update(['payment_proof' => $path]);

        return redirect()->route('dashboard')->with('success', 'Bukti pembayaran berhasil diupload. Tunggu verifikasi petugas.');
    }
}