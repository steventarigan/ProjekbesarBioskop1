<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany; // Tambahkan ini

class Showtime extends Model
{
    use HasFactory;

    protected $fillable = [
        'movie_id',
        'cinema_hall_id',
        'date',
        'start_time',
        'end_time',
        'ticket_price',
    ];

    protected $casts = [
        'date' => 'date',
        'start_time' => 'datetime',
        'end_time' => 'datetime',
        'ticket_price' => 'decimal:2',
    ];

    public function movie()
    {
        return $this->belongsTo(Movie::class);
    }

    public function cinemaHall()
    {
        return $this->belongsTo(CinemaHall::class);
    }

    // Relasi ke Booking (satu jadwal tayang bisa punya banyak booking)
    public function bookings(): HasMany // Tambahkan ini
    {
        return $this->hasMany(Booking::class);
    }

    // Relasi ke BookedSeat (untuk mengetahui kursi mana saja yang sudah terisi di jadwal tayang ini)
    public function bookedSeats(): HasMany // Tambahkan ini
    {
        return $this->hasMany(BookedSeat::class);
    }
}