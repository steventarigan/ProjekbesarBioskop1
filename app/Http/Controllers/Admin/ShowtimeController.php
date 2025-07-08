<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Showtime;
use App\Models\Movie; // Import Movie Model
use App\Models\CinemaHall; // Import CinemaHall Model
use Illuminate\Http\Request;
use Carbon\Carbon; // Untuk perhitungan waktu

class ShowtimeController extends Controller
{
    /**
     * Display a listing of the showtimes.
     */
    public function index()
    {
        $showtimes = Showtime::with(['movie', 'cinemaHall'])->orderBy('date', 'desc')->orderBy('start_time', 'asc')->get();
        return view('admin.showtimes.index', compact('showtimes'));
    }

    /**
     * Show the form for creating a new showtime.
     */
    public function create()
    {
        $movies = Movie::orderBy('title')->get();
        $cinemaHalls = CinemaHall::orderBy('name')->get();
        return view('admin.showtimes.create', compact('movies', 'cinemaHalls'));
    }

    /**
     * Store a newly created showtime in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'movie_id' => 'required|exists:movies,id',
            'cinema_hall_id' => 'required|exists:cinema_halls,id',
            'date' => 'required|date|after_or_equal:today',
            'start_time' => 'required|date_format:H:i',
            'ticket_price' => 'required|numeric|min:0',
        ]);

        // Hitung end_time berdasarkan durasi film
        $movie = Movie::find($validatedData['movie_id']);
        $startDateTime = Carbon::parse($validatedData['date'] . ' ' . $validatedData['start_time']);
        $endDateTime = $startDateTime->addMinutes($movie->duration);

        // Tambahkan end_time ke validatedData
        $validatedData['end_time'] = $endDateTime->format('H:i');

        // Validasi bentrok jadwal di hall yang sama
        $existingShowtimes = Showtime::where('cinema_hall_id', $validatedData['cinema_hall_id'])
                                    ->where('date', $validatedData['date'])
                                    ->where(function ($query) use ($startDateTime, $endDateTime) {
                                        $query->where(function ($q) use ($startDateTime, $endDateTime) {
                                            $q->where('start_time', '<', $endDateTime->format('H:i'))
                                            ->where('end_time', '>', $startDateTime->format('H:i'));
                                        });
                                    })
                                    ->count();

        if ($existingShowtimes > 0) {
            return back()->withInput()->withErrors(['start_time' => 'Jadwal tayang ini bentrok dengan jadwal lain di studio yang sama pada tanggal tersebut.']);
        }


        Showtime::create($validatedData);

        return redirect()->route('admin.showtimes.index')->with('success', 'Jadwal tayang berhasil ditambahkan!');
    }

    /**
     * Show the form for editing the specified showtime.
     */
    public function edit(Showtime $showtime) // Route Model Binding
    {
        $movies = Movie::orderBy('title')->get();
        $cinemaHalls = CinemaHall::orderBy('name')->get();
        return view('admin.showtimes.edit', compact('showtime', 'movies', 'cinemaHalls'));
    }

    /**
     * Update the specified showtime in storage.
     */
    public function update(Request $request, Showtime $showtime) // Route Model Binding
    {
        $validatedData = $request->validate([
            'movie_id' => 'required|exists:movies,id',
            'cinema_hall_id' => 'required|exists:cinema_halls,id',
            'date' => 'required|date|after_or_equal:today', // Bisa diubah validasinya agar bisa mengedit jadwal di masa lalu juga
            'start_time' => 'required|date_format:H:i',
            'ticket_price' => 'required|numeric|min:0',
        ]);

        // Hitung end_time berdasarkan durasi film
        $movie = Movie::find($validatedData['movie_id']);
        $startDateTime = Carbon::parse($validatedData['date'] . ' ' . $validatedData['start_time']);
        $endDateTime = $startDateTime->addMinutes($movie->duration);

        // Tambahkan end_time ke validatedData
        $validatedData['end_time'] = $endDateTime->format('H:i');

        // Validasi bentrok jadwal di hall yang sama (kecuali jadwal yang sedang diedit)
        $existingShowtimes = Showtime::where('cinema_hall_id', $validatedData['cinema_hall_id'])
                                    ->where('date', $validatedData['date'])
                                    ->where('id', '!=', $showtime->id) // Abaikan jadwal yang sedang diedit
                                    ->where(function ($query) use ($startDateTime, $endDateTime) {
                                        $query->where(function ($q) use ($startDateTime, $endDateTime) {
                                            $q->where('start_time', '<', $endDateTime->format('H:i'))
                                            ->where('end_time', '>', $startDateTime->format('H:i'));
                                        });
                                    })
                                    ->count();

        if ($existingShowtimes > 0) {
            return back()->withInput()->withErrors(['start_time' => 'Jadwal tayang ini bentrok dengan jadwal lain di studio yang sama pada tanggal tersebut.']);
        }

        $showtime->update($validatedData);

        return redirect()->route('admin.showtimes.index')->with('success', 'Jadwal tayang berhasil diperbarui!');
    }

    /**
     * Remove the specified showtime from storage.
     */
    public function destroy(Showtime $showtime) // Route Model Binding
    {
        $showtime->delete();
        return redirect()->route('admin.showtimes.index')->with('success', 'Jadwal tayang berhasil dihapus!');
    }
}
