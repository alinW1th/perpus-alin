<?php

namespace App\Http\Controllers;

use App\Models\Loan;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        // Default tanggal: 1 bulan terakhir
        $startDate = $request->input('start_date', now()->subMonth()->format('Y-m-d'));
        $endDate = $request->input('end_date', now()->format('Y-m-d'));

        // Query Laporan
        $loans = Loan::with(['user', 'book'])
            ->whereBetween('loan_date', [$startDate, $endDate])
            ->latest()
            ->get();

        // Hitung total denda di periode ini
        $totalFines = $loans->where('fine_status', 'paid')->sum('fine_amount');

        // Kita ambil data yang statusnya 'returned' (Selesai) atau 'borrowed'/'return_pending' (Sedang jalan)
        $loans = \App\Models\Loan::with(['user', 'book'])
            ->whereBetween('loan_date', [$startDate, $endDate])
            ->latest()
            ->get();

        return view('admin.reports.index', compact('loans', 'startDate', 'endDate', 'totalFines'));
    }

    // Halaman List Denda (Riwayat)
    public function fines()
    {
        // 1. Ambil semua data denda
        $fines = \App\Models\Loan::with(['user', 'book'])
            ->where(function($query) {
                $query->where('fine_amount', '>', 0)
                      ->orWhere('fine_status', 'unpaid')
                      ->orWhere('fine_status', 'paid');
            })
            ->latest()
            ->get();

        // 2. Hitung Ringkasan untuk Admin (Fitur Baru)
        $totalUnpaid = $fines->where('fine_status', 'unpaid')->sum('fine_amount');
        $totalPaid = $fines->where('fine_status', 'paid')->sum('fine_amount');

        return view('admin.fines.index', compact('fines', 'totalUnpaid', 'totalPaid'));
    }

    // Hapus Data Denda (Hapus Record Peminjaman)
    public function destroyFine($id)
    {
        $loan = Loan::findOrFail($id);
        $loan->delete(); // Hapus permanen record ini dari riwayat

        return back()->with('success', 'Data denda berhasil dihapus (Bersih-bersih Demo).');
    }
}
