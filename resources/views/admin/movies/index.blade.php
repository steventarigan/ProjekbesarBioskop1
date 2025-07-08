@extends('layouts.admin')

@section('content')
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-4xl font-bold text-white">Manajemen Studio/Hall</h1>
        <a href="{{ route('admin.cinema_halls.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Tambah Studio/Hall Baru</a>
    </div>

    @if ($halls->isEmpty())
        <p class="text-gray-400">Belum ada studio/hall yang ditambahkan.</p>
    @else
        <div class="overflow-x-auto bg-gray-800 rounded-lg shadow-lg">
            <table class="min-w-full leading-normal">
                <thead>
                    <tr>
                        <th class="px-5 py-3 border-b-2 border-gray-700 bg-gray-700 text-left text-xs font-semibold text-gray-300 uppercase tracking-wider">
                            Nama Studio
                        </th>
                        <th class="px-5 py-3 border-b-2 border-gray-700 bg-gray-700 text-left text-xs font-semibold text-gray-300 uppercase tracking-wider">
                            Kapasitas
                        </th>
                        <th class="px-5 py-3 border-b-2 border-gray-700 bg-gray-700 text-left text-xs font-semibold text-gray-300 uppercase tracking-wider">
                            Baris
                        </th>
                        <th class="px-5 py-3 border-b-2 border-gray-700 bg-gray-700 text-left text-xs font-semibold text-gray-300 uppercase tracking-wider">
                            Kolom
                        </th>
                        <th class="px-5 py-3 border-b-2 border-gray-700 bg-gray-700 text-left text-xs font-semibold text-gray-300 uppercase tracking-wider">
                            Aksi
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($halls as $hall)
                    <tr>
                        <td class="px-5 py-5 border-b border-gray-700 bg-gray-800 text-sm">
                            <p class="text-white whitespace-no-wrap">{{ $hall->name }}</p>
                        </td>
                        <td class="px-5 py-5 border-b border-gray-700 bg-gray-800 text-sm">
                            <p class="text-white whitespace-no-wrap">{{ $hall->capacity }}</p>
                        </td>
                        <td class="px-5 py-5 border-b border-gray-700 bg-gray-800 text-sm">
                            <p class="text-white whitespace-no-wrap">{{ $hall->rows ?? '-' }}</p>
                        </td>
                        <td class="px-5 py-5 border-b border-gray-700 bg-gray-800 text-sm">
                            <p class="text-white whitespace-no-wrap">{{ $hall->columns ?? '-' }}</p>
                        </td>
                        <td class="px-5 py-5 border-b border-gray-700 bg-gray-800 text-sm">
                            <a href="{{ route('admin.cinema_halls.edit', $hall->id) }}" class="text-yellow-500 hover:text-yellow-400 mr-3">Edit</a>
                            <form action="{{ route('admin.cinema_halls.destroy', $hall->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus studio/hall ini?');">
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