<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Tambah kolom bukti bayar di tabel Loans
        Schema::table('loans', function (Blueprint $table) {
            $table->string('payment_proof')->nullable()->after('fine_status');
        });

        // 2. Buat tabel baru untuk Waqaf Buku
        Schema::create('book_donations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('title');
            $table->string('author');
            $table->year('publication_year');
            $table->string('category');
            $table->string('cover_image')->nullable();
            $table->enum('status', ['pending', 'accepted', 'rejected'])->default('pending');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::table('loans', function (Blueprint $table) {
            $table->dropColumn('payment_proof');
        });
        Schema::dropIfExists('book_donations');
    }
};