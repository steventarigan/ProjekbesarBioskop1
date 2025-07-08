<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule; // Pastikan ini diimpor

class UserProfileController extends Controller
{
    /**
     * Menampilkan formulir untuk mengedit profil pengguna.
     */
    public function edit()
    {
        $user = Auth::user(); // Mengambil data pengguna yang sedang login
        return view('user.profile.edit', compact('user')); // Mengarahkan ke view 'resources/views/user/profile/edit.blade.php'
    }

    /**
     * Memperbarui profil pengguna di penyimpanan.
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users')->ignore($user->id), // Email harus unik, kecuali email pengguna sendiri
            ],
            'password' => 'nullable|string|min:8|confirmed', // Kata sandi opsional, hanya jika ingin diubah
        ]);

        $user->name = $request->name;
        $user->email = $request->email;

        if ($request->filled('password')) { // Jika kolom password diisi
            $user->password = bcrypt($request->password); // Hash kata sandi baru sebelum menyimpan
        }

        $user->save(); // Menyimpan perubahan pada pengguna

        return redirect()->route('user.profile.edit')->with('success', 'Profil berhasil diperbarui!');
    }
}
