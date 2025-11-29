<?php

namespace App\Http\Controllers;

use App\Models\Loan;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ManagerLoanController extends Controller
{
    /**
     * Menampilkan daftar peminjaman aktif.
     */
    public function index()
    {
        $loans = Loan::with(['user', 'book'])
                    ->where('status', 'borrowed')
                    ->latest()
                    ->get();

        return view('dashboard.manager.index', compact('loans'));
    }

    /**
     * Proses Pengembalian Buku.
     */
    public function returnBook(Request $request, $id)
    {
        $loan = Loan::findOrFail($id);
        
        $returnDate = Carbon::now();
        $dueDate = Carbon::parse($loan->due_date);

        $fineAmount = 0;
        $fineStatus = 'no_fine';

        if ($returnDate->gt($dueDate)) {
            $daysOverdue = $returnDate->diffInDays($dueDate);
            if ($daysOverdue == 0) $daysOverdue = 1;
            
            $fineAmount = $daysOverdue * $loan->book->daily_fine;
            $fineStatus = 'unpaid';
        }

        $loan->update([
            'return_date' => $returnDate,
            'status' => 'returned',
            'fine_amount' => $fineAmount,
            'fine_status' => $fineStatus,
        ]);

        $loan->book->increment('available_stock');

        if ($fineAmount > 0) {
            return redirect()->back()->with('warning', 'Buku dikembalikan TERLAMBAT. Denda tercatat: Rp ' . number_format($fineAmount));
        }

        return redirect()->back()->with('success', 'Buku berhasil dikembalikan tepat waktu.');
    }

    /**
     * FITUR RAHASIA: Paksa Telat (Time Travel)
     * Mengubah tanggal tenggat menjadi 3 hari yang lalu.
     */
    public function forceOverdue($id)
    {
        $loan = Loan::findOrFail($id);

        $loan->update([
            'loan_date' => Carbon::now()->subDays(10), // Pura-pura pinjam 10 hari lalu
            'due_date' => Carbon::now()->subDays(3),   // Tenggatnya 3 hari lalu (Telat!)
        ]);

        return back()->with('warning', '⚡ Time Travel Sukses! Buku ini sekarang statusnya TERLAMBAT 3 hari.');
    }
}
