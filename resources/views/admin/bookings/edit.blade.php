@extends('layouts.admin')

@section('content')
    <h1 class="text-4xl font-bold text-white mb-6">Edit Status Pemesanan #{{ $booking->id }}</h1>

    @if ($errors->any())
        <div class="bg-red-600 text-white p-3 rounded mb-4">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.bookings.update', $booking->id) }}" method="POST" class="bg-gray-800 p-8 rounded-lg shadow-lg max-w-xl mx-auto">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label for="status" class="block text-gray-300 text-sm font-bold mb-2">Status Pemesanan</label>
            <select id="status" name="status" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-900 leading-tight focus:outline-none focus:shadow-outline" required>
                <option value="pending" {{ old('status', $booking->status) == 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="confirmed" {{ old('status', $booking->status) == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                <option value="cancelled" {{ old('status', $booking->status) == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
            </select>
        </div>

        <div class="mb-6">
            <label for="payment_status" class="block text-gray-300 text-sm font-bold mb-2">Status Pembayaran</label>
            <select id="payment_status" name="payment_status" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-900 leading-tight focus:outline-none focus:shadow-outline" required>
                <option value="pending" {{ old('payment_status', $booking->payment_status) == 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="paid" {{ old('payment_status', $booking->payment_status) == 'paid' ? 'selected' : '' }}>Paid</option>
                <option value="failed" {{ old('payment_status', $booking->payment_status) == 'failed' ? 'selected' : '' }}>Failed</option>
            </select>
        </div>

        <div class="flex items-center justify-between">
            <button type="submit" class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Perbarui Status</button>
            <a href="{{ route('admin.bookings.show', $booking->id) }}" class="bg-gray-600 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Batal</a>
        </div>
    </form>
@endsection
