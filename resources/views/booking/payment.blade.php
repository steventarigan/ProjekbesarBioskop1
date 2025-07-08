@extends('layouts.app')

@section('title', 'Pembayaran Tiket')

@section('content')
    <div class="container mx-auto px-4 py-8 text-white">
        <h1 class="text-4xl font-bold mb-6 text-center">Pembayaran Pemesanan #{{ $booking->id }}</h1>

        @if (session('success'))
            <div class="bg-green-600 text-white p-3 rounded mb-4 max-w-xl mx-auto">
                {{ session('success') }}
            </div>
        @endif
        @if ($errors->any())
            <div class="bg-red-600 text-white p-3 rounded mb-4 max-w-xl mx-auto">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="bg-gray-800 p-8 rounded-lg shadow-lg max-w-2xl mx-auto">
            <h2 class="text-2xl font-semibold mb-4 text-red-500">Detail Pemesanan</h2>
            <p class="mb-2"><strong class="text-gray-300">Film:</strong> <span class="text-white">{{ $booking->showtime->movie->title }}</span></p>
            <p class="mb-2"><strong class="text-gray-300">Studio:</strong> <span class="text-white">{{ $booking->showtime->cinemaHall->name }}</span></p>
            <p class="mb-2"><strong class="text-gray-300">Tanggal & Waktu:</strong> <span class="text-white">{{ $booking->showtime->date->format('d M Y') }} - {{ $booking->showtime->start_time->format('H:i') }}</span></p>
            <p class="mb-2"><strong class="text-gray-300">Jumlah Tiket:</strong> <span class="text-white">{{ $booking->number_of_tickets }}</span></p>
            <p class="mb-4"><strong class="text-gray-300">Kursi:</strong>
                @foreach ($booking->bookedSeats as $seat)
                    <span class="inline-block bg-gray-700 text-white px-2 py-1 rounded-md text-sm mr-1 mb-1">{{ $seat->seat_number }}</span>
                @endforeach
            </p>
            <p class="text-3xl font-bold text-center text-green-400 mt-6">Total yang Harus Dibayar: Rp {{ number_format($booking->total_price, 0, ',', '.') }}</p>

            <form action="{{ route('booking.process_payment', $booking->id) }}" method="POST" class="mt-8">
                @csrf

                <div class="mb-6">
                    <label for="payment_method" class="block text-gray-300 text-sm font-bold mb-2">Pilih Metode Pembayaran</label>
                    <select id="payment_method" name="payment_method" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-900 leading-tight focus:outline-none focus:shadow-outline" required onchange="togglePaymentFields()">
                        <option value="">Pilih Metode</option>
                        <option value="credit_card" {{ old('payment_method') == 'credit_card' ? 'selected' : '' }}>Kartu Kredit/Debit</option>
                        <option value="bank_transfer" {{ old('payment_method') == 'bank_transfer' ? 'selected' : '' }}>Transfer Bank</option>
                        <option value="e_wallet" {{ old('payment_method') == 'e_wallet' ? 'selected' : '' }}>E-Wallet</option>
                    </select>
                </div>

                {{-- Fields for Credit Card --}}
                <div id="creditCardFields" class="hidden">
                    <h3 class="text-xl font-semibold text-white mb-4">Detail Kartu Kredit</h3>
                    <div class="mb-4">
                        <label for="card_number" class="block text-gray-300 text-sm font-bold mb-2">Nomor Kartu</label>
                        <input type="text" id="card_number" name="card_number" value="{{ old('card_number') }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-900 leading-tight focus:outline-none focus:shadow-outline" placeholder="XXXX XXXX XXXX XXXX">
                    </div>
                    <div class="grid grid-cols-2 gap-4 mb-6">
                        <div>
                            <label for="expiry_date" class="block text-gray-300 text-sm font-bold mb-2">Tanggal Kadaluarsa (MM/YY)</label>
                            <input type="text" id="expiry_date" name="expiry_date" value="{{ old('expiry_date') }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-900 leading-tight focus:outline-none focus:shadow-outline" placeholder="MM/YY">
                        </div>
                        <div>
                            <label for="cvv" class="block text-gray-300 text-sm font-bold mb-2">CVV</label>
                            <input type="text" id="cvv" name="cvv" value="{{ old('cvv') }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-900 leading-tight focus:outline-none focus:shadow-outline" placeholder="XXX">
                        </div>
                    </div>
                </div>

                {{-- Placeholder for Bank Transfer / E-Wallet instructions --}}
                <div id="bankTransferInfo" class="hidden bg-gray-700 p-4 rounded-lg mb-6">
                    <h3 class="text-xl font-semibold text-white mb-3">Instruksi Transfer Bank</h3>
                    <p class="text-gray-300">Silakan transfer ke rekening berikut:</p>
                    <p class="text-white font-bold">Bank ABC: 1234-5678-9012 (a.n. Bioskopku)</p>
                    <p class="text-gray-300 mt-2">Pemesanan akan dikonfirmasi setelah pembayaran diverifikasi.</p>
                </div>

                <div id="eWalletInfo" class="hidden bg-gray-700 p-4 rounded-lg mb-6">
                    <h3 class="text-xl font-semibold text-white mb-3">Instruksi Pembayaran E-Wallet</h3>
                    <p class="text-gray-300">Scan QR Code ini atau bayar ke nomor:</p>
                    <p class="text-white font-bold">0812-3456-7890 (Dana/OVO/Gopay)</p>
                    <p class="text-gray-300 mt-2">Pemesanan akan dikonfirmasi setelah pembayaran diverifikasi.</p>
                </div>


                <div class="flex justify-center mt-8">
                    <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-bold py-3 px-8 rounded-lg text-xl focus:outline-none focus:shadow-outline">
                        Bayar Sekarang
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function togglePaymentFields() {
            const method = document.getElementById('payment_method').value;
            const creditCardFields = document.getElementById('creditCardFields');
            const bankTransferInfo = document.getElementById('bankTransferInfo');
            const eWalletInfo = document.getElementById('eWalletInfo');

            // Hide all
            creditCardFields.classList.add('hidden');
            bankTransferInfo.classList.add('hidden');
            eWalletInfo.classList.add('hidden');

            // Show relevant fields
            if (method === 'credit_card') {
                creditCardFields.classList.remove('hidden');
            } else if (method === 'bank_transfer') {
                bankTransferInfo.classList.remove('hidden');
            } else if (method === 'e_wallet') {
                eWalletInfo.classList.remove('hidden');
            }
        }

        // Call on page load to set initial state based on old input
        document.addEventListener('DOMContentLoaded', togglePaymentFields);
    </script>
@endsection