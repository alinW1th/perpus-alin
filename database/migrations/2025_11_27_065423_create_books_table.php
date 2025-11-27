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
        Schema::create('books', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique(); // Untuk URL yang cantik (misal: buku-harry-potter)
            $table->string('cover_image')->nullable(); // Foto sampul
            $table->string('author'); // Penulis
            $table->string('publisher'); // Penerbit
            $table->year('publication_year');
            $table->string('category');
            $table->text('description')->nullable();
            $table->integer('stock')->default(0);
            $table->integer('available_stock')->default(0); // Stok yang bisa dipinjam saat ini
            $table->integer('max_loan_days')->default(7); // Syarat dosen: lama pinjam
            $table->decimal('daily_fine', 10, 2)->default(1000); // Syarat dosen: denda
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('books');
    }
};