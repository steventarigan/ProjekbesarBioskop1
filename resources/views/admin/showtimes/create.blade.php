@extends('layouts.admin')

@section('content')
    <h1 class="text-4xl font-bold text-white mb-6">Tambah Jadwal Tayang Baru</h1>

    @if ($errors->any())
        <div class="bg-red-600 text-white p-3 rounded mb-4">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.showtimes.store') }}" method="POST" class="bg-gray-800 p-8 rounded-lg shadow-lg">
        @csrf
        <div class="mb-4">
            <label for="movie_id" class="block text-gray-300 text-sm font-bold mb-2">Film</label>
            <select id="movie_id" name="movie_id" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-900 leading-tight focus:outline-none focus:shadow-outline" required>
                <option value="">Pilih Film</option>
                @foreach ($movies as $movie)
                    <option value="{{ $movie->id }}" {{ old('movie_id') == $movie->id ? 'selected' : '' }}>{{ $movie->title }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-4">
            <label for="cinema_hall_id" class="block text-gray-300 text-sm font-bold mb-2">Studio/Hall</label>
            <select id="cinema_hall_id" name="cinema_hall_id" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-900 leading-tight focus:outline-none focus:shadow-outline" required>
                <option value="">Pilih Studio/Hall</option>
                @foreach ($cinemaHalls as $hall)
                    <option value="{{ $hall->id }}" {{ old('cinema_hall_id') == $hall->id ? 'selected' : '' }}>{{ $hall->name }} (Kapasitas: {{ $hall->capacity }})</option>
                @endforeach
            </select>
        </div>
        <div class="mb-4">
            <label for="date" class="block text-gray-300 text-sm font-bold mb-2">Tanggal Tayang</label>
            <input type="date" id="date" name="date" value="{{ old('date') }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-900 leading-tight focus:outline-none focus:shadow-outline" required>
        </div>
        <div class="mb-4">
            <label for="start_time" class="block text-gray-300 text-sm font-bold mb-2">Waktu Mulai Tayang</label>
            <input type="time" id="start_time" name="start_time" value="{{ old('start_time') }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-900 leading-tight focus:outline-none focus:shadow-outline" required>
        </div>
        <div class="mb-6">
            <label for="ticket_price" class="block text-gray-300 text-sm font-bold mb-2">Harga Tiket</label>
            <input type="number" id="ticket_price" name="ticket_price" value="{{ old('ticket_price') }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-900 leading-tight focus:outline-none focus:shadow-outline" required step="0.01" min="0">
        </div>
        <div class="flex items-center justify-between">
            <button type="submit" class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Simpan Jadwal</button>
            <a href="{{ route('admin.showtimes.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Batal</a>
        </div>
    </form>
@endsection
