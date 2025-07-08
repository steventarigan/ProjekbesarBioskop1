<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CinemaHall extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'capacity',
        'rows',
        'columns',
    ];

    // Relasi ke Showtime (Sebuah hall bisa memiliki banyak jadwal tayang)
    public function showtimes()
    {
        return $this->hasMany(Showtime::class);
    }
}