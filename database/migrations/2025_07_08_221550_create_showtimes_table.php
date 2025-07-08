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
        Schema::create('showtimes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('movie_id')->constrained()->onDelete('cascade'); // Film yang tayang
            $table->foreignId('cinema_hall_id')->constrained()->onDelete('cascade'); // Studio tempat tayang
            $table->date('date'); // Tanggal tayang
            $table->time('start_time'); // Waktu mulai tayang
            $table->time('end_time');   // Waktu selesai tayang (bisa dihitung dari durasi film)
            $table->decimal('ticket_price', 8, 2); // Harga tiket
            $table->timestamps();

            // Optional: Menambahkan unique constraint agar tidak ada jadwal tayang yang bentrok di studio yang sama pada waktu yang sama
            $table->unique(['cinema_hall_id', 'date', 'start_time']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('showtimes');
    }
};