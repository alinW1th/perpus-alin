<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Akun ADMIN (Untuk Demo Fitur Admin)
        User::create([
            'name' => 'Administrator',
            'email' => 'admin@unhas.ac.id',
            'password' => Hash::make('password'), // Password: password
            'role' => 'admin',
            'email_verified_at' => now(),
        ]);

        // 2. Akun PEGAWAI/MANAGER (Untuk Demo Validasi Peminjaman)
        User::create([
            'name' => 'Petugas Perpus',
            'email' => 'petugas@unhas.ac.id',
            'password' => Hash::make('password'),
            'role' => 'manager',
            'email_verified_at' => now(),
        ]);

        // 3. Akun MAHASISWA (Untuk Demo Pinjam Buku)
        User::create([
            'name' => 'Mahasiswa 1',
            'email' => 'mhs@unhas.ac.id',
            'password' => Hash::make('password'),
            'role' => 'user',
            'email_verified_at' => now(),
        ]);

        // 4. Panggil Seeder Buku (Agar otomatis membuat 10 buku palsu)
        $this->call(BookSeeder::class);
    }
}