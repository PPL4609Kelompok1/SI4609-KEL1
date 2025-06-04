@extends('layouts.app')

@section('title', 'Kalkulator Energi')

@section('content')
<div class="space-y-6">

    <!-- Header -->
    <header class="mb-6 flex items-center justify-between">
        <div class="flex items-center gap-2">
            <i class="fas fa-bolt text-2xl text-green-700"></i>
            <h1 class="text-3xl font-bold text-green-900">Kalkulator Energi</h1>
        </div>
    </header>

    <!-- Form Penghitungan Energi -->
    <section class="bg-white rounded-lg p-6 shadow-md">
        <h2 class="text-xl font-semibold text-green-700 mb-4">Hitung Konsumsi Energi</h2>
        <form action="{{ route('calculator.store') }}" method="POST" class="grid grid-cols-1 md:grid-cols-2 gap-4">
            @csrf
            <div>
                <label for="device_name" class="block text-sm font-medium text-gray-700">Nama Perangkat</label>
                <input type="text" name="device_name" id="device_name" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
            </div>

            <div>
                <label for="power_watt" class="block text-sm font-medium text-gray-700">Daya (Watt)</label>
                <input type="number" name="power_watt" id="power_watt" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
            </div>

            <div>
                <label for="hours_per_day" class="block text-sm font-medium text-gray-700">Durasi Pemakaian per Hari (Jam)</label>
                <input type="number" name="hours_per_day" id="hours_per_day" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
            </div>

            <div>
                <label for="days" class="block text-sm font-medium text-gray-700">Jumlah Hari Pemakaian</label>
                <input type="number" name="days" id="days" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
            </div>

            <div class="md:col-span-2 text-right">
                <button type="submit" class="bg-green-600 hover:bg-green-500 text-white px-4 py-2 rounded font-semibold">
                    Hitung Sekarang
                </button>
            </div>
        </form>
    </section>

    <!-- Rata-rata Konsumsi Energi -->
    <section class="bg-white rounded-lg p-6 shadow-md">
        <h2 class="text-xl font-semibold text-green-700 mb-4">Rata-Rata Konsumsi Energi</h2>
        <p class="text-gray-700 text-sm mb-2">Total konsumsi dari seluruh perangkat yang dicatat:</p>
        <div class="text-2xl font-bold text-green-800">
            {{ number_format($average, 2) }} kWh
        </div>
    </section>

    <section class="bg-white rounded-lg p-6 shadow-md">
        <h2 class="text-xl font-semibold text-green-700 mb-4">Daftar Perangkat Anda</h2>
        @if ($usages->count() > 0)
            <ul class="list-none p-0">
                @foreach ($usages as $usage)
                    <li class="py-2 border-b border-gray-200">
                        <div class="flex justify-between items-center">
                            <div>
                                <span class="font-semibold text-gray-800">{{ $usage->device_name }}</span>
                                <span class="text-gray-500 text-sm">({{ $usage->power_watt }} Watt, {{ $usage->hours_per_day }} Jam/Hari, {{ $usage->days }} Hari)</span>
                            </div>
                            <span class="text-green-600 font-medium">{{ number_format($usage->total_kwh, 2) }} kWh</span>
                        </div>
                    </li>
                @endforeach
            </ul>
        @else
            <p class="text-gray-500">Anda belum menghitung konsumsi energi untuk perangkat apapun.</p>
        @endif
    </section>

    <section class="bg-white rounded-lg p-6 shadow-md">
        <h2 class="text-xl font-semibold text-green-700 mb-4">Rekomendasi Produk Hemat Energi</h2>

        @if ($average > 10)
            <p class="mb-4 text-gray-700">Konsumsi energi Anda cukup tinggi. Berikut beberapa produk hemat energi yang bisa membantu menurunkan konsumsi listrik:</p>
            <ul class="space-y-4">
                <li class="flex justify-between items-start gap-4 bg-gray-50 p-3 rounded-md">
                    <div>
                        <strong>
                            <a href="{{ url('/products/3') }}" class="text-green-700 hover:underline">
                                Lampu Tenaga Surya Otomatis
                            </a>
                        </strong> - Lampu otomatis dengan panel surya untuk taman atau jalanan
                    </div>
                    <a href="{{ url('/products/3') }}" class="shrink-0 bg-green-600 text-white px-3 py-1 text-sm rounded hover:bg-green-500 self-start">
                        Lihat Produk
                    </a>
                </li>
                <li class="flex justify-between items-start gap-4 bg-gray-50 p-3 rounded-md">
                    <div>
                        <strong>
                            <a href="{{ url('/products/1') }}" class="text-green-700 hover:underline">
                                LYUMO US
                            </a>
                        </strong> - 24KW Home Electricity - Energy Factor Saver Electronic
                    </div>
                    <a href="{{ url('/products/1') }}" class="shrink-0 bg-green-600 text-white px-3 py-1 text-sm rounded hover:bg-green-500 self-start">
                        Lihat Produk
                    </a>
                </li>
            </ul>
        @elseif ($average < 10)
            <p class="mb-4 text-green-700 font-semibold">Konsumsi energi Anda sudah sangat rendah dan efisien</p>
            <p class="text-gray-700">Pertahankan kebiasaan hemat energi Anda. Tidak ada rekomendasi tambahan karena Anda sudah sangat bijak menggunakan listrik!</p>
        @else
            <p class="text-gray-700">Belum ada data konsumsi. Masukkan perangkat untuk mendapatkan rekomendasi hemat energi!</p>
        @endif
    </section>
</div>
@endsection