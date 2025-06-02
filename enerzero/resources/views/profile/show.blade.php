@extends('layouts.app') {{-- Pastikan ini mengarah ke layout utama Anda --}}

@section('content')
{{-- Menggunakan gradien sebagai background untuk kesan yang lebih estetik dan menyatu --}}
{{-- Tambahan: Overlay pattern SVG yang sangat subtil untuk menghilangkan kesan polos --}}
<div class="min-h-screen flex items-center justify-center p-6 bg-gradient-to-br from-green-50 relative overflow-hidden">
    {{-- Overlay pattern SVG --}}
    <div class="absolute inset-0 z-0 opacity-10" style="background-image: url('data:image/svg+xml,%3Csvg width=\'6\' height=\'6\' viewBox=\'0 0 6 6\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cg fill=\'%23a0aec0\' fill-opacity=\'0.2\' fill-rule=\'evenodd\'%3E%3Cpath d=\'M5 0h1L0 6V5zM6 5v1H5z\'/%3E%3C/g%3E%3C/svg%3E'); background-size: 6px 6px;"></div>

    <div class="w-full max-w-3xl bg-white rounded-xl shadow-2xl p-8 transform transition duration-500 hover:scale-[1.01] hover:shadow-3xl relative z-10 overflow-hidden">
        {{-- Efek cahaya atau bentuk abstrak di background kontainer --}}
        <div class="absolute -top-10 -right-10 w-48 h-48 bg-green-200 rounded-full mix-blend-multiply filter blur-xl opacity-30 animate-blob"></div>
        <div class="absolute -bottom-10 -left-10 w-48 h-48 bg-blue-200 rounded-full mix-blend-multiply filter blur-xl opacity-30 animate-blob animation-delay-2000"></div>

        <div class="text-center mb-10 relative z-10">
            {{-- Ikon Profil dengan bayangan yang lebih dalam --}}
            <div class="mx-auto w-28 h-28 bg-gradient-to-br from-green-500 rounded-full flex items-center justify-center text-white text-5xl font-extrabold mb-5 shadow-xl border-4 border-white">
                {{ substr($user->username, 0, 1) }} {{-- Mengambil inisial dari username --}}
            </div>
            <h1 class="text-5xl font-extrabold text-gray-900 tracking-tighter leading-tight">{{ $user->username }}</h1>
            <p class="text-gray-600 text-xl mt-2 font-light">{{ $user->email }}</p>
        </div>

        <div class="border-t border-gray-200 pt-8 relative z-10">
            {{-- PESAN SUKSES DARI REDIRECT SETELAH UPDATE (SUDAH DITAMBAHKAN) --}}
            @if (session('success'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded" role="alert">
                    <p>{{ session('success') }}</p>
                </div>
            @endif

            {{-- PESAN ERROR UMUM (jika ada) --}}
            @if ($errors->any())
                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded" role="alert">
                    <p class="font-bold">Ada kesalahan:</p>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- PESAN UNTUK PERUBAHAN EMAIL YANG TERTUNDA --}}
            @if (auth()->user()->pending_email)
                <div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4 mb-6 rounded" role="alert">
                    <p><i class="fas fa-exclamation-triangle mr-2"></i> Perubahan email Anda ke <strong>{{ auth()->user()->pending_email }}</strong> sedang menunggu verifikasi. Silakan cek inbox email baru Anda.</p>
                    {{-- Anda bisa tambahkan tombol untuk kirim ulang email verifikasi di sini jika mau --}}
                </div>
            @endif


            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                {{-- Detail Informasi Dasar --}}
                <div class="bg-white rounded-lg p-7 shadow-lg border border-gray-100 transform transition duration-300 hover:translate-y-[-5px] hover:shadow-xl">
                    <h2 class="text-2xl font-bold text-gray-800 mb-5 flex items-center">
                        <i class="fas fa-id-card text-green-500 mr-4 text-3xl"></i> Informasi Dasar
                    </h2>
                    <div class="mb-5">
                        <p class="text-sm text-gray-500 font-medium mb-2">Username</p>
                        <p class="text-gray-900 text-xl font-semibold leading-relaxed">{{ $user->username }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 font-medium mb-2">Alamat Email</p>
                        <p class="text-gray-900 text-xl font-semibold leading-relaxed">{{ $user->email }}</p>
                    </div>
                </div>

                {{-- Detail Kontak --}}
                <div class="bg-white rounded-lg p-7 shadow-lg border border-gray-100 transform transition duration-300 hover:translate-y-[-5px] hover:shadow-xl">
                    <h2 class="text-2xl font-bold text-gray-800 mb-5 flex items-center">
                        <i class="fas fa-address-book text-purple-500 mr-4 text-3xl"></i> Detail Kontak
                    </h2>
                    <div class="mb-5">
                        <p class="text-sm text-gray-500 font-medium mb-2">Alamat</p>
                        <p class="text-gray-900 text-xl font-semibold leading-relaxed">{{ $user->address ?? 'Belum diatur' }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 font-medium mb-2">Nomor Telepon</p>
                        <p class="text-gray-900 text-xl font-semibold leading-relaxed">{{ $user->phone_number ?? 'Belum diatur' }}</p>
                    </div>
                </div>

                {{-- Riwayat Akun --}}
                <div class="md:col-span-2 bg-white rounded-lg p-7 shadow-lg border border-gray-100 transform transition duration-300 hover:translate-y-[-5px] hover:shadow-xl">
                    <h2 class="text-2xl font-bold text-gray-800 mb-5 flex items-center">
                        <i class="fas fa-clock text-blue-500 mr-4 text-3xl"></i> Riwayat Akun
                    </h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-5">
                        @if (isset($user->created_at))
                        <div>
                            <p class="text-sm text-gray-500 font-medium mb-2">Bergabung Sejak</p>
                            <p class="text-gray-900 text-xl font-semibold leading-relaxed">{{ $user->created_at->isoFormat('D MMMM [Tahun] YYYY') }}</p>
                        </div>
                        @endif
                        @if (isset($user->updated_at))
                        <div>
                            <p class="text-sm text-gray-500 font-medium mb-2">Terakhir Diperbarui</p>
                            <p class="text-gray-900 text-xl font-semibold leading-relaxed">{{ $user->updated_at->isoFormat('D MMMM [Tahun] YYYY, HH:mm') }}</p>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        {{-- Tombol Aksi --}}
        <div class="mt-12 text-center relative z-10 flex flex-wrap justify-center gap-4">
            <a href="{{ route('profile.edit') }}" class="inline-flex items-center justify-center px-8 py-3 border border-transparent text-lg font-bold rounded-full shadow-lg text-white bg-gradient-to-r from-green-500 to-blue-500 hover:from-green-600 hover:to-blue-600 focus:outline-none focus:ring-4 focus:ring-green-300 focus:ring-opacity-75 transition duration-300 transform hover:scale-105 active:scale-95">
                <i class="fas fa-user-edit mr-2"></i> Kelola Profil
            </a>
            
            {{-- TOMBOL GANTI PASSWORD --}}
            <a href="{{ route('profile.edit') }}" class="inline-flex items-center justify-center px-8 py-3 border border-gray-300 text-lg font-bold rounded-full shadow-lg text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-4 focus:ring-gray-300 focus:ring-opacity-75 transition duration-300 transform hover:scale-105 active:scale-95">
                <i class="fas fa-key mr-2"></i> Ganti Password
            </a>
        </div>
    </div>
</div>

<style>
    /* Keyframes untuk animasi blob */
    @keyframes blob {
        0% { transform: translate(0px, 0px) scale(1); }
        33% { transform: translate(30px, -50px) scale(1.1); }
        66% { transform: translate(-20px, 20px) scale(0.9); }
        100% { transform: translate(0px, 0px) scale(1); }
    }

    .animate-blob { animation: blob 7s infinite cubic-bezier(0.68, -0.55, 0.27, 1.55); }
    .animation-delay-2000 { animation-delay: 2s; }
</style>
@endsection