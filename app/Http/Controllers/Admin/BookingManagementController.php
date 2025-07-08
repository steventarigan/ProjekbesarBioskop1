<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\Request;

class BookingManagementController extends Controller
{
    /**
     * Display a listing of all bookings.
     */
    public function index()
    {
        // Ambil semua pemesanan dengan eager loading relasi yang diperlukan
        $bookings = Booking::with(['user', 'showtime.movie', 'showtime.cinemaHall', 'bookedSeats'])
                            ->orderBy('created_at', 'desc')
                            ->get();

        return view('admin.bookings.index', compact('bookings'));
    }

    /**
     * Display the specified booking details.
     */
    public function show(Booking $booking) // Route Model Binding
    {
        // Load relasi yang diperlukan untuk detail
        $booking->load(['user', 'showtime.movie', 'showtime.cinemaHall', 'bookedSeats']);
        return view('admin.bookings.show', compact('booking'));
    }

    /**
     * Show the form for editing the specified booking status.
     * (Opsional, bisa langsung update tanpa form terpisah jika hanya status)
     */
    public function edit(Booking $booking)
    {
        $booking->load(['user', 'showtime.movie', 'showtime.cinemaHall', 'bookedSeats']);
        return view('admin.bookings.edit', compact('booking'));
    }

    /**
     * Update the specified booking status in storage.
     */
    public function update(Request $request, Booking $booking)
    {
        $request->validate([
            'status' => 'required|in:pending,confirmed,cancelled', // Validasi status yang diizinkan
            'payment_status' => 'required|in:pending,paid,failed', // Validasi status pembayaran
        ]);

        $booking->update([
            'status' => $request->status,
            'payment_status' => $request->payment_status,
        ]);

        return redirect()->route('admin.bookings.index')->with('success', 'Status pemesanan berhasil diperbarui!');
    }

    /**
     * Remove the specified booking from storage.
     * (Hati-hati dengan ini, biasanya pemesanan tidak dihapus tapi di-cancel)
     */
    public function destroy(Booking $booking)
    {
        $booking->delete(); // Ini akan menghapus booking dan booked_seats terkait karena onDelete('cascade')
        return redirect()->route('admin.bookings.index')->with('success', 'Pemesanan berhasil dihapus!');
    }
}
