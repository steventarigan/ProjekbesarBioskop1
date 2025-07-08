@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 py-8 text-white">
        <h1 class="text-4xl font-bold mb-6 text-center">Riwayat Pemesanan Anda</h1>

        @if ($bookings->isEmpty())
            <p class="text-gray-400 text-center">Anda belum memiliki riwayat pemesanan.</p>
            <div class="flex justify-center mt-6">
                <a href="{{ route('home') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded-lg text-xl">Pesan Tiket Sekarang</a>
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($bookings as $booking)
                    <div class="bg-gray-800 p-6 rounded-lg shadow-lg flex flex-col">
                        <h2 class="text-2xl font-semibold mb-3">{{ $booking->showtime->movie->title }}</h2>
                        <p class="text-gray-300 mb-1"><strong>ID Pemesanan:</strong> {{ $booking->id }}</p>
                        <p class="text-gray-300 mb-1"><strong>Studio:</strong> {{ $booking->showtime->cinemaHall->name }}</p>
                        <p class="text-gray-300 mb-1"><strong>Tanggal:</strong> {{ $booking->showtime->date->format('d M Y') }}</p>
                        <p class="text-gray-300 mb-1"><strong>Waktu:</strong> {{ $booking->showtime->start_time->format('H:i') }}</p>
                        <p class="text-gray-300 mb-1"><strong>Jumlah Tiket:</strong> {{ $booking->number_of_tickets }}</p>
                        <p class="text-gray-300 mb-3"><strong>Kursi:</strong>
                            @foreach ($booking->bookedSeats as $seat)
                                <span class="inline-block bg-gray-700 text-white px-2 py-1 rounded-md text-xs mr-1 mb-1">{{ $seat->seat_number }}</span>
                            @endforeach
                        </p>
                        <p class="text-xl font-bold mt-auto pt-3 border-t border-gray-700">Total Harga: Rp {{ number_format($booking->total_price, 0, ',', '.') }}</p>
                        <a href="{{ route('booking.confirmation', $booking->id) }}" class="mt-4 bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded-lg text-center">Lihat Detail</a>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
@endsection