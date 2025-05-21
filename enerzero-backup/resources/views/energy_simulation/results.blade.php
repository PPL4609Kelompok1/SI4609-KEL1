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

    @if(isset($results))
        <div class="bg-white p-6 rounded-lg shadow-md space-y-6">
            
            <!-- Ringkasan Penghematan -->
            <section class="p-6 bg-green-50 rounded-lg border border-green-200">
                <h2 class="text-2xl font-semibold text-green-800 mb-4">Ringkasan Penghematan</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-center">
                    <div>
                        <p class="text-lg text-gray-700">Estimasi Penghematan Energi Bulanan</p>
                        <p class="text-3xl font-bold text-green-600">{{ number_format($results['energy_saved_kwh'], 2, ',', '.') }} kWh</p>
                    </div>
                    <div>
                        <p class="text-lg text-gray-700">Estimasi Penghematan Biaya Bulanan</p>
                        <p class="text-3xl font-bold text-green-600">Rp {{ number_format($results['cost_saved'], 2, ',', '.') }}</p>
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
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ number_format($results['energy_consumption_before_kwh'], 2, ',', '.') }} kWh</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ number_format($results['energy_consumption_after_kwh'], 2, ',', '.') }} kWh</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold {{ $results['energy_saved_kwh'] > 0 ? 'text-green-600' : ($results['energy_saved_kwh'] < 0 ? 'text-red-600' : 'text-gray-700') }}">
                                    {{ number_format($results['energy_saved_kwh'], 2, ',', '.') }} kWh
                                    @if($results['energy_saved_kwh'] > 0) (Hemat) @elseif($results['energy_saved_kwh'] < 0) (Boros) @endif
                                </td>
                            </tr>
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">Estimasi Biaya Listrik</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">Rp {{ number_format($results['cost_before'], 2, ',', '.') }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">Rp {{ number_format($results['cost_after'], 2, ',', '.') }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold {{ $results['cost_saved'] > 0 ? 'text-green-600' : ($results['cost_saved'] < 0 ? 'text-red-600' : 'text-gray-700') }}">
                                    Rp {{ number_format($results['cost_saved'], 2, ',', '.') }}
                                     @if($results['cost_saved'] > 0) (Hemat) @elseif($results['cost_saved'] < 0) (Boros) @endif
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <p class="mt-2 text-xs text-gray-500">Tarif listrik yang digunakan: Rp {{ number_format($results['electricity_tariff'], 2, ',', '.') }}/kWh.</p>
            </section>

            <!-- Tombol Aksi (Contoh: Simpan Simulasi) -->
            @if(Auth::check()) {{-- Hanya tampilkan jika user login --}}
            <section class="mt-6 pt-4 border-t">
                <form action="{{ route('energy.simulation.save') }}" method="POST">
                    @csrf
                    {{-- Hidden fields untuk data simulasi --}}
                    <input type="hidden" name="simulation_name" value="Simulasi Otomatis - {{ date('Y-m-d H:i') }}">
                    <input type="hidden" name="data_before" value='{{ json_encode($results["input_data"]["current_appliances"]) }}'>
                    <input type="hidden" name="data_after" value='{{ json_encode($results["input_data"]["changed_appliances"]) }}'>
                    <input type="hidden" name="energy_consumption_before_kwh" value="{{ $results['energy_consumption_before_kwh'] }}">
                    <input type="hidden" name="energy_consumption_after_kwh" value="{{ $results['energy_consumption_after_kwh'] }}">
                    <input type="hidden" name="energy_saved_kwh" value="{{ $results['energy_saved_kwh'] }}">
                    <input type="hidden" name="cost_before" value="{{ $results['cost_before'] }}">
                    <input type="hidden" name="cost_after" value="{{ $results['cost_after'] }}">
                    <input type="hidden" name="cost_saved" value="{{ $results['cost_saved'] }}">
                    <input type="hidden" name="electricity_tariff" value="{{ $results['electricity_tariff'] }}">
                    
                    <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                        <i class="fas fa-save mr-2"></i> Simpan Hasil Simulasi Ini
                    </button>
                    <p class="mt-1 text-xs text-gray-500">Anda dapat memberi nama dan catatan pada simulasi yang disimpan dari halaman riwayat.</p>
                </form>
            </section>
            @else
            <div class="mt-6 p-4 bg-yellow-50 border border-yellow-200 rounded-lg">
                <p class="text-yellow-700"><i class="fas fa-info-circle mr-2"></i> <a href="{{ route('login') }}" class="font-semibold underline">Masuk</a> atau <a href="{{ route('register') }}" class="font-semibold underline">Daftar</a> untuk menyimpan hasil simulasi Anda.</p>
            </div>
            @endif

        </div>
    @else
        <div class="bg-white p-6 rounded-lg shadow-md text-center">
            <p class="text-gray-700">Tidak ada data hasil simulasi untuk ditampilkan. Silakan <a href="{{ route('energy.simulation.index') }}" class="text-green-600 hover:underline">buat simulasi baru</a>.</p>
        </div>
    @endif

</div>
@endsection 