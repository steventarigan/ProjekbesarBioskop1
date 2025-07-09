@extends('layouts.app') {{-- Menggunakan layout utama untuk pengguna --}}

@section('title', 'Dashboard Pengguna') {{-- Mengatur judul halaman HTML --}}

@section('content')
    <div class="container mx-auto px-4 py-8 text-white">
        <h1 class="text-4xl font-bold mb-6 text-center">Selamat Datang, {{ Auth::user()->name }}!</h1>

        {{-- Menampilkan pesan sukses atau error dari sesi --}}
        @if (session('success'))
            <div class="bg-green-600 text-white p-3 rounded mb-4 max-w-xl mx-auto">
                {{ session('success') }}
            </div>
        @endif
        @if (session('error'))
            <div class="bg-red-600 text-white p-3 rounded mb-4 max-w-xl mx-auto">
                {{ session('error') }}
            </div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mt-8">
            {{-- Card untuk Riwayat Pemesanan --}}
            <div class="bg-gray-800 p-6 rounded-lg shadow-lg flex flex-col items-center text-center">
                <svg class="w-16 h-16 text-red-500 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                <h3 class="text-2xl font-semibold text-red-500 mb-3">Riwayat Pemesanan</h3>
                <p class="text-gray-300 mb-4">Lihat semua tiket yang pernah Anda pesan.</p>
                <a href="{{ route('booking.user_bookings') }}" class="mt-auto inline-block bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded-lg text-lg">Lihat</a>
            </div>

            {{-- Card untuk Edit Profil --}}
            <div class="bg-gray-800 p-6 rounded-lg shadow-lg flex flex-col items-center text-center">
                <svg class="w-16 h-16 text-red-500 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0H9m7 6l-3 3m0 0l-3-3m3 3V9"></path></svg>
                <h3 class="text-2xl font-semibold text-red-500 mb-3">Edit Profil</h3>
                <p class="text-gray-300 mb-4">Perbarui informasi akun Anda.</p>
                <a href="{{ route('user.profile.edit') }}" class="mt-auto inline-block bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded-lg text-lg">Edit</a>
            </div>

            {{-- Card untuk Menjelajahi Film --}}
            <div class="bg-gray-800 p-6 rounded-lg shadow-lg flex flex-col items-center text-center">
                <svg class="w-16 h-16 text-red-500 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg>
                <h3 class="text-2xl font-semibold text-red-500 mb-3">Jelajahi Film</h3>
                <p class="text-gray-300 mb-4">Temukan film terbaru dan jadwal tayangnya.</p>
                <a href="{{ route('movies.list') }}" class="mt-auto inline-block bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded-lg text-lg">Jelajahi</a>
            </div>
        </div>
    </div>
@endsection