@extends('layouts.admin')

@section('content')
    <h1 class="text-4xl font-bold text-white mb-6">Detail Pemesanan #{{ $booking->id }}</h1>

    <div class="bg-gray-800 p-8 rounded-lg shadow-lg max-w-3xl mx-auto">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
            <div>
                <h2 class="text-2xl font-semibold text-red-500 mb-3">Informasi Pemesanan</h2>
                <p class="mb-2"><strong class="text-gray-300">ID Pemesanan:</strong> <span class="text-white">{{ $booking->id }}</span></p>
                <p class="mb-2"><strong class="text-gray-300">Total Harga:</strong> <span class="text-white">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</span></p>
                <p class="mb-2"><strong class="text-gray-300">Jumlah Tiket:</strong> <span class="text-white">{{ $booking->number_of_tickets }}</span></p>
                <p class="mb-2"><strong class="text-gray-300">Status Pemesanan:</strong>
                    <span class="relative inline-block px-3 py-1 font-semibold leading-tight">
                        <span aria-hidden class="absolute inset-0 opacity-50 rounded-full
                            @if($booking->status == 'confirmed') bg-green-200
                            @elseif($booking->status == 'cancelled') bg-red-200
                            @else bg-yellow-200 @endif"></span>
                        <span class="relative text-gray-900">{{ ucfirst($booking->status) }}</span>
                    </span>
                </p>
                <p class="mb-2"><strong class="text-gray-300">Status Pembayaran:</strong>
                    <span class="relative inline-block px-3 py-1 font-semibold leading-tight">
                        <span aria-hidden class="absolute inset-0 opacity-50 rounded-full
                            @if($booking->payment_status == 'paid') bg-green-200
                            @elseif($booking->payment_status == 'failed') bg-red-200
                            @else bg-yellow-200 @endif"></span>
                        <span class="relative text-gray-900">{{ ucfirst($booking->payment_status) }}</span>
                    </span>
                </p>
                <p class="mb-2"><strong class="text-gray-300">Dibuat Pada:</strong> <span class="text-white">{{ $booking->created_at->format('d M Y H:i') }}</span></p>
            </div>

            <div>
                <h2 class="text-2xl font-semibold text-red-500 mb-3">Informasi Pengguna</h2>
                <p class="mb-2"><strong class="text-gray-300">Nama:</strong> <span class="text-white">{{ $booking->user->name }}</span></p>
                <p class="mb-2"><strong class="text-gray-300">Email:</strong> <span class="text-white">{{ $booking->user->email }}</span></p>
            </div>
        </div>

        <div class="mb-6">
            <h2 class="text-2xl font-semibold text-red-500 mb-3">Informasi Jadwal Tayang</h2>
            <p class="mb-2"><strong class="text-gray-300">Film:</strong> <span class="text-white">{{ $booking->showtime->movie->title }}</span></p>
            <p class="mb-2"><strong class="text-gray-300">Studio:</strong> <span class="text-white">{{ $booking->showtime->cinemaHall->name }}</span></p>
            <p class="mb-2"><strong class="text-gray-300">Tanggal:</strong> <span class="text-white">{{ $booking->showtime->date->format('d M Y') }}</span></p>
            <p class="mb-2"><strong class="text-gray-300">Waktu:</strong> <span class="text-white">{{ $booking->showtime->start_time->format('H:i') }} - {{ $booking->showtime->end_time->format('H:i') }}</span></p>
            <p class="mb-2"><strong class="text-gray-300">Harga Tiket Satuan:</strong> <span class="text-white">Rp {{ number_format($booking->showtime->ticket_price, 0, ',', '.') }}</span></p>
        </div>

        <div class="mb-6">
            <h2 class="text-2xl font-semibold text-red-500 mb-3">Kursi yang Dipesan</h2>
            @if ($booking->bookedSeats->isEmpty())
                <p class="text-gray-400">Tidak ada kursi yang tercatat untuk pemesanan ini.</p>
            @else
                <div class="flex flex-wrap gap-2">
                    @foreach ($booking->bookedSeats as $seat)
                        <span class="bg-blue-600 text-white px-3 py-1 rounded-full text-sm font-semibold">{{ $seat->seat_number }}</span>
                    @endforeach
                </div>
            @endif
        </div>

        <div class="flex justify-between items-center mt-8">
            <a href="{{ route('admin.bookings.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Kembali</a>
            <a href="{{ route('admin.bookings.edit', $booking->id) }}" class="bg-yellow-600 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Edit Status</a>
            <form action="{{ route('admin.bookings.destroy', $booking->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus pemesanan ini? Ini akan menghapus semua data terkait.');">
                @csrf
                @method('DELETE')
                <button type="submit" class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Hapus Pemesanan</button>
            </form>
        </div>
    </div>
@endsection
