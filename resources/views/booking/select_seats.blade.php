@extends('layouts.app') {{-- Menggunakan layout utama untuk pengguna --}}

@section('title', 'Pilih Kursi') {{-- Mengatur judul halaman HTML --}}

@section('content')
    <div class="container mx-auto px-4 py-8 text-white">
        <h1 class="text-4xl font-bold mb-6 text-center">Pilih Kursi untuk {{ $showtime->movie->title }}</h1>
        <p class="text-gray-300 text-center mb-2">Studio: {{ $showtime->cinemaHall->name }}</p>
        <p class="text-gray-300 text-center mb-2">Tanggal: {{ $showtime->date->format('d M Y') }}</p>
        <p class="text-gray-300 text-center mb-6">Waktu: {{ $showtime->start_time->format('H:i') }} - {{ $showtime->end_time->format('H:i') }}</p>

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

        {{-- Form untuk memilih kursi dan melanjutkan pemesanan --}}
        <form action="{{ route('booking.process', $showtime->id) }}" method="POST" class="bg-gray-800 p-8 rounded-lg shadow-lg max-w-4xl mx-auto">
            @csrf

            {{-- Indikator Layar --}}
            <div class="text-center text-gray-400 mb-8">
                <p class="text-2xl font-bold">LAYAR</p>
                <div class="w-full h-2 bg-gray-700 rounded-full mx-auto mt-2"></div>
            </div>

            {{-- Grid Kursi --}}
            <div class="flex justify-center mb-6">
                <div class="grid gap-2" style="grid-template-columns: repeat({{ $columns }}, minmax(0, 1fr));">
                    @php
                        $currentSeatIndex = 0; // Untuk melacak index kursi di $allSeats
                    @endphp
                    @for ($r = 0; $r < $rows; $r++)
                        @php
                            $rowName = chr(65 + $r); // Menghasilkan nama baris (A, B, C, ...)
                        @endphp
                        @for ($c = 1; $c <= $columns; $c++)
                            {{-- Pastikan kita tidak melebihi jumlah kursi yang sebenarnya di $allSeats --}}
                            @if ($currentSeatIndex < count($allSeats))
                                @php
                                    $seatNumber = $allSeats[$currentSeatIndex]; // Ambil nomor kursi
                                    $isBooked = in_array($seatNumber, $bookedSeats); // Cek apakah kursi sudah dipesan
                                    $seatClass = $isBooked ? 'bg-gray-600 cursor-not-allowed' : 'bg-green-600 hover:bg-green-700 cursor-pointer';
                                    $inputDisabled = $isBooked ? 'disabled' : '';
                                @endphp
                                <label class="relative w-10 h-10 flex items-center justify-center rounded-md text-sm font-semibold {{ $seatClass }}">
                                    {{-- Checkbox untuk memilih kursi --}}
                                    <input type="checkbox" name="selected_seats[]" value="{{ $seatNumber }}" class="absolute opacity-0 w-full h-full peer" {{ $inputDisabled }}
                                        onchange="updateTotalPrice()"> {{-- Panggil fungsi JS saat checkbox berubah --}}
                                    {{-- Tampilan visual kursi --}}
                                    <span class="text-white peer-checked:bg-blue-600 peer-checked:border-blue-800 peer-checked:text-white w-full h-full flex items-center justify-center rounded-md border border-gray-500 transition duration-150 ease-in-out">
                                        {{ $seatNumber }}
                                    </span>
                                </label>
                                @php
                                    $currentSeatIndex++; // Lanjutkan ke kursi berikutnya
                                @endphp
                            @else
                                {{-- Jika kapasitas tidak pas dengan grid, sisanya kosong (untuk menjaga layout grid) --}}
                                <div class="w-10 h-10"></div>
                            @endif
                        @endfor
                    @endfor
                </div>
            </div>

            {{-- Legenda Kursi --}}
            <div class="flex justify-center gap-4 mb-8 text-lg">
                <div class="flex items-center">
                    <span class="w-6 h-6 bg-green-600 rounded-md mr-2"></span> Tersedia
                </div>
                <div class="flex items-center">
                    <span class="w-6 h-6 bg-gray-600 rounded-md mr-2"></span> Terisi
                </div>
                <div class="flex items-center">
                    <span class="w-6 h-6 bg-blue-600 rounded-md mr-2"></span> Dipilih
                </div>
            </div>

            {{-- Tampilan Total Harga --}}
            <div class="text-center text-2xl font-bold mb-6">
                Total Harga: Rp <span id="totalPriceDisplay">0</span>
            </div>

            {{-- Tombol Lanjutkan Pembayaran --}}
            <div class="flex justify-center">
                {{-- Tambahkan id 'proceedButton' dan atribut 'disabled' awal --}}
                <button type="submit" id="proceedButton" class="bg-red-600 hover:bg-red-700 text-white font-bold py-3 px-8 rounded-lg text-xl focus:outline-none focus:shadow-outline opacity-50 cursor-not-allowed" disabled>
                    Lanjutkan Pembayaran
                </button>
            </div>
        </form>
    </div>

    {{-- Script JavaScript untuk menghitung total harga dan mengaktifkan/menonaktifkan tombol --}}
    <script>
        const ticketPrice = {{ $showtime->ticket_price }}; // Harga tiket dari jadwal tayang
        const checkboxes = document.querySelectorAll('input[name="selected_seats[]"]'); // Semua checkbox kursi
        const totalPriceDisplay = document.getElementById('totalPriceDisplay'); // Elemen untuk menampilkan total harga
        const proceedButton = document.getElementById('proceedButton'); // Tombol Lanjutkan Pembayaran

        // Fungsi untuk memperbarui total harga dan status tombol
        function updateTotalPrice() {
            let selectedCount = 0;
            checkboxes.forEach(checkbox => {
                if (checkbox.checked) {
                    selectedCount++;
                }
            });
            const totalPrice = selectedCount * ticketPrice;
            // Format angka ke format mata uang Indonesia
            totalPriceDisplay.textContent = totalPrice.toLocaleString('id-ID');

            // Aktifkan/nonaktifkan tombol berdasarkan jumlah kursi yang dipilih
            if (selectedCount > 0) {
                proceedButton.removeAttribute('disabled');
                proceedButton.classList.remove('opacity-50', 'cursor-not-allowed');
            } else {
                proceedButton.setAttribute('disabled', 'disabled');
                proceedButton.classList.add('opacity-50', 'cursor-not-allowed');
            }
        }

        // Panggil fungsi saat halaman pertama kali dimuat untuk inisialisasi
        updateTotalPrice();
    </script>
@endsection