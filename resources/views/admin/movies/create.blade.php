@extends('layouts.admin')

@section('content')
    <h1 class="text-4xl font-bold text-white mb-6">Tambah Studio/Hall Baru</h1>

    @if ($errors->any())
        <div class="bg-red-600 text-white p-3 rounded mb-4">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.cinema_halls.store') }}" method="POST" class="bg-gray-800 p-8 rounded-lg shadow-lg">
        @csrf
        <div class="mb-4">
            <label for="name" class="block text-gray-300 text-sm font-bold mb-2">Nama Studio/Hall</label>
            <input type="text" id="name" name="name" value="{{ old('name') }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-900 leading-tight focus:outline-none focus:shadow-outline" required>
        </div>
        <div class="mb-4">
            <label for="capacity" class="block text-gray-300 text-sm font-bold mb-2">Kapasitas Kursi</label>
            <input type="number" id="capacity" name="capacity" value="{{ old('capacity') }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-900 leading-tight focus:outline-none focus:shadow-outline" required min="1">
        </div>
        <div class="mb-4">
            <label for="rows" class="block text-gray-300 text-sm font-bold mb-2">Jumlah Baris Kursi (Opsional)</label>
            <input type="number" id="rows" name="rows" value="{{ old('rows') }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-900 leading-tight focus:outline-none focus:shadow-outline" min="1">
        </div>
        <div class="mb-6">
            <label for="columns" class="block text-gray-300 text-sm font-bold mb-2">Jumlah Kolom Kursi (Opsional)</label>
            <input type="number" id="columns" name="columns" value="{{ old('columns') }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-900 leading-tight focus:outline-none focus:shadow-outline" min="1">
        </div>
        <div class="flex items-center justify-between">
            <button type="submit" class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Simpan Studio/Hall</button>
            <a href="{{ route('admin.cinema_halls.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Batal</a>
        </div>
    </form>
@endsection