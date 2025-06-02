<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;        // Diperlukan untuk Str::random()
use Illuminate\Support\Facades\Mail; // Diperlukan untuk Mail::to()->send()
use App\Models\User;              // Diperlukan untuk User::where()
use App\Mail\VerifyNewEmail;      // Diperlukan untuk Mailable VerifyNewEmail

class UserProfileController extends Controller
{
    /**
     * Menampilkan halaman profil pengguna yang sedang login.
     *
     * @return \Illuminate\View\View
     */
    public function show()
    {
        $user = auth()->user(); // Mengambil data user yang sedang login
        return view('profile.show', compact('user'));
    }

    /**
     * Menampilkan form untuk mengedit profil pengguna yang sedang login.
     *
     * @return \Illuminate\View\View
     */
    public function edit()
    {
        $user = auth()->user(); // Mengambil data user yang sedang login
        return view('profile.edit', compact('user')); // Mengirim data user ke view edit
    }

    /**
     * Memperbarui data profil pengguna yang sedang login.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request)
    {
        $user = auth()->user(); // Mengambil data user yang sedang login

        // Aturan validasi
        $request->validate([
            'username' => ['required', 'string', 'max:255', Rule::unique('users')->ignore($user->id, 'id')],
            // Email baru harus valid dan unik, tapi kita akan tangani perubahannya secara terpisah
            'email' => ['required', 'string', 'email', 'max:255'], // Hapus Rule::unique() di sini, akan ditangani manual
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
            // Jika Anda punya kolom address dan phone_number di form dan database
            'address' => ['nullable', 'string', 'max:255'],
            'phone_number' => ['nullable', 'string', 'max:255'],
        ]);

        $oldEmail = $user->email;
        $newEmail = $request->email;
        $usernameChanged = false;
        $passwordChanged = false;
        $otherFieldsChanged = false;
        $emailChangeRequested = false;

        // --- Logika Perubahan Email dengan Verifikasi ---
        if ($newEmail !== $oldEmail) {
            // Jika email diubah, validasi keunikan email baru
            if (User::where('email', $newEmail)->exists()) {
                return back()->withErrors(['email' => 'Alamat email ini sudah digunakan oleh akun lain.']);
            }

            // Jika email baru sama dengan pending_email yang sudah ada, tidak perlu kirim ulang
            if ($user->pending_email === $newEmail) {
                // Tidak ada perubahan, atau perubahan email yang sama sedang menunggu verifikasi
                // Lanjutkan dengan update field lain tanpa mengirim email baru
                $emailChangeRequested = true; // Tetap set true agar pesan sukses email muncul
            } else {
                // Email benar-benar baru atau berbeda dari pending_email sebelumnya
                $user->pending_email = $newEmail;
                $user->email_change_token = Str::random(60);
                $user->email_change_token_expires_at = now()->addMinutes(60); // Token berlaku 60 menit

                try {
                    Mail::to($newEmail)->send(new VerifyNewEmail($user, $user->email_change_token));
                    $emailChangeRequested = true;
                } catch (\Exception $e) {
                    // Tangani jika pengiriman email gagal (misalnya konfigurasi email salah)
                    // Log error atau kembalikan pesan error ke pengguna
                    \Log::error('Gagal mengirim email verifikasi perubahan email: ' . $e->getMessage());
                    return back()->withInput()->withErrors(['email' => 'Gagal mengirim email verifikasi. Silakan coba lagi nanti.']);
                }
            }
        }

        // --- Update Field Lainnya (Username, Password, Address, Phone Number) ---
        if ($user->username !== $request->username) {
            $user->username = $request->username;
            $usernameChanged = true;
        }

        if ($request->filled('password')) {
            $user->password = bcrypt($request->password);
            $passwordChanged = true;
        }

        // Update address dan phone_number jika ada di form
        if ($request->has('address') && $user->address !== $request->address) {
            $user->address = $request->address;
            $otherFieldsChanged = true;
        }
        if ($request->has('phone_number') && $user->phone_number !== $request->phone_number) {
            $user->phone_number = $request->phone_number;
            $otherFieldsChanged = true;
        }

        $user->save(); // Menyimpan semua perubahan (termasuk pending_email jika ada)

        // --- Pesan Sukses Berdasarkan Perubahan ---
        $successMessage = 'Profil berhasil diperbarui!';
        if ($emailChangeRequested) {
            $successMessage = 'Perubahan email Anda akan diverifikasi. Silakan cek inbox ' . $newEmail . ' untuk link verifikasi.';
        } elseif ($usernameChanged || $passwordChanged || $otherFieldsChanged) {
            $successMessage = 'Profil berhasil diperbarui!';
        } else {
            $successMessage = 'Tidak ada perubahan yang disimpan.'; // Jika tidak ada yang berubah
        }

        return redirect()->route('profile.show')->with('success', $successMessage);
    }

    /**
     * Memproses verifikasi perubahan email.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $token
     * @return \Illuminate\Http\RedirectResponse
     */
    public function verifyEmailChange(Request $request, $token)
    {
        $user = User::where('email_change_token', $token)
                    ->where('email_change_token_expires_at', '>', now())
                    ->first();

        if (!$user) {
            return redirect('/')->withErrors(['email' => 'Token verifikasi email tidak valid atau sudah kadaluwarsa.']);
        }

        // Perbarui email utama
        $user->email = $user->pending_email;
        $user->pending_email = null;
        $user->email_change_token = null;
        $user->email_change_token_expires_at = null;
        $user->save();

        // Login ulang pengguna dengan email baru (opsional, tapi bagus untuk UX)
        auth()->login($user);

        return redirect()->route('profile.show')->with('success', 'Alamat email Anda berhasil diperbarui!');
    }
}