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
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Pengguna yang memesan
            $table->foreignId('showtime_id')->constrained()->onDelete('cascade'); // Jadwal tayang yang dipesan
            $table->integer('number_of_tickets'); // Jumlah tiket yang dipesan
            $table->decimal('total_price', 10, 2); // Total harga pemesanan
            $table->string('status')->default('pending'); // Status pemesanan (pending, confirmed, cancelled)
            $table->string('payment_method')->nullable(); // Metode pembayaran (misal: credit_card, bank_transfer, cash)
            $table->string('payment_status')->default('pending'); // Status pembayaran (pending, paid, failed)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};