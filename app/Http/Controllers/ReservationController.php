<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReservationController extends Controller
{
    // Simpan reservasi
    public function store(Request $request)
    {
        $request->validate(['book_id' => 'required|exists:books,id']);

        // Cek apakah user sudah reservasi buku yang sama
        $exists = Reservation::where('user_id', Auth::id())
            ->where('book_id', $request->book_id)
            ->where('status', 'active')
            ->exists();

        if ($exists) {
            return back()->with('error', 'Anda sudah masuk antrian untuk buku ini.');
        }

        Reservation::create([
            'user_id' => Auth::id(),
            'book_id' => $request->book_id,
            'status' => 'active'
        ]);

        return back()->with('success', 'Berhasil reservasi! Anda kini dalam antrian.');
    }

    // Batalkan reservasi
    public function destroy($id)
    {
        $reservation = Reservation::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        $reservation->delete();

        return back()->with('success', 'Reservasi dibatalkan.');
    }
}