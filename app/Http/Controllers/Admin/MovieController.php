<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Movie;
use Illuminate\Http\Request;

class MovieController extends Controller
{
    /**
     * Display a listing of the movies.
     */
    public function index()
    {
        $movies = Movie::all();
        return view('admin.movies.index', compact('movies'));
    }

    /**
     * Show the form for creating a new movie.
     */
    public function create()
    {
        return view('admin.movies.create');
    }

    /**
     * Store a newly created movie in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'genre' => 'required|string|max:255',
            'duration' => 'required|integer|min:1',
            'release_date' => 'required|date',
            'poster_url' => 'nullable|url',
            'trailer_url' => 'nullable|url',
        ]);

        Movie::create($request->all());

        return redirect()->route('admin.movies.index')->with('success', 'Film berhasil ditambahkan!');
    }

    /**
     * Show the form for editing the specified movie.
     */
    public function edit(Movie $movie)
    {
        return view('admin.movies.edit', compact('movie'));
    }

    /**
     * Update the specified movie in storage.
     */
    public function update(Request $request, Movie $movie)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'genre' => 'required|string|max:255',
            'duration' => 'required|integer|min:1',
            'release_date' => 'required|date',
            'poster_url' => 'nullable|url',
            'trailer_url' => 'nullable|url',
        ]);

        $movie->update($request->all());

        return redirect()->route('admin.movies.index')->with('success', 'Film berhasil diperbarui!');
    }

    /**
     * Remove the specified movie from storage.
     */
    public function destroy(Movie $movie)
    {
        $movie->delete();
        return redirect()->route('admin.movies.index')->with('success', 'Film berhasil dihapus!');
    }
}
