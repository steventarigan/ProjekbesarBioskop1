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
        Schema::create('cinema_halls', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique(); // Nama studio/hall (misal: Studio 1, Studio IMAX)
            $table->integer('capacity'); // Total kapasitas kursi
            $table->integer('rows')->nullable(); // Jumlah baris kursi (opsional, untuk layout kursi)
            $table->integer('columns')->nullable(); // Jumlah kolom kursi (opsional, untuk layout kursi)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cinema_halls');
    }
};