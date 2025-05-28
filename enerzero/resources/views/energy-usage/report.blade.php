@extends('layouts.app')

@section('title', 'Enerzero | Energy Usage Report')

@section('content')
@php
    $maxUsage = $monthlyUsage->isNotEmpty() ? max($monthlyUsage->toArray()) : 1;
    $maxUsage = $maxUsage > 0 ? $maxUsage : 1;
@endphp


<div class="space-y-6">
    <header class="mb-6 flex items-center justify-between">
        <div class="flex items-center gap-2">
            <i class="fas fa-chart-line text-2xl text-green-700"></i>
            <h1 class="text-3xl font-bold text-green-900">Energy Usage Report</h1>
        </div>
    </header>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Monthly Comparison Card -->
        <div class="bg-white rounded-lg p-6 shadow-md">
            <h2 class="text-xl font-semibold text-green-700 mb-4">Monthly Comparison</h2>
            <div class="flex items-center justify-between mb-4">
                <div>
                    <p class="text-gray-600">Current Month Usage</p>
                    <p class="text-2xl font-bold">{{ $comparisonData['current_month'] }} kWh</p>
                </div>
                <div class="text-right">
                    <p class="text-gray-600">Previous Month</p>
                    <p class="text-xl">{{ $comparisonData['previous_month'] }} kWh</p>
                </div>
            </div>
            <div class="flex items-center gap-2 {{ $comparisonData['trend'] === 'increase' ? 'text-red-500' : 'text-green-500' }}">
                <i class="fas fa-{{ $comparisonData['trend'] === 'increase' ? 'arrow-up' : 'arrow-down' }}"></i>
                <span class="font-semibold">{{ $comparisonData['percentage_change'] }}% {{ $comparisonData['trend'] }}</span>
                <span class="text-gray-600">from last month</span>
            </div>
        </div>

        <!-- Usage Breakdown Card -->
        <div class="bg-white rounded-lg p-6 shadow-md">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-xl font-semibold text-green-700">Usage Breakdown</h2>
                <a href="{{ route('energy.create') }}" class="inline-block bg-green-600 hover:bg-green-700 text-white text-sm font-semibold px-4 py-2 rounded-lg shadow">
                    + Input Data
                </a>
            </div>
            <div class="space-y-4">
                @foreach($monthlyUsage as $month => $usage)
                <div>
                    <div class="flex justify-between text-sm text-gray-600 mb-1">
                        <span>{{ $month }}</span>
                        <span>{{ $usage }} kWh</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2">
                        <div class="bg-green-500 h-2 rounded-full" style="width: {{ ($usage / $maxUsage) * 100 }}%"></div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Usage Analysis Card -->
        <div class="bg-white rounded-lg p-6 shadow-md md:col-span-2">
            <h2 class="text-xl font-semibold text-green-700 mb-4">Analysis & Recommendations</h2>
            <div class="space-y-4">
                <div class="flex items-start gap-4">
                    <div class="p-3 bg-green-100 rounded-lg">
                        <i class="fas fa-lightbulb text-green-600"></i>
                    </div>
                    <div>
                        <h3 class="font-semibold text-gray-800">Usage Pattern</h3>
                        <p class="text-gray-600">Your energy consumption shows a slight increase compared to last month. Peak usage typically occurs during evening hours.</p>
                    </div>
                </div>
                <div class="flex items-start gap-4">
                    <div class="p-3 bg-yellow-100 rounded-lg">
                        <i class="fas fa-exclamation-triangle text-yellow-600"></i>
                    </div>
                    <div>
                        <h3 class="font-semibold text-gray-800">Areas of Concern</h3>
                        <p class="text-gray-600">We've noticed higher than average consumption during off-peak hours, which might indicate standby power waste.</p>
                    </div>
                </div>
                <div class="flex items-start gap-4">
                    <div class="p-3 bg-blue-100 rounded-lg">
                        <i class="fas fa-list-check text-blue-600"></i>
                    </div>
                    <div>
                        <h3 class="font-semibold text-gray-800">Recommendations</h3>
                        <ul class="list-disc list-inside text-gray-600 space-y-2">
                            <li>Consider using smart power strips to reduce standby power consumption</li>
                            <li>Adjust your thermostat settings during peak hours</li>
                            <li>Replace any remaining incandescent bulbs with LED alternatives</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
