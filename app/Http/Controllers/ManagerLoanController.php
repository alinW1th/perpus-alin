<?php

namespace App\Http\Controllers;

use App\Models\Loan;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ManagerLoanController extends Controller
{
    public function index()
    {
        $loans = Loan::with(['user', 'book'])->whereIn('status', ['borrowed', 'return_pending'])->orderBy('status', 'asc')->latest()->get();
        $historyLoans = Loan::with(['user', 'book'])->where('status', 'returned')->latest()->get();
        return view('dashboard.manager.index', compact('loans', 'historyLoans'));
    }

    public function returnBook(Request $request, $id)
    {
        $loan = Loan::findOrFail($id);
        
        $returnDate = Carbon::now();
        $dueDate = Carbon::parse($loan->due_date);

        $fineAmount = 0;
        $fineStatus = 'no_fine';

        // Cek Telat pakai startOfDay agar hitungan hari akurat
        if ($returnDate->startOfDay()->gt($dueDate->startOfDay())) {
            
            $daysOverdue = $returnDate->diffInDays($dueDate);
            if ($daysOverdue == 0) $daysOverdue = 1; // Minimal telat 1 hari
            
            // Ambil denda dari buku. Jika 0 atau null, PAKSA jadi 1000
            $dailyFine = $loan->book->daily_fine > 0 ? $loan->book->daily_fine : 1000;
            
            $fineAmount = $daysOverdue * $dailyFine;
            
            // Jika user belum upload bukti, statusnya unpaid
            $fineStatus = $loan->payment_proof ? 'paid' : 'unpaid';
        }

        $loan->update([
            'return_date' => $returnDate,
            'status' => 'returned',
            'fine_amount' => $fineAmount,
            'fine_status' => $fineStatus,
        ]);

        $loan->book->increment('available_stock');

        // Notifikasi debugging agar Anda tahu berapa dendanya
        if ($fineAmount > 0) {
            return redirect()->back()->with('warning', 'TERLAMBAT! Denda dihitung: Rp ' . number_format($fineAmount));
        }

        return redirect()->back()->with('success', 'Tepat Waktu. Tidak ada denda.');
    }

    // Logika Paksa Telat Custom Hari
    public function forceOverdue(Request $request, $id)
    {
        $loan = Loan::findOrFail($id);
        $days = $request->input('days', 3); // Default 3 hari jika kosong

        $loan->update([
            'loan_date' => Carbon::now()->subDays($days + 7), 
            'due_date' => Carbon::now()->subDays($days),      
        ]);

        return back()->with('warning', "⚡ DEMO: Waktu dimundurkan. Buku ini sekarang terlambat {$days} hari.");
    }

    public function approveFine($id)
    {
        $loan = Loan::findOrFail($id);
        
        $loan->update([
            'fine_status' => 'paid'
        ]);

        return back()->with('success', 'Pembayaran denda berhasil diverifikasi. Status: LUNAS.');
    }
}