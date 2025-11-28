<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

class PublicController extends Controller
{
    /**
     * Halaman Depan (Landing Page) dengan Fitur Pencarian
     */
    public function index(Request $request)
    {
        // Query dasar
        $query = Book::query();

        // Jika ada pencarian
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where('title', 'like', "%{$search}%")
                  ->orWhere('author', 'like', "%{$search}%")
                  ->orWhere('category', 'like', "%{$search}%");
        }

        // Ambil hasil pencarian (atau semua buku jika tidak mencari)
        $allBooks = $query->latest()->get();

        // Banner atas tetap menampilkan 4 buku terbaru murni
        $latestBooks = Book::latest()->take(4)->get();

        return view('welcome', compact('latestBooks', 'allBooks'));
    }

    /**
     * Halaman Detail Buku
     */
    public function show($slug)
    {
        $book = Book::where('slug', $slug)->firstOrFail();
        return view('public.book-detail', compact('book'));
    }
}