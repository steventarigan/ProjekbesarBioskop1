<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Bioskopku</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    {{-- Anda bisa menambahkan CSS kustom di sini jika diperlukan --}}
    <style>
        /* Optional: Mengatasi tinggi min-h-screen agar content tidak terpotong */
        .min-h-custom {
            min-height: calc(100vh - 64px); /* Asumsi navbar tinggi 64px (h-16) */
        }
    </style>
</head>
<body class="bg-gray-900 text-gray-100 flex h-screen">

    <div class="w-64 bg-gray-800 shadow-lg p-5 flex flex-col justify-between">
        <div>
            <div class="text-3xl font-bold text-red-500 mb-8 text-center">Bioskopku Admin</div>
            <nav>
                <ul>
                    <li class="mb-4">
                        <a href="{{ route('admin.dashboard') }}" class="flex items-center p-3 rounded-lg hover:bg-red-700 transition duration-200
                           {{ Request::routeIs('admin.dashboard') ? 'bg-red-600' : 'text-gray-300' }}">
                            <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001 1h3v-3m0 0h.01M12 12h.01M12 7h.01M12 17h.01"></path></svg>
                            Dashboard
                        </a>
                    </li>
                    <li class="mb-4">
                        <a href="{{ route('admin.movies.index') }}" class="flex items-center p-3 rounded-lg hover:bg-red-700 transition duration-200
                           {{ Request::routeIs('admin.movies.*') ? 'bg-red-600' : 'text-gray-300' }}">
                            <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 4v16M17 4v16M3 8h18M3 16h18M4 20h16a1 1 0 001-1V5a1 1 0 00-1-1H4a1 1 0 00-1 1v14a1 1 0 001 1z"></path></svg>
                            Manajemen Film
                        </a>
                    </li>
                    <li class="mb-4">
                    <a href="{{ route('admin.cinema_halls.index') }}" class="flex items-center p-3 rounded-lg hover:bg-red-700 transition duration-200
                    {{ Request::routeIs('admin.cinema_halls.*') ? 'bg-red-600' : 'text-gray-300' }}">
                <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h-2.586a1 1 0 01-.707-.293l-3.414-3.414a1 1 0 00-.707-.293H6a2 2 0 00-2 2v2h14zm-4-4h.01M12 4v.01M12 8v.01"></path></svg>
            Manajemen Studio/Hall
        </a>
    </li>
    <li class="mb-4">
    <a href="{{ route('admin.showtimes.index') }}" class="flex items-center p-3 rounded-lg hover:bg-red-700 transition duration-200
       {{ Request::routeIs('admin.showtimes.*') ? 'bg-red-600' : 'text-gray-300' }}">
        <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h.01M16 11h.01M9 15h.01M15 15h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
        Manajemen Jadwal Tayang
    </a>
</li>
<li class="mb-4">
    <a href="{{ route('admin.bookings.index') }}" class="flex items-center p-3 rounded-lg hover:bg-red-700 transition duration-200
       {{ Request::routeIs('admin.bookings.*') ? 'bg-red-600' : 'text-gray-300' }}">
        <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
        Manajemen Pemesanan
    </a>
</li>
                    
                    {{-- Tambahkan menu lain di sini nanti, contoh: --}}
                    {{-- <li class="mb-4">
                        <a href="#" class="flex items-center p-3 rounded-lg text-gray-300 hover:bg-red-700 transition duration-200">
                            <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h.01M16 11h.01M9 15h.01M15 15h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            Jadwal Tayang
                        </a>
                    </li>
                    <li class="mb-4">
                        <a href="#" class="flex items-center p-3 rounded-lg text-gray-300 hover:bg-red-700 transition duration-200">
                            <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h-5m-1.581-6.166a4 4 0 11-4.664-6.844 4 4 0 015.332 5.332L17 20z"></path></svg>
                            Manajemen Pengguna
                        </a>
                    </li> --}}
                </ul>
            </nav>
        </div>

        {{-- Logout di bagian bawah sidebar --}}
        <div class="mt-auto">
            <form action="{{ route('logout') }}" method="POST" class="w-full">
                @csrf
                <button type="submit" class="w-full flex items-center p-3 rounded-lg bg-red-600 hover:bg-red-700 text-white font-bold transition duration-200">
                    <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                    Logout ({{ Auth::user()->name }})
                </button>
            </form>
        </div>
    </div>

    <div class="flex-1 flex flex-col overflow-hidden">
        <header class="bg-gray-800 p-4 shadow-md flex justify-end items-center h-16">
            {{-- Ini bisa diisi dengan Breadcrumbs, Notifikasi, dll. --}}
            {{-- <div class="text-white text-lg">Halaman Admin</div> --}}
            <div class="text-lg">Selamat datang di Panel Admin!</div>
        </header>

        <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-900 p-6 min-h-custom">
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

            @yield('content')
        </main>
    </div>
</body>
</html>