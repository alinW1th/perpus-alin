<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'slug', 'cover_image', 'author', 'publisher',
        'publication_year', 'category', 'description', 'stock',
        'available_stock', 'max_loan_days', 'daily_fine',
    ];

    // --- RELASI ---

    public function loans()
    {
        return $this->hasMany(Loan::class);
    }

    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }

    // WAJIB ADA: Relasi ke model Review
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    // --- ACCESSOR ---

    public function getAverageRatingAttribute()
    {
        // 1. Ambil nilai rata-rata (bisa null jika belum ada review)
        $average = $this->reviews()->avg('rating');

        // 2. Cek: Jika null, kembalikan 0. Jika ada, baru di-round.
        return $average ? round($average, 1) : 0;
    }
}