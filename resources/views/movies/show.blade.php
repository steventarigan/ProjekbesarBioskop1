@extends('layouts.app') {{-- Pastikan ini ada di paling atas untuk mewarisi layout --}}

@section('title', $movie->title) {{-- Mengatur judul halaman HTML --}}

@section('content') {{-- Semua konten halaman harus berada di dalam section ini --}}
    <div class="container mx-auto px-4 py-8 text-white">
        <div class="bg-gray-800 rounded-lg shadow-lg overflow-hidden p-8 flex flex-col md:flex-row items-start md:space-x-8">
            <!-- Movie Poster -->
            <div class="flex-shrink-0 w-full md:w-1/3 mb-6 md:mb-0">
                {{-- Menampilkan poster film. Jika poster_url kosong, gunakan placeholder --}}
                <img src="{{ $movie->poster_url ?: 'https://via.placeholder.com/400x600.png?text=No+Poster' }}"
                     alt="{{ $movie->title }} Poster" class="w-full h-auto rounded-lg shadow-xl object-cover">
            </div>

            <!-- Movie Details -->
            <div class="flex-1">
                <h1 class="text-5xl font-bold text-red-500 mb-4">{{ $movie->title }}</h1>
                <p class="text-gray-300 text-lg mb-2">Genre: <span class="font-semibold">{{ $movie->genre }}</span></p>
                <p class="text-gray-300 text-lg mb-2">Durasi: <span class="font-semibold">{{ $movie->duration }} menit</p>
                {{-- Memformat tanggal rilis menggunakan Carbon untuk tampilan yang lebih baik --}}
                <p class="text-gray-300 text-lg mb-4">Tanggal Rilis: <span class="font-semibold">{{ \Carbon\Carbon::parse($movie->release_date)->format('d F Y') }}</span></p>

                <h2 class="text-3xl font-semibold text-white mb-3 mt-6">Sinopsis</h2>
                <p class="text-gray-400 text-base leading-relaxed mb-6">{{ $movie->description }}</p>

                @if ($movie->trailer_url)
                    <h2 class="text-3xl font-semibold text-white mb-3">Trailer</h2>
                    <div class="relative overflow-hidden w-full rounded-lg" style="padding-top: 56.25%;">
                        {{-- Menyematkan trailer YouTube. Mengambil ID video dari URL --}}
                        <iframe class="absolute top-0 left-0 w-full h-full"
                                src="https://www.youtube.com/embed/{{ Str::afterLast($movie->trailer_url, '/') }}"
                                frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                allowfullscreen></iframe>
                    </div>
                @endif

                {{-- Bagian Jadwal Tayang --}}
                <div class="mt-8">
                    <h2 class="text-3xl font-semibold mb-4">Jadwal Tayang</h2>
                    @if ($showtimes->isEmpty())
                        <p class="text-gray-400">Belum ada jadwal tayang untuk film ini.</p>
                    @else
                        {{-- Mengelompokkan jadwal tayang berdasarkan tanggal --}}
                        @foreach ($showtimes as $date => $dailyShowtimes)
                            <h3 class="text-2xl font-semibold mt-6 mb-3">{{ \Carbon\Carbon::parse($date)->locale('id')->isoFormat('dddd, D MMMM Y') }}</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                                @foreach ($dailyShowtimes as $showtime)
                                    <div class="bg-gray-700 p-4 rounded-lg shadow-md">
                                        <p class="text-xl font-bold">{{ $showtime->start_time->format('H:i') }} - {{ $showtime->end_time->format('H:i') }}</p>
                                        <p class="text-gray-300">Studio: {{ $showtime->cinemaHall->name }}</p>
                                        <p class="text-gray-300">Harga: Rp {{ number_format($showtime->ticket_price, 0, ',', '.') }}</p>
                                        {{-- Tautan ke halaman pemilihan kursi untuk jadwal tayang ini --}}
                                        <a href="{{ route('booking.select_seats', $showtime->id) }}" class="mt-3 inline-block bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">Pesan Tiket</a>
                                    </div>
                                @endforeach
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>

        {{-- Kembali ke daftar film --}}
        <div class="mt-8 text-center">
            <a href="{{ route('movies.list') }}" class="text-red-500 hover:text-red-400 text-lg font-semibold">&larr; Kembali ke Daftar Film</a>
        </div>
    </div>
@endsection