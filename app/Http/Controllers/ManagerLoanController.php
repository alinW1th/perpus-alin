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
        // Ambil semua peminjaman yang statusnya masih 'borrowed' (sedang dipinjam)
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
        
        // 1. Catat tanggal hari ini
        $returnDate = Carbon::now();
        $dueDate = Carbon::parse($loan->due_date);

        // 2. Hitung Denda (Jika terlambat)
        $fineAmount = 0;
        $fineStatus = 'no_fine';

        if ($returnDate->gt($dueDate)) {
            // Hitung selisih hari (pembulatan ke atas)
            $daysOverdue = $returnDate->diffInDays($dueDate);
            
            // Minimal denda 1 hari jika terlambat hitungan jam tapi ganti hari
            if ($daysOverdue == 0) $daysOverdue = 1;

            $fineAmount = $daysOverdue * $loan->book->daily_fine;
            $fineStatus = 'unpaid'; // Status denda belum lunas
        }

        // 3. Update Data Peminjaman
        $loan->update([
            'return_date' => $returnDate,
            'status' => 'returned',
            'fine_amount' => $fineAmount,
            'fine_status' => $fineStatus,
        ]);

        // 4. Kembalikan Stok Buku
        $loan->book->increment('available_stock');

        // Pesan notifikasi berbeda jika ada denda
        if ($fineAmount > 0) {
            return redirect()->back()->with('warning', 'Buku dikembalikan TERLAMBAT. Denda tercatat: Rp ' . number_format($fineAmount));
        }

        return redirect()->back()->with('success', 'Buku berhasil dikembalikan tepat waktu.');
    }
}