@extends('layouts.app')

@section('title', 'Konfirmasi Pemesanan')

@section('content')
    <div class="container mx-auto px-4 py-8 text-white">
        <div class="bg-gray-800 p-8 rounded-lg shadow-lg max-w-2xl mx-auto text-center">
            <h1 class="text-4xl font-bold mb-6
                @if($booking->payment_status == 'paid') text-green-500
                @elseif($booking->payment_status == 'failed') text-red-500
                @else text-yellow-500 @endif
            ">{{ $booking->payment_status == 'paid' ? 'Pemesanan Berhasil & Terbayar!' : ($booking->payment_status == 'failed' ? 'Pembayaran Gagal!' : 'Pemesanan Dibuat (Menunggu Pembayaran)') }}</h1>

            <p class="text-lg text-gray-300 mb-4">Terima kasih telah memesan tiket di bioskop kami.</p>

            <div class="border border-gray-700 p-6 rounded-lg mb-6 text-left">
                <h2 class="text-2xl font-semibold mb-4">Detail Pemesanan</h2>
                <p class="mb-2"><strong>ID Pemesanan:</strong> {{ $booking->id }}</p>
                <p class="mb-2"><strong>Film:</strong> {{ $booking->showtime->movie->title }}</p>
                <p class="mb-2"><strong>Studio:</strong> {{ $booking->showtime->cinemaHall->name }}</p>
                <p class="mb-2"><strong>Tanggal:</strong> {{ $booking->showtime->date->format('d M Y') }}</p>
                <p class="mb-2"><strong>Waktu:</strong> {{ $booking->showtime->start_time->format('H:i') }}</p>
                <p class="mb-2"><strong>Jumlah Tiket:</strong> {{ $booking->number_of_tickets }}</p>
                <p class="mb-2"><strong>Kursi:</strong>
                    @foreach ($booking->bookedSeats as $seat)
                        <span class="inline-block bg-gray-700 text-white px-2 py-1 rounded-md text-sm mr-1 mb-1">{{ $seat->seat_number }}</span>
                    @endforeach
                </p>
                <p class="text-2xl font-bold mt-4">Total Harga: Rp {{ number_format($booking->total_price, 0, ',', '.') }}</p>
                <p class="mb-2 mt-4"><strong class="text-gray-300">Metode Pembayaran:</strong> <span class="text-white">{{ $booking->payment_method ? ucfirst(str_replace('_', ' ', $booking->payment_method)) : '-' }}</span></p>
                <p class="mb-2"><strong class="text-gray-300">Status Pembayaran:</strong>
                    <span class="relative inline-block px-3 py-1 font-semibold leading-tight">
                        <span aria-hidden class="absolute inset-0 opacity-50 rounded-full
                            @if($booking->payment_status == 'paid') bg-green-200
                            @elseif($booking->payment_status == 'failed') bg-red-200
                            @else bg-yellow-200 @endif"></span>
                        <span class="relative text-gray-900">{{ ucfirst($booking->payment_status) }}</span>
                    </span>
                </p>
                <p class="mb-2"><strong class="text-gray-300">Status Pemesanan:</strong>
                    <span class="relative inline-block px-3 py-1 font-semibold leading-tight">
                        <span aria-hidden class="absolute inset-0 opacity-50 rounded-full
                            @if($booking->status == 'confirmed') bg-green-200
                            @elseif($booking->status == 'cancelled') bg-red-200
                            @else bg-yellow-200 @endif"></span>
                        <span class="relative text-gray-900">{{ ucfirst($booking->status) }}</span>
                    </span>
                </p>
            </div>

            <p class="text-gray-400 mb-6">Silakan tunjukkan detail pemesanan ini di loket tiket atau scan QR Code (jika nanti diimplementasikan).</p>

            @if($booking->payment_status == 'pending')
                <a href="{{ route('booking.payment_form', $booking->id) }}" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-6 rounded-lg text-xl mr-4">Lanjutkan Pembayaran</a>
            @endif
            <a href="{{ route('booking.user_bookings') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded-lg text-xl mr-4">Lihat Riwayat Pemesanan</a>
            <a href="{{ route('home') }}" class="bg-gray-600 hover:bg-gray-700 text-white font-bold py-2 px-6 rounded-lg text-xl">Kembali ke Beranda</a>
        </div>
    </div>
@endsection