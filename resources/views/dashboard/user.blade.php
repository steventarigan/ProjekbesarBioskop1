<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard - Bioskopku</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-900 text-gray-100 min-h-screen">
    <nav class="bg-gray-800 p-4 shadow-md">
        <div class="container mx-auto flex justify-between items-center">
            <a href="{{ route('user.dashboard') }}" class="text-xl font-bold text-red-500">Bioskopku</a>
            <div class="flex items-center">
                <span class="mr-4">Halo, {{ Auth::user()->name }}!</span>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">Logout</button>
                </form>
            </div>
        </div>
    </nav>

    <main class="container mx-auto mt-8 p-4">
        @if (session('success'))
            <div class="bg-green-600 text-white p-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif
        <h1 class="text-4xl font-bold text-white mb-6">Selamat Datang di Dashboard Pengguna!</h1>
        <p class="text-gray-300 text-lg">Ini adalah halaman dashboard untuk pengguna biasa. Di sini Anda bisa melihat informasi film, riwayat pemesanan, dll.</p>
    </main>
</body>
</html>