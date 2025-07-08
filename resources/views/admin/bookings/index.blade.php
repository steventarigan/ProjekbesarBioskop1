@extends('layouts.admin')

@section('content')
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-4xl font-bold text-white">Manajemen Pemesanan</h1>
        {{-- Tidak ada tombol "Tambah Pemesanan" karena pemesanan dibuat oleh user --}}
    </div>

    @if (session('success'))
        <div class="bg-green-600 text-white p-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif
    @if (session('error'))
        <div class="bg-red-600 text-white p-3 rounded mb-4">
            {{ session('error') }}
        </div>
    @endif

    @if ($bookings->isEmpty())
        <p class="text-gray-400">Belum ada pemesanan yang masuk.</p>
    @else
        <div class="overflow-x-auto bg-gray-800 rounded-lg shadow-lg">
            <table class="min-w-full leading-normal">
                <thead>
                    <tr>
                        <th class="px-5 py-3 border-b-2 border-gray-700 bg-gray-700 text-left text-xs font-semibold text-gray-300 uppercase tracking-wider">
                            ID Pemesanan
                        </th>
                        <th class="px-5 py-3 border-b-2 border-gray-700 bg-gray-700 text-left text-xs font-semibold text-gray-300 uppercase tracking-wider">
                            Pengguna
                        </th>
                        <th class="px-5 py-3 border-b-2 border-gray-700 bg-gray-700 text-left text-xs font-semibold text-gray-300 uppercase tracking-wider">
                            Film & Jadwal
                        </th>
                        <th class="px-5 py-3 border-b-2 border-gray-700 bg-gray-700 text-left text-xs font-semibold text-gray-300 uppercase tracking-wider">
                            Total Harga
                        </th>
                        <th class="px-5 py-3 border-b-2 border-gray-700 bg-gray-700 text-left text-xs font-semibold text-gray-300 uppercase tracking-wider">
                            Status
                        </th>
                        <th class="px-5 py-3 border-b-2 border-gray-700 bg-gray-700 text-left text-xs font-semibold text-gray-300 uppercase tracking-wider">
                            Status Pembayaran
                        </th>
                        <th class="px-5 py-3 border-b-2 border-gray-700 bg-gray-700 text-left text-xs font-semibold text-gray-300 uppercase tracking-wider">
                            Aksi
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($bookings as $booking)
                    <tr>
                        <td class="px-5 py-5 border-b border-gray-700 bg-gray-800 text-sm">
                            <p class="text-white whitespace-no-wrap">{{ $booking->id }}</p>
                        </td>
                        <td class="px-5 py-5 border-b border-gray-700 bg-gray-800 text-sm">
                            <p class="text-white whitespace-no-wrap">{{ $booking->user->name }}</p>
                            <p class="text-gray-400 text-xs whitespace-no-wrap">{{ $booking->user->email }}</p>
                        </td>
                        <td class="px-5 py-5 border-b border-gray-700 bg-gray-800 text-sm">
                            <p class="text-white whitespace-no-wrap">{{ $booking->showtime->movie->title }}</p>
                            <p class="text-gray-400 text-xs whitespace-no-wrap">{{ $booking->showtime->date->format('d M Y') }} - {{ $booking->showtime->start_time->format('H:i') }} ({{ $booking->showtime->cinemaHall->name }})</p>
                        </td>
                        <td class="px-5 py-5 border-b border-gray-700 bg-gray-800 text-sm">
                            <p class="text-white whitespace-no-wrap">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</p>
                        </td>
                        <td class="px-5 py-5 border-b border-gray-700 bg-gray-800 text-sm">
                            <span class="relative inline-block px-3 py-1 font-semibold leading-tight">
                                <span aria-hidden class="absolute inset-0 opacity-50 rounded-full
                                    @if($booking->status == 'confirmed') bg-green-200
                                    @elseif($booking->status == 'cancelled') bg-red-200
                                    @else bg-yellow-200 @endif"></span>
                                <span class="relative text-gray-900">{{ ucfirst($booking->status) }}</span>
                            </span>
                        </td>
                        <td class="px-5 py-5 border-b border-gray-700 bg-gray-800 text-sm">
                            <span class="relative inline-block px-3 py-1 font-semibold leading-tight">
                                <span aria-hidden class="absolute inset-0 opacity-50 rounded-full
                                    @if($booking->payment_status == 'paid') bg-green-200
                                    @elseif($booking->payment_status == 'failed') bg-red-200
                                    @else bg-yellow-200 @endif"></span>
                                <span class="relative text-gray-900">{{ ucfirst($booking->payment_status) }}</span>
                            </span>
                        </td>
                        <td class="px-5 py-5 border-b border-gray-700 bg-gray-800 text-sm">
                            <a href="{{ route('admin.bookings.show', $booking->id) }}" class="text-blue-500 hover:text-blue-400 mr-3">Detail</a>
                            <a href="{{ route('admin.bookings.edit', $booking->id) }}" class="text-yellow-500 hover:text-yellow-400 mr-3">Edit Status</a>
                            <form action="{{ route('admin.bookings.destroy', $booking->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus pemesanan ini? Ini akan menghapus semua data terkait.');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500 hover:text-red-400">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
@endsection
