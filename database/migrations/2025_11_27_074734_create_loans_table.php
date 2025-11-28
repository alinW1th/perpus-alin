<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('loans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Peminjam
            $table->foreignId('book_id')->constrained()->onDelete('cascade'); // Buku yang dipinjam
            
            $table->date('loan_date');      // Tanggal pinjam
            $table->date('due_date');       // Batas waktu pengembalian (Jatuh Tempo)
            $table->date('return_date')->nullable(); // Tanggal pengembalian real (diisi saat dikembalikan)
            
            // Status Peminjaman: dipinjam, dikembalikan
            $table->enum('status', ['borrowed', 'returned'])->default('borrowed');
            
            // Denda
            $table->decimal('fine_amount', 10, 2)->default(0); // Nominal denda
            // Status Denda: tidak ada, belum lunas, lunas
            $table->enum('fine_status', ['no_fine', 'unpaid', 'paid'])->default('no_fine');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('loans');
    }
};