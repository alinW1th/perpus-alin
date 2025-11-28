<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Loan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoanController extends Controller
{
    /**
     * Mahasiswa meminjam buku.
     */
    public function store(Request $request)
    {
        $request->validate([
            'book_id' => 'required|exists:books,id',
        ]);

        $user = Auth::user();
        $book = Book::findOrFail($request->book_id);

        // 1. Cek apakah user punya denda tertunggak (Syarat Wajib Dosen)
        if ($user->hasUnpaidFines()) {
            return back()->with('error', 'Anda memiliki denda yang belum dibayar. Harap lunasi terlebih dahulu sebelum meminjam buku baru.');
        }

        // 2. Cek stok buku
        if ($book->available_stock < 1) {
            return back()->with('error', 'Maaf, stok buku ini sedang kosong.');
        }

        // 3. Cek apakah user sedang meminjam buku yang sama (opsional, untuk mencegah spam)
        $isBorrowing = Loan::where('user_id', $user->id)
            ->where('book_id', $book->id)
            ->where('status', 'borrowed')
            ->exists();

        if ($isBorrowing) {
            return back()->with('error', 'Anda sedang meminjam buku ini. Kembalikan dulu sebelum meminjam lagi.');
        }

        // 4. Proses Peminjaman
        Loan::create([
            'user_id' => $user->id,
            'book_id' => $book->id,
            'loan_date' => Carbon::now(),
            'due_date' => Carbon::now()->addDays($book->max_loan_days), // Default 7 hari sesuai data buku
            'status' => 'borrowed',
            'fine_status' => 'no_fine',
        ]);

        // 5. Kurangi stok buku
        $book->decrement('available_stock');

        return redirect()->route('dashboard')->with('success', 'Berhasil meminjam buku! Harap kembalikan sebelum tanggal jatuh tempo.');
    }
}