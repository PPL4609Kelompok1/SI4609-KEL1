@extends('layouts.app')
@section('title', 'Enerzero | Challenge')

<!-- Main Content -->
@section('content')
<div class="flex min-h-screen bg-green-100">
    <!-- Main Content -->
    <main class="flex-1 p-8">
        <h2 class="text-2xl font-bold mb-6">Challenges</h2>

        <!-- Simulation Summary -->
        <div class="bg-white p-4 rounded shadow mb-6">
            <h3 class="text-green-700 font-semibold mb-2">SIMULATION DATA SUMMARY</h3>
            <div class="flex items-center">
                <!-- Replace with real chart or image -->
                <div class="w-1/3">
                    {{-- <img src="{{ asset('images/piechart-placeholder.png') }}" alt="Pie Chart"> --}}
                </div>
                <div class="flex-1 ml-6">
                    <ul class="text-sm text-gray-700 mb-2">
                        <li>🟢 Good energy usage</li>
                        <li>🔴 Bad energy usage</li>
                        <li>⚫ Really bad energy usage</li>
                        <li>🟢 Really good energy usage</li>
                    </ul>
                    <p class="text-gray-600 text-sm">Hebat! dari data yang kami dapat, kami mengetahui bahwa kamu peka terhadap energi disekitar kamu. Semoga ini bisa terus berlangsung dan menjadi lebih baik. Kedepannya coba matikan hal...</p>
                    <button class="mt-2 bg-yellow-400 px-4 py-1 rounded font-semibold">See Detail</button>
                </div>
            </div>
        </div>

        <!-- On Progress Section -->
        <div class="mb-6">
            <h3 class="text-xl font-bold text-green-800 mb-4">On Progress</h3>
            <div class="space-y-3">
                @for($i = 0; $i < 5; $i++)
                    <div class="flex justify-between items-center bg-white p-3 rounded shadow">
                        <span>Lorem ipsum dolor sit amet</span>
                        <div class="w-5 h-5 border-2 border-gray-300 rounded-full"></div>
                    </div>
                @endfor
            </div>
        </div>

        <!-- Challenge Progress -->
        <div>
            <h3 class="text-xl font-bold text-green-800 mb-4">Challenge</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                @for($i = 0; $i < 4; $i++)
                    <div class="bg-white p-4 rounded shadow">
                        <div class="flex justify-between items-center">
                            <span>Lorem ipsum dolor sit amet</span>
                            <div class="w-5 h-5 bg-green-500 rounded-full"></div>
                        </div>
                        <div class="mt-2 text-sm text-gray-500">Progress</div>
                        <div class="w-full bg-gray-300 rounded-full h-2 mt-1">
                            <div class="bg-yellow-400 h-2 rounded-full" style="width: {{ rand(20, 80) }}%"></div>
                        </div>
                    </div>
                @endfor
            </div>
        </div>
    </main>
</div>
@endsection
