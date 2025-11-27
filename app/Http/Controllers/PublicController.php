<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ProductsController extends Controller
{
    /**
     * Menampilkan daftar buku (Admin Dashboard).
     */
    public function index()
    {
        $books = Book::latest()->paginate(10);
        return view('admin.books.index', compact('books'));
    }

    /**
     * Menampilkan form tambah buku.
     */
    public function create()
    {
        return view('admin.books.create');
    }

    /**
     * Menyimpan buku baru ke database.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'publisher' => 'required|string|max:255',
            'publication_year' => 'required|integer|min:1900|max:' . (date('Y') + 1),
            'category' => 'required|string',
            'stock' => 'required|integer|min:0',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048', // Max 2MB
            'description' => 'nullable|string',
        ]);

        // Handle Upload Gambar
        if ($request->hasFile('cover_image')) {
            // Simpan gambar di folder storage/app/public/books
            $path = $request->file('cover_image')->store('books', 'public');
            $validated['cover_image'] = '/storage/' . $path;
        } else {
            // Gambar default jika tidak diupload
            $validated['cover_image'] = 'https://via.placeholder.com/300x450.png?text=No+Cover';
        }

        $validated['slug'] = Str::slug($request->title) . '-' . Str::random(5);
        $validated['available_stock'] = $validated['stock']; // Stok tersedia = stok awal
        $validated['max_loan_days'] = 7; // Default aturan
        $validated['daily_fine'] = 1000; // Default denda

        Book::create($validated);

        return redirect()->route('books.index')->with('success', 'Buku berhasil ditambahkan!');
    }

    /**
     * Menampilkan form edit buku.
     */
    public function edit(string $id)
    {
        $book = Book::findOrFail($id);
        return view('admin.books.edit', compact('book'));
    }

    /**
     * Update data buku.
     */
    public function update(Request $request, string $id)
    {
        $book = Book::findOrFail($id);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'publisher' => 'required|string|max:255',
            'publication_year' => 'required|integer',
            'category' => 'required|string',
            'stock' => 'required|integer|min:0',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'description' => 'nullable|string',
        ]);

        if ($request->hasFile('cover_image')) {
            // Hapus gambar lama jika bukan link external
            if ($book->cover_image && !str_contains($book->cover_image, 'http')) {
                Storage::disk('public')->delete(str_replace('/storage/', '', $book->cover_image));
            }
            
            $path = $request->file('cover_image')->store('books', 'public');
            $validated['cover_image'] = '/storage/' . $path;
        }

        $validated['slug'] = Str::slug($request->title) . '-' . Str::random(5);
        
        // Update available stock based on difference
        $stockDiff = $validated['stock'] - $book->stock;
        $validated['available_stock'] = $book->available_stock + $stockDiff;

        $book->update($validated);

        return redirect()->route('books.index')->with('success', 'Buku berhasil diperbarui!');
    }

    /**
     * Hapus buku.
     */
    public function destroy(string $id)
    {
        $book = Book::findOrFail($id);
        
        // Hapus gambar jika ada di storage lokal
        if ($book->cover_image && !str_contains($book->cover_image, 'http')) {
             Storage::disk('public')->delete(str_replace('/storage/', '', $book->cover_image));
        }

        $book->delete();

        return redirect()->route('books.index')->with('success', 'Buku berhasil dihapus!');
    }
}