<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    /**
     * Constructor untuk middleware.
     * Hanya terapkan middleware `auth` untuk metode logout.
     */
    public function __construct()
    {
        $this->middleware('auth')->only('logout');
        $this->middleware('guest')->except('logout');
    }

    /**
     * Login page.
     */
    public function login()
    {
        // Redirect ke dashboard jika sudah login
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }

        return view('auth.login'); // Tampilkan form login
    }

    /**
     * Proses login.
     */
    public function authenticate(Request $request)
    {
        $credentials = $request->only('username', 'password');

        // Validasi login
        if (Auth::attempt($credentials)) {
            info('Login');
            $request->session()->regenerate();
            info(auth()->user());
            return redirect()->intended('dashboard');
        }

        return back()->withErrors([
            'username' => 'The provided credentials do not match our records.',
        ]);
    }

    /**
     * Halaman registrasi.
     */
    public function register()
    {
        return view('auth.regist'); // Tampilkan form registrasi
    }

    /**
     * Proses registrasi pengguna baru.
     */
    public function store(Request $request)
    {
        // Validasi data yang diterima dari form
        $validatedData = $request->validate([
            'username' => 'required|string|max:255|unique:users',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // Simpan pengguna baru ke database
        $user = User::create([
            'username' => $validatedData['username'], // Pastikan username disertakan
            'email' => $validatedData['email'],
            'password' => bcrypt($validatedData['password']),
        ]);

        // Redirect ke halaman login dengan pesan sukses
        return redirect()->route('login')->with('success', 'Registration successful! Please log in.');
    }

    /**
     * Proses logout.
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'You have been logged out.');
    }
}