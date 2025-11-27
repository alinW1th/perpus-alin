<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class BookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Data dummy buku dengan kategori berbeda
        $books = [
            [
                'title' => 'Algoritma Pemrograman',
                'author' => 'Rinaldi Munir',
                'category' => 'Teknologi',
                'cover_image' => 'https://images.unsplash.com/photo-1515879218367-8466d910aaa4?auto=format&fit=crop&q=80&w=300&h=450',
            ],
            [
                'title' => 'Sistem Informasi Manajemen',
                'author' => 'Kenneth C. Laudon',
                'category' => 'Bisnis',
                'cover_image' => 'https://images.unsplash.com/photo-1460925895917-afdab827c52f?auto=format&fit=crop&q=80&w=300&h=450',
            ],
            [
                'title' => 'Desain UI/UX Modern',
                'author' => 'Michael Sutanto',
                'category' => 'Desain',
                'cover_image' => 'https://images.unsplash.com/photo-1586717791821-3f44a5638d48?auto=format&fit=crop&q=80&w=300&h=450',
            ],
            [
                'title' => 'Machine Learning Basics',
                'author' => 'Andrew Ng',
                'category' => 'Teknologi',
                'cover_image' => 'https://images.unsplash.com/photo-1555949963-aa79dcee981c?auto=format&fit=crop&q=80&w=300&h=450',
            ],
             [
                'title' => 'Filosofi Teras',
                'author' => 'Henry Manampiring',
                'category' => 'Psikologi',
                'cover_image' => 'https://images.unsplash.com/photo-1544947950-fa07a98d237f?auto=format&fit=crop&q=80&w=300&h=450',
            ],
        ];

        foreach ($books as $book) {
            DB::table('books')->insert([
                'title' => $book['title'],
                'slug' => Str::slug($book['title']),
                'cover_image' => $book['cover_image'],
                'author' => $book['author'],
                'publisher' => 'Informatika Bandung',
                'publication_year' => rand(2018, 2024),
                'category' => $book['category'],
                'description' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Quisquam, voluptatum.',
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