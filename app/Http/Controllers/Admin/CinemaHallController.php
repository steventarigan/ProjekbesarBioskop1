<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CinemaHall;
use Illuminate\Http\Request;

class CinemaHallController extends Controller
{
    /**
     * Display a listing of the cinema halls.
     */
    public function index()
    {
        $halls = CinemaHall::all();
        return view('admin.cinema_halls.index', compact('halls'));
    }

    /**
     * Show the form for creating a new cinema hall.
     */
    public function create()
    {
        return view('admin.cinema_halls.create');
    }

    /**
     * Store a newly created cinema hall in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:cinema_halls',
            'capacity' => 'required|integer|min:1',
            'rows' => 'nullable|integer|min:1',
            'columns' => 'nullable|integer|min:1',
        ]);

        CinemaHall::create($request->all());

        return redirect()->route('admin.cinema_halls.index')->with('success', 'Studio/Hall berhasil ditambahkan!');
    }

    /**
     * Show the form for editing the specified cinema hall.
     */
    public function edit(CinemaHall $hall) // Route Model Binding
    {
        return view('admin.cinema_halls.edit', compact('hall'));
    }

    /**
     * Update the specified cinema hall in storage.
     */
    public function update(Request $request, CinemaHall $hall) // Route Model Binding
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:cinema_halls,name,' . $hall->id, // Unique kecuali diri sendiri
            'capacity' => 'required|integer|min:1',
            'rows' => 'nullable|integer|min:1',
            'columns' => 'nullable|integer|min:1',
        ]);

        $hall->update($request->all());

        return redirect()->route('admin.cinema_halls.index')->with('success', 'Studio/Hall berhasil diperbarui!');
    }

    /**
     * Remove the specified cinema hall from storage.
     */
    public function destroy(CinemaHall $hall) // Route Model Binding
    {
        $hall->delete();
        return redirect()->route('admin.cinema_halls.index')->with('success', 'Studio/Hall berhasil dihapus!');
    }
}
