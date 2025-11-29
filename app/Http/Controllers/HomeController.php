<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Loan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        if (Auth::check()) {
            $user = Auth::user();

            // 1. DASHBOARD ADMIN
            if ($user->role == 'admin') {
                $totalUsers = User::where('role', '!=', 'admin')->count();
                $totalBooks = Book::count();
                $activeLoans = Loan::where('status', 'borrowed')->count();
                $totalFines = Loan::where('fine_status', 'paid')->sum('fine_amount');

                return view('dashboard.admin.home', compact('totalUsers', 'totalBooks', 'activeLoans', 'totalFines'));
            }
            
            // 2. DASHBOARD MANAGER
            if ($user->role == 'manager') {
                return redirect()->route('manager.loans');
            }

            // 3. DASHBOARD USER (Mahasiswa)
            $loans = $user->loans()->with('book')->latest()->get();
            $activeLoans = $loans->where('status', 'borrowed');
            $historyLoans = $loans->where('status', 'returned');
            
            // Ambil data reservasi yang masih aktif
            $reservations = $user->reservations()->with('book')
                                 ->where('status', 'active')
                                 ->latest()
                                 ->get();

            return view('dashboard.user.home', compact('activeLoans', 'historyLoans', 'reservations'));
        }

        return redirect('login');
    }
}