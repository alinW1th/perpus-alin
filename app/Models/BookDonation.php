<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BookDonation extends Model
{
    protected $fillable = [
        'user_id', 'title', 'author', 'publication_year', 
        'category', 'cover_image', 'status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}