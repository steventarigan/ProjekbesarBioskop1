@extends('layouts.app')

@section('title', 'Daftar Film')

@section('content')
    <h1 class="text-4xl font-bold text-white mb-8 text-center">Sedang Tayang di Bioskopku</h1>

    @if ($movies->isEmpty())
        <p class="text-gray-400 text-center text-lg">Belum ada film yang tersedia saat ini.</p>
    @else
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8">
            @foreach ($movies as $movie)
                <div class="bg-gray-800 rounded-lg shadow-lg overflow-hidden transform hover:scale-105 transition duration-300">
                    <img src="{{ $movie->poster_url ?: 'https://via.placeholder.com/300x450.png?text=No+Poster' }}"
                         alt="{{ $movie->title }} Poster" class="w-full h-80 object-cover">
                    <div class="p-5">
                        <h2 class="text-2xl font-bold text-red-500 mb-2">{{ $movie->title }}</h2>
                        <p class="text-gray-300 text-sm mb-1">Genre: {{ $movie->genre }}</p>
                        <p class="text-gray-300 text-sm mb-3">Durasi: {{ $movie->duration }} menit</p>
                        <p class="text-gray-400 text-base line-clamp-3">{{ $movie->description }}</p>
                        <div class="mt-4 flex justify-between items-center">
                           <a href="{{ route('movies.show', $movie->id) }}" class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded-full text-sm">Lihat Detail & Jadwal</a>
                            {{-- Placeholder untuk tombol detail. Nanti akan kita buat halaman detail film --}}
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
@endsection