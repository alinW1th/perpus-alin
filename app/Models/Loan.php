<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Loan extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'book_id',
        'loan_date',
        'due_date',
        'return_date',
        'status',
        'fine_amount',
        'fine_status',
    ];

    // Relasi: Peminjaman milik satu User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi: Peminjaman adalah untuk satu Buku
    public function book()
    {
        return $this->belongsTo(Book::class);
    }
}