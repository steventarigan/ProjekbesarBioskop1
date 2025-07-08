<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bioskopku - @yield('title', 'Film Terbaik di Sini!')</title>
    {{-- PASTIKAN LINK CDN TAILWIND CSS INI ADA DAN BENAR --}}
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    {{-- Anda bisa menambahkan CSS kustom di sini jika diperlukan --}}
</head>
<body class="bg-gray-900 text-gray-100 min-h-screen flex flex-col">

    <!-- Navbar -->
    <header class="bg-gray-800 p-4 shadow-md">
        <div class="container mx-auto flex justify-between items-center">
            <a href="{{ url('/') }}" class="text-3xl font-bold text-red-500">Bioskopku</a>
            <nav>
                <ul class="flex space-x-6">
                    <li><a href="{{ route('home') }}" class="text-gray-300 hover:text-red-500 transition duration-200">Beranda</a></li>
                    <li><a href="{{ route('movies.list') }}" class="text-gray-300 hover:text-red-500 transition duration-200">Film</a></li>
                    {{-- Tambahkan menu lain seperti "Tentang Kami", "Kontak" jika ada --}}

                    @guest
                        <li><a href="{{ route('login') }}" class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded transition duration-200">Login</a></li>
                        <li><a href="{{ route('register') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded transition duration-200">Daftar</a></li>
                    @else
                        <li>
                            <a href="{{ Auth::user()->role === 'admin' ? route('admin.dashboard') : route('user.dashboard') }}"
                               class="text-gray-300 hover:text-red-500 transition duration-200">
                                Dashboard
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('user.profile.edit') }}" class="text-gray-300 hover:text-red-500 transition duration-200">
                                Profil
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('booking.user_bookings') }}" class="text-gray-300 hover:text-red-500 transition duration-200">
                                Riwayat Pemesanan
                            </a>
                        </li>
                        <li>
                            <form action="{{ route('logout') }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded transition duration-200">Logout</button>
                            </form>
                        </li>
                    @endguest
                </ul>
            </nav>
        </div>
    </header>

    <!-- Main Content Area -->
    <main class="flex-1 container mx-auto mt-8 p-4">
        {{-- Pesan sukses atau error akan ditampilkan di sini --}}
        @if (session('success'))
            <div class="bg-green-600 text-white p-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif
        @if (session('error'))
            <div class="bg-red-600 text-white p-3 rounded mb-4">
                {{ session('error') }}
            </div>
        @endif

        @yield('content') {{-- Konten spesifik halaman akan dimasukkan di sini --}}
    </main>

    <!-- Footer (Opsional) -->
    <footer class="bg-gray-800 text-gray-400 p-6 mt-12 text-center">
        <div class="container mx-auto">
            &copy; {{ date('Y') }} Bioskopku. All rights reserved.
        </div>
    </footer>
</body>
</html>