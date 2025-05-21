@extends('layouts.app')

@section('title', 'Simulasi Hemat Energi')

@section('content')
<div class="container mx-auto px-4 py-8">
    <header class="mb-6 flex flex-col sm:flex-row items-start sm:items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-green-900">Simulasi Hemat Energi</h1>
            <p class="text-gray-600">Hitung potensi penghematan energi dan biaya Anda.</p>
        </div>
        <a href="{{ route('energy.simulation.history') }}" class="mt-4 sm:mt-0 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
            <i class="fas fa-history mr-2"></i> Lihat Riwayat Simulasi
        </a>
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

        <!-- Bagian Data Saat Ini -->
        <section id="currentAppliancesSection">
            <h2 class="text-2xl font-semibold text-green-800 mb-4">Kondisi Saat Ini</h2>
            <div id="currentAppliancesContainer" class="space-y-4">
                <!-- Appliance Row Template (akan dikloning oleh JS) -->
                <div class="appliance-row flex flex-wrap items-center gap-4 p-3 border rounded-md bg-gray-50" style="display: none;" id="currentApplianceTemplate">
                    <div class="flex-grow">
                        <label class="block text-sm font-medium text-gray-700">Nama Alat</label>
                        <input type="text" name="current_appliances[0][name]" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500" placeholder="Contoh: AC, Kulkas, TV">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Daya (Watt)</label>
                        <input type="number" name="current_appliances[0][power]" min="0" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500" placeholder="Contoh: 750">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Jam/Hari</label>
                        <input type="number" name="current_appliances[0][hours_per_day]" min="0" max="24" step="0.1" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500" placeholder="Contoh: 8">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Hari/Minggu</label>
                        <input type="number" name="current_appliances[0][days_per_week]" min="0" max="7" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500" placeholder="Contoh: 7">
                    </div>
                    <div class="pt-5">
                        <button type="button" class="remove-appliance-btn text-red-600 hover:text-red-800 font-semibold">
                            <i class="fas fa-trash-alt mr-1"></i> Hapus
                        </button>
                    </div>
                </div>
            </div>
            <button type="button" id="addCurrentAppliance" class="mt-4 bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-md text-sm">
                <i class="fas fa-plus mr-1"></i> Tambah Alat (Saat Ini)
            </button>
        </section>

        <!-- Bagian Data Setelah Perubahan -->
        <section id="changedAppliancesSection" class="mt-8">
            <h2 class="text-2xl font-semibold text-green-800 mb-4">Kondisi Setelah Perubahan</h2>
            <div id="changedAppliancesContainer" class="space-y-4">
                <!-- Template for changed appliances (similar to current) -->
                <div class="appliance-row flex flex-wrap items-center gap-4 p-3 border rounded-md bg-gray-50" style="display: none;" id="changedApplianceTemplate">
                    <div class="flex-grow">
                        <label class="block text-sm font-medium text-gray-700">Nama Alat</label>
                        <input type="text" name="changed_appliances[0][name]" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500" placeholder="Contoh: AC, Kulkas, TV">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Daya (Watt)</label>
                        <input type="number" name="changed_appliances[0][power]" min="0" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500" placeholder="Contoh: 750">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Jam/Hari</label>
                        <input type="number" name="changed_appliances[0][hours_per_day]" min="0" max="24" step="0.1" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500" placeholder="Contoh: 8">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Hari/Minggu</label>
                        <input type="number" name="changed_appliances[0][days_per_week]" min="0" max="7" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500" placeholder="Contoh: 7">
                    </div>
                    <div class="pt-5">
                        <button type="button" class="remove-appliance-btn text-red-600 hover:text-red-800 font-semibold">
                             <i class="fas fa-trash-alt mr-1"></i> Hapus
                        </button>
                    </div>
                </div>
            </div>
            <button type="button" id="addChangedAppliance" class="mt-4 bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-md text-sm">
                <i class="fas fa-plus mr-1"></i> Tambah Alat (Setelah Perubahan)
            </button>
        </section>

        <!-- Tarif Listrik -->
        <section class="mt-8">
            <h2 class="text-xl font-semibold text-green-800 mb-2">Tarif Listrik</h2>
            <div>
                <label for="electricity_tariff" class="block text-sm font-medium text-gray-700">Tarif per kWh (Rp)</label>
                <input type="number" name="electricity_tariff" id="electricity_tariff" value="1444.70" step="0.01" required class="mt-1 block w-full md:w-1/3 rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500" placeholder="Contoh: 1444.70">
                <p class="mt-1 text-xs text-gray-500">Masukkan tarif listrik yang berlaku di wilayah Anda (contoh: Rp 1.444,70 per kWh).</p>
            </div>
        </section>

        <div class="mt-8 pt-6 border-t">
            <button type="submit" class="w-full md:w-auto bg-green-600 hover:bg-green-700 text-white font-bold px-8 py-3 rounded-lg transition-colors text-lg">
                <i class="fas fa-calculator mr-2"></i> Hitung Simulasi
            </button>
        </div>
    </form>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    let currentApplianceIndex = 0;
    let changedApplianceIndex = 0;

    function addAppliance(type) {
        const containerId = type === 'current' ? 'currentAppliancesContainer' : 'changedAppliancesContainer';
        const templateId = type === 'current' ? 'currentApplianceTemplate' : 'changedApplianceTemplate';
        const index = type === 'current' ? currentApplianceIndex : changedApplianceIndex;
        const prefix = type === 'current' ? 'current_appliances' : 'changed_appliances';

        const templateNode = document.getElementById(templateId);
        const newNode = templateNode.cloneNode(true);
        newNode.style.display = ''; // Make it visible
        newNode.id = ''; // Remove template ID

        newNode.querySelectorAll('input, select, textarea').forEach(input => {
            input.name = input.name.replace(prefix + '[0]', prefix + '[' + index + ']');
            input.id = input.id ? input.id.replace('0', index) : ''; // Update IDs if they exist for labels
            input.disabled = false; // Ensure inputs are enabled
            if(input.type !== 'hidden' && input.type !== 'button') input.value = ''; // Clear values for new row
        });
         newNode.querySelectorAll('label').forEach(label => {
            if(label.htmlFor) label.htmlFor = label.htmlFor.replace('0', index);
        });

        newNode.querySelector('.remove-appliance-btn').addEventListener('click', function() {
            this.closest('.appliance-row').remove();
        });

        document.getElementById(containerId).appendChild(newNode);

        if (type === 'current') {
            currentApplianceIndex++;
        } else {
            changedApplianceIndex++;
        }
    }

    // Initialize with one appliance row for each section by default
    addAppliance('current');
    addAppliance('changed');

    document.getElementById('addCurrentAppliance').addEventListener('click', () => addAppliance('current'));
    document.getElementById('addChangedAppliance').addEventListener('click', () => addAppliance('changed'));

    // Add default value for tariff (optional, could be fetched or pre-filled)
    // document.getElementById('electricity_tariff').value = '1444.70';
});
</script>
@endpush

@endsection 