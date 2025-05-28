@extends('layouts.app')

@section('title', 'Simulasi Hemat Energi')

@section('content')
<div class="container mx-auto px-4 py-8">
    <header class="mb-6 flex flex-col sm:flex-row items-start sm:items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-green-900">Simulasi Hemat Energi</h1>
            <p class="text-gray-600">Hitung potensi penghematan energi dan biaya Anda.</p>
        </div>
        <div class="mt-4 sm:mt-0 flex gap-2">
            <a href="{{ route('devices.index') }}" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                <i class="fas fa-plug mr-2"></i> Kelola Perangkat
            </a>
            <a href="{{ route('energy.simulation.history') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                <i class="fas fa-history mr-2"></i> Lihat Riwayat Simulasi
            </a>
        </div>
    </header>

    @if(session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4" role="alert">
            <p>{{ session('success') }}</p>
        </div>
    @endif
    @if(session('error'))
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4" role="alert">
            <p>{{ session('error') }}</p>
        </div>
    @endif
    
    {{-- Display validation errors if any --}}
    @if ($errors->any())
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6" role="alert">
            <strong class="font-bold">Oops! Ada beberapa masalah dengan input Anda:</strong>
            <ul class="mt-2 list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('energy.simulation.calculate') }}" method="POST" id="simulationForm" class="bg-white p-6 rounded-lg shadow-md space-y-6">
        @csrf
        
        {{-- Golongan Tarif --}}
        <div class="space-y-4">
            <h2 class="text-xl font-semibold text-green-700">Golongan Tarif Listrik</h2>
            <div>
                <label class="block text-sm font-medium text-gray-700">Pilih Golongan Tarif</label>
                <select name="tariff_group" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500" required>
                    <option value="">Pilih Golongan Tarif</option>
                    @foreach($tariffGroups as $code => $group)
                        <option value="{{ $code }}" {{ old('tariff_group') == $code ? 'selected' : '' }}>
                            {{ $group['name'] }} (Rp {{ number_format($group['tariff'], 0, ',', '.') }}/kWh)
                        </option>
                    @endforeach
                </select>
                <p class="mt-1 text-sm text-gray-500">Pilih golongan tarif listrik Anda sesuai dengan tagihan PLN</p>
            </div>
        </div>

        {{-- Perangkat Saat Ini --}}
        <div class="space-y-4">
            <h2 class="text-xl font-semibold text-green-700">Perangkat Saat Ini</h2>
            <div id="currentDevices">
                <div class="device-entry grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Perangkat</label>
                        <select name="current_devices[]" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500" required>
                            <option value="">Pilih Perangkat</option>
                            @foreach($devices as $device)
                                <option value="{{ $device->id }}" data-wattage="{{ $device->wattage }}">
                                    {{ $device->name }} ({{ $device->wattage }} Watt)
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Durasi (Jam/Hari)</label>
                        <input type="number" name="current_hours[]" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500" min="0" max="24" step="0.5" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Jumlah Hari</label>
                        <input type="number" name="current_days[]" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500" min="1" max="31" required>
                    </div>
                </div>
            </div>
            <button type="button" onclick="addDevice('currentDevices')" class="mt-2 bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                <i class="fas fa-plus mr-2"></i> Tambah Perangkat
            </button>
        </div>

        {{-- Perangkat Setelah Perubahan --}}
        <div class="space-y-4">
            <h2 class="text-xl font-semibold text-green-700">Perangkat Setelah Perubahan</h2>
            <div id="changedDevices">
                <div class="device-entry grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Perangkat</label>
                        <select name="changed_devices[]" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500" required>
                            <option value="">Pilih Perangkat</option>
                            @foreach($devices as $device)
                                <option value="{{ $device->id }}" data-wattage="{{ $device->wattage }}">
                                    {{ $device->name }} ({{ $device->wattage }} Watt)
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Durasi (Jam/Hari)</label>
                        <input type="number" name="changed_hours[]" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500" min="0" max="24" step="0.5" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Jumlah Hari</label>
                        <input type="number" name="changed_days[]" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500" min="1" max="31" required>
                    </div>
                </div>
            </div>
            <button type="button" onclick="addDevice('changedDevices')" class="mt-2 bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                <i class="fas fa-plus mr-2"></i> Tambah Perangkat
            </button>
        </div>

        <div class="flex justify-end">
            <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                <i class="fas fa-calculator mr-2"></i> Hitung Simulasi
            </button>
        </div>
    </form>
</div>

@push('scripts')
<script>
function addDevice(containerId) {
    const container = document.getElementById(containerId);
    const template = container.querySelector('.device-entry').cloneNode(true);
    
    // Reset values
    template.querySelectorAll('input, select').forEach(input => {
        input.value = '';
    });
    
    container.appendChild(template);
}

// Remove device entry
document.addEventListener('click', function(e) {
    if (e.target.classList.contains('remove-device')) {
        const container = e.target.closest('.device-entry');
        if (container.parentElement.children.length > 1) {
            container.remove();
        }
    }
});
</script>
@endpush
@endsection 