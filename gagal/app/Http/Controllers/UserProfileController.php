<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule; // Tambahkan ini

class UserProfileController extends Controller
{
    public function show()
    {
        $user = auth()->user(); // Mengambil data user yang sedang login
        return view('profile.show', compact('user'));
    }

    public function edit()
    {
        $user = auth()->user(); // Mengambil data user yang sedang login
        return view('profile.edit', compact('user')); // Mengirim data user ke view edit
    }

    public function update(Request $request)
    {
        $user = auth()->user(); // Mengambil data user yang sedang login

        // Aturan validasi
        $request->validate([
            'username' => ['required', 'string', 'max:255', Rule::unique('users')->ignore($user->id, 'id')],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'], 
            
        ]);

        $user->username = $request->username;
        $user->email = $request->email;

        // Jika Anda ingin mengizinkan perubahan password, uncomment blok ini:
        if ($request->filled('password')) {
             $user->password = bcrypt($request->password);
         }
      

        $user->save(); // Menyimpan perubahan ke database

        // Redirect kembali ke halaman profil dengan pesan sukses
        return redirect()->route('profile.show')->with('success', 'Profil berhasil diperbarui!');
    }
}