<?php

namespace App\Http\Controllers;

use App\Models\BookDonation;
use App\Models\Book; // Import Model Book untuk waqaf yang diterima
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str; // Tambahkan ini

class BookDonationController extends Controller
{
    // Halaman Donasi Mahasiswa
    public function index()
    {
        $donations = BookDonation::where('user_id', Auth::id())->latest()->get();
        return view('dashboard.user.donations.index', compact('donations'));
    }

    // Proses Simpan Donasi
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'author' => 'required',
            'publication_year' => 'required|numeric',
            'category' => 'required',
            'cover_image' => 'nullable|image|max:2048'
        ]);

        $data = $request->all();
        $data['user_id'] = Auth::id();

        if ($request->hasFile('cover_image')) {
            $data['cover_image'] = $request->file('cover_image')->store('donations', 'public');
        }

        BookDonation::create($data);

        return back()->with('success', 'Pengajuan waqaf buku berhasil dikirim. Menunggu konfirmasi.');
    }

    // Halaman Manager Lihat Donasi
    public function managerIndex()
    {
        $donations = BookDonation::with('user')->where('status', 'pending')->latest()->get();
        return view('dashboard.manager.donations', compact('donations'));
    }

    // Manager Terima/Tolak
    public function updateStatus(Request $request, $id)
    {
        $donation = BookDonation::findOrFail($id);
        $donation->update(['status' => $request->status]);
        
        // Jika diterima, otomatis masuk ke Katalog Buku
        if($request->status == 'accepted') {
            Book::create([
                'title' => $donation->title,
                'slug' => Str::slug($donation->title) . '-' . rand(100,999),
                'author' => $donation->author,
                'publisher' => 'Sumbangan Mahasiswa (' . $donation->user->name . ')',
                'publication_year' => $donation->publication_year,
                'category' => $donation->category,
                'stock' => 1,
                'available_stock' => 1,
                'daily_fine' => 1000,
                'cover_image' => $donation->cover_image
            ]);
        }

        return back()->with('success', 'Status donasi diperbarui.');
    }
}   