@extends('layouts.app') {{-- Menggunakan layout utama untuk pengguna --}}

@section('title', 'Edit Profil') {{-- Mengatur judul halaman HTML --}}

@section('content') {{-- Semua konten halaman harus berada di dalam section ini --}}
    <div class="container mx-auto px-4 py-8 text-white">
        <h1 class="text-4xl font-bold mb-6 text-center">Edit Profil Anda</h1>

        {{-- Menampilkan pesan sukses dari sesi --}}
        @if (session('success'))
            <div class="bg-green-600 text-white p-3 rounded mb-4 max-w-xl mx-auto">
                {{ session('success') }}
            </div>
        @endif
        {{-- Menampilkan pesan error validasi jika ada --}}
        @if ($errors->any())
            <div class="bg-red-600 text-white p-3 rounded mb-4 max-w-xl mx-auto">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Formulir untuk memperbarui profil --}}
        <form action="{{ route('user.profile.update') }}" method="POST" class="bg-gray-800 p-8 rounded-lg shadow-lg max-w-xl mx-auto">
            @csrf
            @method('PUT') {{-- Menggunakan metode PUT untuk operasi update --}}

            <div class="mb-4">
                <label for="name" class="block text-gray-300 text-sm font-bold mb-2">Nama Lengkap</label>
                <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-900 leading-tight focus:outline-none focus:shadow-outline" required>
            </div>
            <div class="mb-4">
                <label for="email" class="block text-gray-300 text-sm font-bold mb-2">Email</label>
                <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-900 leading-tight focus:outline-none focus:shadow-outline" required>
            </div>
            <div class="mb-4">
                <label for="password" class="block text-gray-300 text-sm font-bold mb-2">Password Baru (kosongkan jika tidak ingin mengubah)</label>
                <input type="password" id="password" name="password" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-900 leading-tight focus:outline-none focus:shadow-outline">
            </div>
            <div class="mb-6">
                <label for="password_confirmation" class="block text-gray-300 text-sm font-bold mb-2">Konfirmasi Password Baru</label>
                <input type="password" id="password_confirmation" name="password_confirmation" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-900 leading-tight focus:outline-none focus:shadow-outline">
            </div>
            <div class="flex items-center justify-between">
                <button type="submit" class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Perbarui Profil</button>
                <a href="{{ route('user.dashboard') }}" class="bg-gray-600 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Batal</a>
            </div>
        </form>
    </div>
@endsection