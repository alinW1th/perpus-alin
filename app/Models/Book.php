<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'cover_image',
        'author',
        'publisher',
        'publication_year',
        'category',
        'description',
        'stock',
        'available_stock',
        'max_loan_days',
        'daily_fine',
    ];
    public function loans()
    {
        return $this->hasMany(Loan::class);
    }
    // ... method loans() yang sudah ada ...

    // Tambahkan ini
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    // Helper untuk menghitung rata-rata rating
    public function getAverageRatingAttribute()
    {
        return round($this->reviews()->avg('rating'), 1);
    }
}