@extends('layouts.admin')

@section('content')
    <h1 class="text-4xl font-bold text-white mb-6">Selamat Datang di Dashboard Admin!</h1>
    <p class="text-gray-300 text-lg">Ini adalah halaman dashboard untuk administrator. Di sini Anda bisa mengelola film, jadwal, pengguna, dll.</p>

    {{-- Tambahkan statistik atau ringkasan di sini nanti --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mt-8">
        <div class="bg-gray-800 p-6 rounded-lg shadow-lg">
            <h3 class="text-xl font-semibold text-red-500 mb-3">Manajemen Film</h3>
            <p class="text-gray-300">Kelola daftar film yang tersedia di bioskop Anda.</p>
            <a href="{{ route('admin.movies.index') }}" class="mt-4 inline-block bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Lihat Film</a>
        </div>
        {{-- Tambahkan card lain untuk modul lain --}}
        <div class="bg-gray-800 p-6 rounded-lg shadow-lg">
            <h3 class="text-xl font-semibold text-red-500 mb-3">Jadwal Tayang</h3>
            <p class="text-gray-300">Atur jadwal dan sesi tayang untuk film.</p>
            <a href="#" class="mt-4 inline-block bg-gray-600 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">Kelola Jadwal</a>
        </div>
        <div class="bg-gray-800 p-6 rounded-lg shadow-lg">
            <h3 class="text-xl font-semibold text-red-500 mb-3">Manajemen Pengguna</h3>
            <p class="text-gray-300">Kelola akun pengguna dan peran mereka.</p>
            <a href="#" class="mt-4 inline-block bg-gray-600 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">Kelola Pengguna</a>
        </div>
    </div>
@endsection