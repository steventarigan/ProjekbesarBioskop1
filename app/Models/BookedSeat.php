<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookedSeat extends Model
{
    use HasFactory;

    protected $fillable = [
        'booking_id',
        'showtime_id',
        'seat_number',
    ];

    // Relasi ke Booking
    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }

    // Relasi ke Showtime
    public function showtime()
    {
        return $this->belongsTo(Showtime::class);
    }
}