@extends('layouts.admin')

@section('content')
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-4xl font-bold text-white">Manajemen Jadwal Tayang</h1>
        <a href="{{ route('admin.showtimes.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Tambah Jadwal Tayang Baru</a>
    </div>

    @if ($showtimes->isEmpty())
        <p class="text-gray-400">Belum ada jadwal tayang yang ditambahkan.</p>
    @else
        <div class="overflow-x-auto bg-gray-800 rounded-lg shadow-lg">
            <table class="min-w-full leading-normal">
                <thead>
                    <tr>
                        <th class="px-5 py-3 border-b-2 border-gray-700 bg-gray-700 text-left text-xs font-semibold text-gray-300 uppercase tracking-wider">
                            Film
                        </th>
                        <th class="px-5 py-3 border-b-2 border-gray-700 bg-gray-700 text-left text-xs font-semibold text-gray-300 uppercase tracking-wider">
                            Studio
                        </th>
                        <th class="px-5 py-3 border-b-2 border-gray-700 bg-gray-700 text-left text-xs font-semibold text-gray-300 uppercase tracking-wider">
                            Tanggal
                        </th>
                        <th class="px-5 py-3 border-b-2 border-gray-700 bg-gray-700 text-left text-xs font-semibold text-gray-300 uppercase tracking-wider">
                            Waktu Mulai
                        </th>
                        <th class="px-5 py-3 border-b-2 border-gray-700 bg-gray-700 text-left text-xs font-semibold text-gray-300 uppercase tracking-wider">
                            Waktu Selesai
                        </th>
                        <th class="px-5 py-3 border-b-2 border-gray-700 bg-gray-700 text-left text-xs font-semibold text-gray-300 uppercase tracking-wider">
                            Harga Tiket
                        </th>
                        <th class="px-5 py-3 border-b-2 border-gray-700 bg-gray-700 text-left text-xs font-semibold text-gray-300 uppercase tracking-wider">
                            Aksi
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($showtimes as $showtime)
                    <tr>
                        <td class="px-5 py-5 border-b border-gray-700 bg-gray-800 text-sm">
                            <p class="text-white whitespace-no-wrap">{{ $showtime->movie->title }}</p>
                        </td>
                        <td class="px-5 py-5 border-b border-gray-700 bg-gray-800 text-sm">
                            <p class="text-white whitespace-no-wrap">{{ $showtime->cinemaHall->name }}</p>
                        </td>
                        <td class="px-5 py-5 border-b border-gray-700 bg-gray-800 text-sm">
                            <p class="text-white whitespace-no-wrap">{{ $showtime->date->format('d M Y') }}</p>
                        </td>
                        <td class="px-5 py-5 border-b border-gray-700 bg-gray-800 text-sm">
                            <p class="text-white whitespace-no-wrap">{{ $showtime->start_time->format('H:i') }}</p>
                        </td>
                        <td class="px-5 py-5 border-b border-gray-700 bg-gray-800 text-sm">
                            <p class="text-white whitespace-no-wrap">{{ $showtime->end_time->format('H:i') }}</p>
                        </td>
                        <td class="px-5 py-5 border-b border-gray-700 bg-gray-800 text-sm">
                            <p class="text-white whitespace-no-wrap">Rp {{ number_format($showtime->ticket_price, 0, ',', '.') }}</p>
                        </td>
                        <td class="px-5 py-5 border-b border-gray-700 bg-gray-800 text-sm">
                            <a href="{{ route('admin.showtimes.edit', $showtime->id) }}" class="text-yellow-500 hover:text-yellow-400 mr-3">Edit</a>
                            <form action="{{ route('admin.showtimes.destroy', $showtime->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus jadwal tayang ini?');">
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
