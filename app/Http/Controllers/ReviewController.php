<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Loan;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'book_id' => 'required|exists:books,id',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|max:1000',
        ]);

        $user = Auth::user();
        
        // 1. Cek apakah user pernah meminjam buku ini (Status: returned)
        // Syarat Dosen: "terhadap buku yang telah dipinjam"
        $hasBorrowed = Loan::where('user_id', $user->id)
                            ->where('book_id', $request->book_id)
                            ->where('status', 'returned') 
                            ->exists();

        if (!$hasBorrowed) {
            return back()->with('error', 'Anda hanya bisa mengulas buku yang sudah selesai Anda pinjam.');
        }

        // 2. Cek apakah user sudah pernah review buku ini sebelumnya (agar tidak spam)
        $existingReview = Review::where('user_id', $user->id)
                                ->where('book_id', $request->book_id)
                                ->exists();

        if ($existingReview) {
            return back()->with('error', 'Anda sudah memberikan ulasan untuk buku ini.');
        }

        // 3. Simpan Review
        Review::create([
            'user_id' => $user->id,
            'book_id' => $request->book_id,
            'rating' => $request->rating,
            'comment' => $request->comment,
        ]);

        return back()->with('success', 'Terima kasih atas ulasan Anda!');
    }
}