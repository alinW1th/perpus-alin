<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class BookSeeder extends Seeder
{
    public function run(): void
    {
        // Kita buat 10 buku otomatis
        for ($i = 1; $i <= 50; $i++) {
            DB::table('books')->insert([
                'title' => 'Buku Contoh ' . $i,
                'slug' => 'buku-contoh-' . $i . '-' . Str::random(5),
                'cover_image' => null, // Biarkan kosong atau isi path gambar default jika ada
                'author' => 'Penulis ' . chr(64 + $i), // Menghasilkan Penulis A, B, C...
                'publisher' => 'Penerbit Universitas',
                'publication_year' => rand(2018, 2024),
                'category' => 'Teknologi',
                'description' => 'Ini adalah deskripsi otomatis untuk keperluan demo aplikasi perpustakaan.',
                'stock' => 10,
                'available_stock' => 10,
                'max_loan_days' => 7,
                'daily_fine' => 1000,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}