<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'showtime_id',
        'number_of_tickets',
        'total_price',
        'status',
        'payment_method',
        'payment_status',
    ];

    protected $casts = [
        'total_price' => 'decimal:2',
    ];

    // Relasi ke User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke Showtime
    public function showtime()
    {
        return $this->belongsTo(Showtime::class);
    }

    // Relasi ke BookedSeat (satu booking bisa punya banyak kursi)
    public function bookedSeats()
    {
        return $this->hasMany(BookedSeat::class);
    }
}