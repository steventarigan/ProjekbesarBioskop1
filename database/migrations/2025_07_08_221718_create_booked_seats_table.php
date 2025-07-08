<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('booked_seats', function (Blueprint $table) {
            $table->id();
            $table->foreignId('booking_id')->constrained()->onDelete('cascade'); // Terkait dengan pemesanan mana
            $table->foreignId('showtime_id')->constrained()->onDelete('cascade'); // Terkait dengan jadwal tayang mana (redundant tapi bisa untuk query cepat)
            $table->string('seat_number'); // Nomor kursi (misal: A1, B5)
            $table->timestamps();

            // Mencegah kursi yang sama dipesan dua kali untuk jadwal tayang yang sama
            $table->unique(['showtime_id', 'seat_number']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('booked_seats');
    }
};