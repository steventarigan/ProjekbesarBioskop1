<?php

namespace App\Http\Controllers;

use App\Models\Showtime;
use App\Models\BookedSeat;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB; // Untuk transaksi database
use Carbon\Carbon; // Pastikan ini diimpor

class BookingController extends Controller
{
    /**
     * Menampilkan formulir pemilihan kursi untuk jadwal tayang tertentu.
     */
    public function selectSeats(Showtime $showtime)
    {
        // Ambil kursi yang sudah dipesan untuk jadwal tayang ini
        $bookedSeats = $showtime->bookedSeats->pluck('seat_number')->toArray();

        // Dapatkan informasi hall untuk menentukan layout kursi (jika ada rows/columns)
        $cinemaHall = $showtime->cinemaHall;
        $totalCapacity = $cinemaHall->capacity;
        $rows = $cinemaHall->rows ?? 0; // Default 0 jika tidak diset
        $columns = $cinemaHall->columns ?? 0; // Default 0 jika tidak diset

        // Jika rows dan columns tidak diset, kita bisa membuat layout default sederhana
        // Contoh: Jika kapasitas 100, buat 10 baris x 10 kolom
        if ($rows === 0 || $columns === 0) {
            $columns = 10; // Default kolom
            $rows = ceil($totalCapacity / $columns); // Hitung baris berdasarkan kapasitas
            if ($rows == 0 && $totalCapacity > 0) { // Pastikan minimal 1 baris jika ada kapasitas
                $rows = 1;
            }
        }

        // Generate array kursi untuk tampilan
        $allSeats = [];
        for ($r = 0; $r < $rows; $r++) {
            $rowName = chr(65 + $r); // A, B, C, ...
            for ($c = 1; $c <= $columns; $c++) {
                $seatNumber = $rowName . $c;
                $allSeats[] = $seatNumber;
            }
        }
        // Filter allSeats agar tidak melebihi totalCapacity jika rows/columns dihitung
        $allSeats = array_slice($allSeats, 0, $totalCapacity);


        return view('booking.select_seats', compact('showtime', 'bookedSeats', 'allSeats', 'rows', 'columns'));
    }

    /**
     * Memproses permintaan pemesanan tiket.
     */
    public function processBooking(Request $request, Showtime $showtime)
    {
        $request->validate([
            'selected_seats' => 'required|array|min:1',
            'selected_seats.*' => 'required|string|max:10', // Contoh: A1, B10
        ]);

        $selectedSeats = $request->input('selected_seats');
        $numberOfTickets = count($selectedSeats);
        $totalPrice = $numberOfTickets * $showtime->ticket_price;

        // Memulai transaksi database untuk memastikan atomicity
        DB::beginTransaction();

        try {
            // 1. Cek ketersediaan kursi lagi (untuk menghindari race condition)
            $alreadyBookedSeats = BookedSeat::where('showtime_id', $showtime->id)
                                            ->whereIn('seat_number', $selectedSeats)
                                            ->count();

            if ($alreadyBookedSeats > 0) {
                DB::rollBack();
                return back()->withInput()->withErrors(['seats' => 'Beberapa kursi yang Anda pilih sudah dipesan oleh orang lain. Silakan pilih kursi lain.']);
            }

            // 2. Buat entri Booking
            $booking = Booking::create([
                'user_id' => Auth::id(),
                'showtime_id' => $showtime->id,
                'number_of_tickets' => $numberOfTickets,
                'total_price' => $totalPrice,
                'status' => 'pending', // Status awal: pending
                'payment_method' => null, // Belum ada metode pembayaran spesifik
                'payment_status' => 'pending', // Status pembayaran awal: pending
            ]);

            // 3. Simpan kursi yang dipesan
            $seatsToBook = [];
            foreach ($selectedSeats as $seatNumber) {
                $seatsToBook[] = [
                    'booking_id' => $booking->id,
                    'showtime_id' => $booking->showtime_id, // Gunakan ID dari booking yang baru dibuat
                    'seat_number' => $seatNumber,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
            BookedSeat::insert($seatsToBook); // Insert multiple rows

            DB::commit();

            // Redirect ke halaman pembayaran
            return redirect()->route('booking.payment_form', $booking->id)->with('success', 'Pemesanan tiket berhasil dibuat. Silakan lanjutkan pembayaran.');

        } catch (\Exception $e) {
            DB::rollBack();
            // Log error: $e->getMessage()
            dd($e->getMessage()); // <--- BARIS INI YANG DIUBAH (DIHAPUS KOMENTARNYA)
            return back()->withInput()->withErrors(['error' => 'Terjadi kesalahan saat memproses pemesanan Anda. Silakan coba lagi.']);
        }
    }

    /**
     * Menampilkan halaman konfirmasi pemesanan/detail.
     */
    public function showConfirmation(Booking $booking)
    {
        // Pastikan pengguna adalah pemilik booking atau admin
        // Asumsi ada kolom 'is_admin' di tabel users atau method is_admin() di model User
        if (Auth::id() !== $booking->user_id && !(Auth::check() && Auth::user()->role === 'admin')) {
            abort(403, 'Unauthorized action.');
        }

        $booking->load(['showtime.movie', 'showtime.cinemaHall', 'bookedSeats']);
        return view('booking.confirmation', compact('booking'));
    }

    /**
     * Menampilkan formulir pembayaran untuk pemesanan tertentu.
     */
    public function showPaymentForm(Booking $booking)
    {
        // Pastikan pengguna adalah pemilik booking dan status pembayarannya masih pending
        if (Auth::id() !== $booking->user_id || $booking->payment_status !== 'pending') {
            return redirect()->route('booking.confirmation', $booking->id)->with('error', 'Pemesanan ini tidak dapat diproses pembayarannya.');
        }

        $booking->load(['showtime.movie', 'showtime.cinemaHall', 'bookedSeats']);
        return view('booking.payment', compact('booking'));
    }

    /**
     * Memproses simulasi pembayaran.
     */
    public function processPayment(Request $request, Booking $booking)
    {
        // Pastikan pengguna adalah pemilik booking dan status pembayarannya masih pending
        if (Auth::id() !== $booking->user_id || $booking->payment_status !== 'pending') {
            return redirect()->route('booking.confirmation', $booking->id)->with('error', 'Pemesanan ini tidak dapat diproses pembayarannya.');
        }

        $request->validate([
            'payment_method' => 'required|in:credit_card,bank_transfer,e_wallet',
            // Validasi ini opsional, tergantung seberapa detail simulasi kartu kredit yang diinginkan
            'card_number' => 'required_if:payment_method,credit_card|nullable|string|max:16',
            'expiry_date' => 'required_if:payment_method,credit_card|nullable|string|max:5',
            'cvv' => 'required_if:payment_method,credit_card|nullable|string|max:4',
        ]);

        // Simulasi proses pembayaran
        // Di sini Anda akan mengintegrasikan dengan payment gateway asli (misal: Midtrans, Xendit, Doku)
        // Untuk simulasi, kita akan selalu menganggap pembayaran sukses
        $paymentStatus = 'paid';
        $bookingStatus = 'confirmed'; // Otomatis confirmed jika pembayaran sukses

        // Update status pemesanan
        $booking->update([
            'payment_method' => $request->payment_method,
            'payment_status' => $paymentStatus,
            'status' => $bookingStatus,
        ]);

        return redirect()->route('booking.confirmation', $booking->id)->with('success', 'Pembayaran berhasil! Pemesanan Anda telah dikonfirmasi.');
    }

    /**
     * Menampilkan riwayat pemesanan pengguna yang sedang login.
     */
    public function userBookings()
    {
        $bookings = Auth::user()->bookings()->with(['showtime.movie', 'showtime.cinemaHall', 'bookedSeats'])->orderBy('created_at', 'desc')->get();
        return view('booking.user_bookings', compact('bookings'));
    }
}
