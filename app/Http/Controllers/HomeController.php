<?php

namespace App\Http\Controllers;

use App\Models\Movie; // Pastikan ini diimpor
use App\Models\Showtime; // Pastikan ini diimpor
use Illuminate\Http\Request; // Pastikan ini diimpor untuk mengakses request
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon; // Pastikan ini diimpor

class HomeController extends Controller
{
    /**
     * Menampilkan dashboard pengguna biasa.
     * Pengguna yang login dengan role 'user' akan diarahkan ke sini.
     */
    public function userDashboard()
    {
        // Di masa mendatang, Anda bisa mengambil data spesifik untuk dashboard user di sini,
        // seperti riwayat pemesanan terbaru, rekomendasi film, dll.
        // Untuk saat ini, kita hanya akan menampilkan view dashboard pengguna.
        return view('user.dashboard'); // Mengarahkan ke view 'resources/views/user/dashboard.blade.php'
    }

    /**
     * Menampilkan dashboard admin.
     * Pengguna yang login dengan role 'admin' akan diarahkan ke sini.
     */
    public function adminDashboard()
    {
        return view('admin.dashboard'); // Mengarahkan ke view 'resources/views/admin/dashboard.blade.php'
    }

    /**
     * Menampilkan daftar semua film yang tersedia untuk publik,
     * dengan opsi pencarian dan filter.
     */
    public function movieList(Request $request) // Menerima objek Request
    {
        $query = Movie::query(); // Memulai builder query untuk model Movie

        // Fitur Pencarian berdasarkan Judul Film
        if ($request->has('search') && $request->input('search') != '') {
            $search = $request->input('search');
            $query->where('title', 'like', '%' . $search . '%');
        }

        // Fitur Filter berdasarkan Genre
        if ($request->has('genre') && $request->input('genre') != '') {
            $genre = $request->input('genre');
            $query->where('genre', $genre);
        }

        // Urutkan film berdasarkan tanggal rilis terbaru
        $movies = $query->orderBy('release_date', 'desc')->get();

        // Ambil semua genre unik dari database untuk filter dropdown
        $genres = Movie::select('genre')->distinct()->pluck('genre');

        // Mengarahkan ke view 'resources/views/movies/index.blade.php'
        // Mengirimkan data film dan daftar genre ke view
        return view('movies.index', compact('movies', 'genres'));
    }

    /**
     * Menampilkan detail untuk film tertentu, termasuk jadwal tayang yang akan datang.
     * Menggunakan Route Model Binding untuk secara otomatis mengambil objek Movie.
     */
    public function showMovieDetail(Movie $movie)
    {
        // Mengambil jadwal tayang yang akan datang (dari hari ini dan seterusnya) untuk film ini
        // Mengelompokkan berdasarkan tanggal dan mengurutkan berdasarkan tanggal dan waktu mulai
        $showtimes = Showtime::where('movie_id', $movie->id)
                            ->where('date', '>=', Carbon::today()) // Hanya jadwal tayang mulai hari ini dan seterusnya
                            ->with('cinemaHall') // Eager load informasi studio/hall terkait
                            ->orderBy('date')
                            ->orderBy('start_time')
                            ->get()
                            ->groupBy(function($date) {
                                // Mengelompokkan hasil berdasarkan tanggal dalam format 'YYYY-MM-DD'
                                return Carbon::parse($date->date)->format('Y-m-d');
                            });

        return view('movies.show', compact('movie', 'showtimes')); // Mengarahkan ke view 'resources/views/movies/show.blade.php'
    }
}
