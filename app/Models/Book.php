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
}