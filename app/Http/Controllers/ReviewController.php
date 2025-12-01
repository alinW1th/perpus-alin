<?php

namespace App\Http\Controllers;

use App\Models\Loan;
use App\Models\Review;
use App\Models\ReviewReply; // Model Balasan (Pastikan file Modelnya sudah dibuat)
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    /**
     * Simpan Review Baru (atau Update jika sudah ada)
     */
    public function store(Request $request)
    {
        $request->validate([
            'book_id' => 'required',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000', // PERUBAHAN: 'nullable' artinya komentar boleh kosong
        ]);

        $user = Auth::user();

        // 1. Cek Syarat: Harus sudah pernah pinjam & kembali
        // Syarat ini memastikan hanya pembaca asli yang bisa memberi rating
        $hasReturned = Loan::where('user_id', $user->id)
            ->where('book_id', $request->book_id)
            ->where('status', 'returned')
            ->exists();

        if (!$hasReturned) {
            return back()->with('error', 'Anda harus meminjam dan mengembalikan buku ini dulu sebelum memberi ulasan.');
        }

        // 2. Simpan atau Update (Logika Cerdas)
        // Jika user sudah pernah review buku ini -> Update datanya
        // Jika belum -> Buat data baru
        Review::updateOrCreate(
            ['user_id' => $user->id, 'book_id' => $request->book_id], // Cari data berdasarkan ini
            ['rating' => $request->rating, 'comment' => $request->comment] // Update bagian ini
        );

        return back()->with('success', 'Penilaian Anda berhasil disimpan!');
    }

    /**
     * FITUR BARU: Balas Komentar (Reply Style)
     */
    public function reply(Request $request, $id)
    {
        $request->validate([
            'body' => 'required|string|max:500',
        ]);

        // Simpan Balasan ke Database
        ReviewReply::create([
            'review_id' => $id, // ID Review induk yang dibalas
            'user_id' => Auth::id(), // Siapa yang membalas
            'body' => $request->body // Isi balasan
        ]);

        return back()->with('success', 'Balasan berhasil dikirim.');
    }

    /**
     * Hapus Review (Untuk Mahasiswa sendiri, Admin, atau Manager)
     */
    public function destroy($id)
    {
        $review = Review::findOrFail($id);
        $user = Auth::user();

        // Cek Hak Akses
        // Boleh hapus jika: (Yang login adalah pemilik review) ATAU (Yang login adalah Admin/Manager)
        if ($user->id !== $review->user_id && !in_array($user->role, ['admin', 'manager'])) {
            return back()->with('error', 'Anda tidak berhak menghapus ulasan ini.');
        }

        $review->delete();

        return back()->with('success', 'Ulasan berhasil dihapus.');
    }
}
