@extends('layouts.admin') {{-- Pastikan ini ada di paling atas untuk mewarisi layout admin --}}

@section('content') {{-- Semua konten halaman harus berada di dalam section ini --}}
    <h1 class="text-4xl font-bold text-white mb-6">Selamat Datang di Dashboard Admin!</h1>
    <p class="text-gray-300 text-lg">Ini adalah halaman dashboard untuk administrator. Di sini Anda bisa mengelola film, jadwal, pengguna, dll.</p>

    {{-- Tambahkan statistik atau ringkasan di sini nanti --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mt-8">
        <div class="bg-gray-800 p-6 rounded-lg shadow-lg">
            <h3 class="text-xl font-semibold text-red-500 mb-3">Manajemen Film</h3>
            <p class="text-gray-300">Kelola daftar film yang tersedia di bioskop Anda.</p>
            <a href="{{ route('admin.movies.index') }}" class="mt-4 inline-block bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Lihat Film</a>
        </div>
        <div class="bg-gray-800 p-6 rounded-lg shadow-lg">
            <h3 class="text-xl font-semibold text-red-500 mb-3">Manajemen Studio/Hall</h3>
            <p class="text-gray-300">Atur studio atau hall bioskop dan kapasitasnya.</p>
            <a href="{{ route('admin.cinema_halls.index') }}" class="mt-4 inline-block bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Kelola Studio</a>
        </div>
        <div class="bg-gray-800 p-6 rounded-lg shadow-lg">
            <h3 class="text-xl font-semibold text-red-500 mb-3">Manajemen Jadwal Tayang</h3>
            <p class="text-gray-300">Atur jadwal dan sesi tayang untuk film.</p>
            <a href="{{ route('admin.showtimes.index') }}" class="mt-4 inline-block bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Kelola Jadwal</a>
        </div>
        <div class="bg-gray-800 p-6 rounded-lg shadow-lg">
            <h3 class="text-xl font-semibold text-red-500 mb-3">Manajemen Pemesanan</h3>
            <p class="text-gray-300">Lihat dan kelola semua pemesanan tiket.</p>
            <a href="{{ route('admin.bookings.index') }}" class="mt-4 inline-block bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Kelola Pemesanan</a>
        </div>
        {{-- Tambahkan card lain untuk modul lain jika diperlukan --}}
    </div>
@endsection
