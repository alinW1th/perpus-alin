<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

// --- BARIS PENTING YANG DITAMBAHKAN ---
use App\Models\Loan;
use App\Models\Reservation;
use App\Models\Review;
// --------------------------------------

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role', // Kolom role wajib ada
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // --- RELASI TAMBAHAN ---

    // 1. Relasi User -> Peminjaman
    public function loans()
    {
        return $this->hasMany(Loan::class);
    }

    // 2. Relasi User -> Reservasi
    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }

    // 3. Relasi User -> Review
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    // --- HELPER METHODS ---

    // Cek apakah user punya denda tertunggak
    public function hasUnpaidFines()
    {
        return $this->loans()->where('fine_status', 'unpaid')->exists();
    }
}
