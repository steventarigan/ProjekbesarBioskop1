<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'genre',
        'duration',
        'release_date',
        'poster_url',
        'trailer_url',
    ];

    protected $casts = [
        'release_date' => 'date',
    ];

    // Relasi ke Showtime (Sebuah film bisa memiliki banyak jadwal tayang)
    public function showtimes()
    {
        return $this->hasMany(Showtime::class);
    }
}