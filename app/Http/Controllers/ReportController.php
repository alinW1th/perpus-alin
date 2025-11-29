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

        return view('admin.reports.index', compact('loans', 'startDate', 'endDate', 'totalFines'));
    }
}
