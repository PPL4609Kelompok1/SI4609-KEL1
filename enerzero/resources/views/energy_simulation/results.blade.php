@extends('layouts.app')

@section('title', 'Hasil Simulasi Hemat Energi')

@section('content')
<div class="container mx-auto px-4 py-8">
    <header class="mb-6 flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-green-900">Hasil Simulasi Hemat Energi</h1>
            <p class="text-gray-600">Berikut adalah rincian perbandingan konsumsi dan biaya energi Anda.</p>
        </div>
        <a href="{{ route('energy.simulation.index') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
            <i class="fas fa-calculator mr-2"></i> Buat Simulasi Baru
        </a>
    </header>

    <div class="bg-white p-6 rounded-lg shadow-md space-y-6">
        
        <!-- Ringkasan Penghematan -->
        <section class="p-6 bg-green-50 rounded-lg border border-green-200">
            <h2 class="text-2xl font-semibold text-green-800 mb-4">Ringkasan Penghematan</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-center">
                <div>
                    <p class="text-lg text-gray-700">Estimasi Penghematan Energi Bulanan</p>
                    <p class="text-3xl font-bold text-green-600">{{ number_format($simulation->energy_saved_kwh, 2, ',', '.') }} kWh</p>
                </div>
                <div>
                    <p class="text-lg text-gray-700">Estimasi Penghematan Biaya Bulanan</p>
                    <p class="text-3xl font-bold text-green-600">Rp {{ number_format($simulation->cost_saved, 2, ',', '.') }}</p>
                </div>
            </div>
        </section>

        <!-- Detail Perbandingan -->
        <section>
            <h2 class="text-xl font-semibold text-green-800 mb-3">Detail Perbandingan (Estimasi Bulanan)</h2>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Deskripsi</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Sebelum Perubahan</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Setelah Perubahan</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Perbedaan</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">Total Konsumsi Energi</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ number_format($simulation->energy_consumption_before_kwh, 2, ',', '.') }} kWh</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ number_format($simulation->energy_consumption_after_kwh, 2, ',', '.') }} kWh</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold {{ $simulation->energy_saved_kwh > 0 ? 'text-green-600' : ($simulation->energy_saved_kwh < 0 ? 'text-red-600' : 'text-gray-700') }}">
                                {{ number_format($simulation->energy_saved_kwh, 2, ',', '.') }} kWh
                                @if($simulation->energy_saved_kwh > 0) (Hemat) @elseif($simulation->energy_saved_kwh < 0) (Boros) @endif
                            </td>
                        </tr>
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">Estimasi Biaya Listrik</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">Rp {{ number_format($simulation->cost_before, 2, ',', '.') }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">Rp {{ number_format($simulation->cost_after, 2, ',', '.') }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold {{ $simulation->cost_saved > 0 ? 'text-green-600' : ($simulation->cost_saved < 0 ? 'text-red-600' : 'text-gray-700') }}">
                                Rp {{ number_format($simulation->cost_saved, 2, ',', '.') }}
                                @if($simulation->cost_saved > 0) (Hemat) @elseif($simulation->cost_saved < 0) (Boros) @endif
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <p class="mt-2 text-xs text-gray-500">Tarif listrik yang digunakan: Rp {{ number_format($simulation->electricity_tariff, 2, ',', '.') }}/kWh.</p>
        </section>

        <!-- Daftar Peralatan -->
        <section class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <h3 class="text-lg font-semibold text-green-700 mb-2">Peralatan & Penggunaan (Sebelum Perubahan)</h3>
                @if(!empty($currentDevices))
                    <ul class="list-disc list-inside bg-gray-50 p-4 rounded-md space-y-2">
                        @foreach($currentDevices as $index => $device)
                            <li class="text-sm text-gray-800">
                                <strong class="font-medium">{{ $device->name }}:</strong> 
                                {{ $device->wattage }} Watt, 
                                {{ $currentHours[$index] }} jam/hari, 
                                {{ $currentDays[$index] }} hari/bulan.
                            </li>
                        @endforeach
                    </ul>
                @else
                    <p class="text-gray-500 text-sm">Data peralatan tidak tersedia.</p>
                @endif
            </div>
            <div>
                <h3 class="text-lg font-semibold text-green-700 mb-2">Peralatan & Penggunaan (Setelah Perubahan)</h3>
                @if(!empty($changedDevices))
                    <ul class="list-disc list-inside bg-gray-50 p-4 rounded-md space-y-2">
                        @foreach($changedDevices as $index => $device)
                            <li class="text-sm text-gray-800">
                                <strong class="font-medium">{{ $device->name }}:</strong> 
                                {{ $device->wattage }} Watt, 
                                {{ $changedHours[$index] }} jam/hari, 
                                {{ $changedDays[$index] }} hari/bulan.
                            </li>
                        @endforeach
                    </ul>
                @else
                    <p class="text-gray-500 text-sm">Data peralatan tidak tersedia.</p>
                @endif
            </div>
        </section>

        <!-- Tombol Aksi -->
        <section class="mt-6 pt-4 border-t">
            <a href="{{ route('energy.simulation.history') }}" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                <i class="fas fa-history mr-2"></i> Lihat Riwayat Simulasi
            </a>
        </section>

    </div>
</div>
@endsection 