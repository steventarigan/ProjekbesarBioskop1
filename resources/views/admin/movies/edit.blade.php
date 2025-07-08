@extends('layouts.admin')

@section('content')
    <h1 class="text-4xl font-bold text-white mb-6">Edit Studio/Hall: {{ $hall->name }}</h1>

    @if ($errors->any())
        <div class="bg-red-600 text-white p-3 rounded mb-4">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.cinema_halls.update', $hall->id) }}" method="POST" class="bg-gray-800 p-8 rounded-lg shadow-lg">
        @csrf
        @method('PUT')
        <div class="mb-4">