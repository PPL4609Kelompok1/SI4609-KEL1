@extends('layouts.app')

@section('title', 'Detail Simulasi: ' . $simulation->simulation_name)

@section('content')
<div class="container mx-auto px-4 py-8">
    <header class="mb-6 flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-green-900">
                Detail Simulasi: <span class="text-green-700">{{ $simulation->simulation_name }}</span>
            </h1>
            <p class="text-gray-600">Disimpan pada: {{ $simulation->created_at->format('d M Y, H:i:s') }}</p>
        </div>
        <div>
            <a href="{{ route('energy.simulation.history') }}" class="text-blue-600 hover:text-blue-800 mr-4">
                <i class="fas fa-arrow-left mr-1"></i> Kembali ke Riwayat
            </a>
            <a href="{{ route('energy.simulation.index') }}" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                <i class="fas fa-plus mr-2"></i> Buat Simulasi Baru
            </a>
        </div>
    </header>

    <div class="bg-white p-6 rounded-lg shadow-md space-y-8">
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
            <p class="mt-3 text-xs text-gray-500 text-center">Tarif listrik yang digunakan saat simulasi: Rp {{ number_format($simulation->electricity_tariff, 2, ',', '.') }}/kWh.</p>
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
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">Total Konsumsi Energi</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ number_format($simulation->energy_consumption_before_kwh, 2, ',', '.') }} kWh</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ number_format($simulation->energy_consumption_after_kwh, 2, ',', '.') }} kWh</td>
                        </tr>
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">Estimasi Biaya Listrik</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">Rp {{ number_format($simulation->cost_before, 2, ',', '.') }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">Rp {{ number_format($simulation->cost_after, 2, ',', '.') }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </section>

        <!-- Daftar Peralatan -->
        <section class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <h3 class="text-lg font-semibold text-green-700 mb-2">Peralatan & Penggunaan (Sebelum Perubahan)</h3>
                @if(!empty($dataBefore))
                    <ul class="list-disc list-inside bg-gray-50 p-4 rounded-md space-y-2">
                        @foreach($dataBefore as $appliance)
                            <li class="text-sm text-gray-800">
                                <strong class="font-medium">{{ $appliance['device'] }}:</strong> 
                                {{ $appliance['wattage'] }} Watt, 
                                {{ $appliance['hours'] }} jam/hari, 
                                {{ $appliance['days'] }} hari/bulan.
                            </li>
                        @endforeach
                    </ul>
                @else
                    <p class="text-gray-500 text-sm">Data peralatan tidak tersedia.</p>
                @endif
            </div>
            <div>
                <h3 class="text-lg font-semibold text-green-700 mb-2">Peralatan & Penggunaan (Setelah Perubahan)</h3>
                @if(!empty($dataAfter))
                    <ul class="list-disc list-inside bg-gray-50 p-4 rounded-md space-y-2">
                        @foreach($dataAfter as $appliance)
                            <li class="text-sm text-gray-800">
                                <strong class="font-medium">{{ $appliance['device'] }}:</strong> 
                                {{ $appliance['wattage'] }} Watt, 
                                {{ $appliance['hours'] }} jam/hari, 
                                {{ $appliance['days'] }} hari/bulan.
                            </li>
                        @endforeach
                    </ul>
                @else
                    <p class="text-gray-500 text-sm">Data peralatan tidak tersedia.</p>
                @endif
            </div>
        </section>

        <!-- Catatan Pengguna -->
        @if($simulation->notes)
            <section>
                <h3 class="text-lg font-semibold text-green-700 mb-2">Catatan Tambahan</h3>
                <div class="bg-yellow-50 p-4 rounded-md border border-yellow-200">
                    <p class="text-sm text-yellow-800">{{ nl2br(e($simulation->notes)) }}</p>
                </div>
            </section>
        @endif

    </div>
</div>
@endsection 