@extends('layouts.app')
@section('title', 'Enerzero | Challenge')

<!-- Main Content -->
@section('content')
@php
    // Set default values jika data tidak ada
    $comparisonData = $comparisonData ?? [
        'current_month' => 0,
        'previous_month' => 0,
        'percentage_change' => 0,
        'trend' => 'no_change'
    ];
    
    // Tentukan status berdasarkan trend dan persentase perubahan
    $usageStatus = 'good';
    $statusMessage = '';
    $statusColor = 'text-green-600';
    
    if ($comparisonData['trend'] === 'increase') {
        if ($comparisonData['percentage_change'] > 20) {
            $usageStatus = 'bad';
            $statusMessage = 'Penggunaan energi meningkat signifikan! Perlu perhatian lebih untuk efisiensi energi.';
            $statusColor = 'text-red-600';
        } elseif ($comparisonData['percentage_change'] > 10) {
            $usageStatus = 'warning';
            $statusMessage = 'Penggunaan energi meningkat. Coba perhatikan kebiasaan penggunaan energi Anda.';
            $statusColor = 'text-yellow-600';
        }
    } else {
        $usageStatus = 'good';
        $statusMessage = 'Hebat! Penggunaan energi Anda efisien. Terus pertahankan kebiasaan baik ini!';
        $statusColor = 'text-green-600';
    }

    // Define challenges based on usage status
    $challengesByStatus = [
        'good' => [
            [
                'title' => 'Maintain Excellence: Keep your energy usage under your current level for 7 days',
                'description' => 'Continue your great energy habits and maintain low consumption',
                'points' => 10,
                'difficulty' => 'Easy',
                'icon' => 'fa-leaf'
            ],
            [
                'title' => 'Green Champion: Use only LED lights for the entire week',
                'description' => 'Switch all your lighting to energy-efficient LED bulbs',
                'points' => 10,
                'difficulty' => 'Easy',
                'icon' => 'fa-lightbulb'
            ],
            [
                'title' => 'Eco Warrior: Unplug all devices when not in use for 5 days',
                'description' => 'Eliminate phantom loads by unplugging electronics',
                'points' => 10,
                'difficulty' => 'Medium',
                'icon' => 'fa-plug'
            ],
            [
                'title' => 'Solar Saver: Use natural light during daytime for 3 days',
                'description' => 'Maximize daylight usage and minimize artificial lighting',
                'points' => 10,
                'difficulty' => 'Easy',
                'icon' => 'fa-sun'
            ],
            [
                'title' => 'Smart Thermostat: Optimize AC temperature to 24-26°C for a week',
                'description' => 'Find the perfect balance between comfort and efficiency',
                'points' => 10,
                'difficulty' => 'Medium',
                'icon' => 'fa-thermometer-half'
            ]
        ],
        'warning' => [
            [
                'title' => 'Energy Detective: Identify and reduce your top 3 energy consumers',
                'description' => 'Find which appliances use the most energy and optimize them',
                'points' => 10,
                'difficulty' => 'Medium',
                'icon' => 'fa-search'
            ],
            [
                'title' => 'Time Master: Reduce daily appliance usage by 2 hours',
                'description' => 'Cut down on unnecessary appliance runtime',
                'points' => 10,
                'difficulty' => 'Medium',
                'icon' => 'fa-clock'
            ],
            [
                'title' => 'Standby Slayer: Eliminate standby power consumption for 5 days',
                'description' => 'Turn off devices completely instead of leaving them on standby',
                'points' => 10,
                'difficulty' => 'Medium',
                'icon' => 'fa-power-off'
            ],
            [
                'title' => 'Cooling Optimizer: Increase AC temperature by 2°C for a week',
                'description' => 'Small temperature adjustments can make big energy savings',
                'points' => 10,
                'difficulty' => 'Easy',
                'icon' => 'fa-snowflake'
            ],
            [
                'title' => 'Peak Avoider: Shift energy usage away from peak hours (6-9 PM)',
                'description' => 'Use major appliances during off-peak times',
                'points' => 10,
                'difficulty' => 'Hard',
                'icon' => 'fa-chart-line'
            ]
        ],
        'bad' => [
            [
                'title' => 'Energy Emergency: Reduce consumption by 15% this week',
                'description' => 'Take immediate action to cut down your energy usage significantly',
                'points' => 10,
                'difficulty' => 'Hard',
                'icon' => 'fa-exclamation-triangle'
            ],
            [
                'title' => 'Appliance Audit: Turn off 3 non-essential appliances for 3 days',
                'description' => 'Identify and temporarily stop using energy-hungry devices',
                'points' => 10,
                'difficulty' => 'Medium',
                'icon' => 'fa-list-check'
            ],
            [
                'title' => 'AC Rehabilitation: Limit AC usage to 6 hours per day maximum',
                'description' => 'Drastically reduce air conditioning dependency',
                'points' => 10,
                'difficulty' => 'Hard',
                'icon' => 'fa-wind'
            ],
            [
                'title' => 'Hot Water Saver: Take cold showers for 5 days',
                'description' => 'Eliminate water heating energy consumption temporarily',
                'points' => 10,
                'difficulty' => 'Hard',
                'icon' => 'fa-shower'
            ],
            [
                'title' => 'Lighting Lockdown: Use only 50% of your usual lighting for a week',
                'description' => 'Reduce lighting usage by turning off unnecessary lights',
                'points' => 10,
                'difficulty' => 'Medium',
                'icon' => 'fa-lightbulb'
            ]
        ]
    ];

    // Get challenges for current status
    $availableChallenges = $challengesByStatus[$usageStatus];
    
    // Get random ongoing challenges (simulated)
    $ongoingChallenges = collect($challengesByStatus['good'])
        ->merge($challengesByStatus['warning'])
        ->shuffle()
        ->take(4);
@endphp

<div class="flex min-h-screen bg-green-100">
    <!-- Main Content -->
    <main class="flex-1 p-8">
        <h2 class="text-2xl font-bold mb-6">Challenges</h2>

        <!-- Simulation Summary -->
        <div class="bg-white p-4 rounded shadow mb-6">
            <h3 class="text-green-700 font-semibold mb-2">USAGE DATA SUMMARY</h3>
            <div class="flex items-center">
                <!-- Chart placeholder -->
                <div class="w-1/3 flex items-center justify-center">
                    <div class="text-center">
                        <div class="w-20 h-20 mx-auto mb-2 rounded-full flex items-center justify-center {{ $usageStatus === 'good' ? 'bg-green-100' : ($usageStatus === 'warning' ? 'bg-yellow-100' : 'bg-red-100') }}">
                            <i class="fas {{ $usageStatus === 'good' ? 'fa-leaf text-green-600' : ($usageStatus === 'warning' ? 'fa-exclamation-triangle text-yellow-600' : 'fa-bolt text-red-600') }} text-2xl"></i>
                        </div>
                        <p class="text-sm font-semibold {{ $statusColor }}">
                            {{ ucfirst($usageStatus) }} Usage
                        </p>
                    </div>
                </div>
                
                <div class="flex-1 ml-6">
                    <!-- Usage Statistics -->
                    <div class="mb-2">
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-600">Current Month:</span>
                            <span class="font-semibold">{{ $comparisonData['current_month'] }} kWh</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-600">Previous Month:</span>
                            <span class="font-semibold">{{ $comparisonData['previous_month'] }} kWh</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-600">Change:</span>
                            <span class="font-semibold {{ $comparisonData['trend'] === 'increase' ? 'text-red-500' : 'text-green-500' }}">
                                {{ $comparisonData['trend'] === 'increase' ? '+' : '-' }}{{ $comparisonData['percentage_change'] }}%
                            </span>
                        </div>
                    </div>

                    <!-- Status indicators -->
                    <ul class="text-sm text-gray-700 mb-2">
                        <li class="{{ $usageStatus === 'good' ? 'font-semibold text-green-600' : '' }}">🟢 Good energy usage</li>
                        <li class="{{ $usageStatus === 'warning' ? 'font-semibold text-yellow-600' : '' }}">🟡 Moderate energy usage</li>
                        <li class="{{ $usageStatus === 'bad' ? 'font-semibold text-red-600' : '' }}">🔴 High energy usage</li>
                    </ul>
                    
                    <p class="text-gray-600 text-sm">{{ $statusMessage }}</p>
                    <a href="{{ route('energy.index') }}" class="inline-block mt-2 bg-yellow-400 hover:bg-yellow-500 px-4 py-1 rounded font-semibold text-sm transition-colors">
                        See Detail
                    </a>
                </div>
            </div>
        </div>

        <!-- Challenge list Section -->
        <div class="mb-6">
            <h3 class="text-xl font-bold text-green-800 mb-4">
                Available Challenges 
                <span class="text-sm font-normal text-gray-600">(Based on your {{ ucfirst($usageStatus) }} energy usage)</span>
            </h3>
            <div class="space-y-3">
                @foreach($availableChallenges as $index => $challenge)
                    <div class="challenge-item flex justify-between items-center bg-white p-4 rounded shadow cursor-pointer hover:shadow-md transition-shadow" 
                         data-id="{{ $index }}" 
                         data-challenge="{{ json_encode($challenge) }}"
                         id="challenge-{{ $index }}">
                        <div class="flex items-center flex-1">
                            <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center mr-4">
                                <i class="fas {{ $challenge['icon'] }} text-green-600"></i>
                            </div>
                            <div class="flex-1">
                                <h4 class="font-semibold text-gray-800">{{ $challenge['title'] }}</h4>
                                <p class="text-sm text-gray-600 mt-1">{{ $challenge['description'] }}</p>
                                <div class="flex items-center mt-2 space-x-4">
                                    <span class="text-xs bg-yellow-100 text-yellow-800 px-2 py-1 rounded-full font-medium">
                                        {{ $challenge['points'] }} Points
                                    </span>
                                    <span class="text-xs px-2 py-1 rounded-full font-medium
                                        {{ $challenge['difficulty'] === 'Easy' ? 'bg-green-100 text-green-800' : 
                                           ($challenge['difficulty'] === 'Medium' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                                        {{ $challenge['difficulty'] }}
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="w-5 h-5 border-2 border-gray-300 rounded-full hover:border-green-500 transition-colors"></div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Challenge Progress -->
        <div>
            <h3 class="text-xl font-bold text-green-800 mb-4">On Progress</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4" id="onProgressContainer">
                @foreach($ongoingChallenges as $index => $challenge)
                    <div class="bg-white p-4 rounded shadow">
                        <div class="flex justify-between items-center mb-2">
                            <div class="flex items-center flex-1">
                                <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center mr-3">
                                    <i class="fas {{ $challenge['icon'] }} text-green-600 text-sm"></i>
                                </div>
                                <div class="flex-1">
                                    <h5 class="font-medium text-gray-800 text-sm">{{ $challenge['title'] }}</h5>
                                    <span class="text-xs bg-yellow-100 text-yellow-800 px-2 py-1 rounded-full font-medium mt-1 inline-block">
                                        {{ $challenge['points'] }} Points
                                    </span>
                                </div>
                            </div>
                            <div class="w-5 h-5 bg-green-500 rounded-full"></div>
                        </div>
                        <div class="mt-2 text-sm text-gray-500">Progress</div>
                        <div class="w-full bg-gray-300 rounded-full h-2 mt-1">
                            <div class="bg-yellow-400 h-2 rounded-full" style="width: {{ rand(20, 80) }}%"></div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </main>

    <!-- Modal -->
    <div id="confirmationModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50">
        <div class="bg-white p-6 rounded-lg shadow-xl w-96 max-w-md mx-4">
            <div class="text-center mb-4">
                <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-trophy text-green-600 text-2xl"></i>
                </div>
                <h2 class="text-xl font-bold text-gray-800 mb-2">Accept Challenge?</h2>
                <h3 id="challengeTitle" class="text-lg font-semibold text-green-700 mb-2"></h3>
                <p id="challengeDescription" class="text-gray-600 mb-4"></p>
                <div class="flex justify-center space-x-4 mb-4">
                    <span id="challengePoints" class="text-sm bg-yellow-100 text-yellow-800 px-3 py-1 rounded-full font-medium"></span>
                    <span id="challengeDifficulty" class="text-sm px-3 py-1 rounded-full font-medium"></span>
                </div>
            </div>
            
            <div class="flex justify-center space-x-4">
                <button id="cancelBtn" class="px-6 py-2 bg-gray-300 hover:bg-gray-400 text-gray-700 rounded-lg font-medium transition-colors">
                    Cancel
                </button>
                <button id="confirmBtn" class="px-6 py-2 bg-green-500 hover:bg-green-600 text-white rounded-lg font-medium transition-colors">
                    Accept Challenge
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    const challengeItems = document.querySelectorAll('.challenge-item');
    const modal = document.getElementById('confirmationModal');
    const cancelBtn = document.getElementById('cancelBtn');
    const confirmBtn = document.getElementById('confirmBtn');
    const onProgressContainer = document.getElementById('onProgressContainer');

    // Modal elements
    const challengeTitle = document.getElementById('challengeTitle');
    const challengeDescription = document.getElementById('challengeDescription');
    const challengePoints = document.getElementById('challengePoints');
    const challengeDifficulty = document.getElementById('challengeDifficulty');

    let selectedChallenge = null;
    let selectedChallengeData = null;

    challengeItems.forEach(item => {
        item.addEventListener('click', () => {
            selectedChallenge = item;
            selectedChallengeData = JSON.parse(item.dataset.challenge);
            
            // Update modal content
            challengeTitle.textContent = selectedChallengeData.title;
            challengeDescription.textContent = selectedChallengeData.description;
            challengePoints.textContent = selectedChallengeData.points + ' Points';
            
            // Set difficulty styling
            challengeDifficulty.textContent = selectedChallengeData.difficulty;
            challengeDifficulty.className = 'text-sm px-3 py-1 rounded-full font-medium ';
            if (selectedChallengeData.difficulty === 'Easy') {
                challengeDifficulty.className += 'bg-green-100 text-green-800';
            } else if (selectedChallengeData.difficulty === 'Medium') {
                challengeDifficulty.className += 'bg-yellow-100 text-yellow-800';
            } else {
                challengeDifficulty.className += 'bg-red-100 text-red-800';
            }
            
            modal.classList.remove('hidden');
        });
    });

    cancelBtn.addEventListener('click', () => {
        modal.classList.add('hidden');
        selectedChallenge = null;
        selectedChallengeData = null;
    });

    confirmBtn.addEventListener('click', () => {
        if (selectedChallenge && selectedChallengeData) {
            // Remove from available challenges
            selectedChallenge.remove();

            // Create new progress item
            const newProgress = document.createElement('div');
            newProgress.className = 'bg-white p-4 rounded shadow';
            newProgress.innerHTML = `
                <div class="flex justify-between items-center mb-2">
                    <div class="flex items-center flex-1">
                        <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center mr-3">
                            <i class="fas ${selectedChallengeData.icon} text-green-600 text-sm"></i>
                        </div>
                        <div class="flex-1">
                            <h5 class="font-medium text-gray-800 text-sm">${selectedChallengeData.title}</h5>
                            <span class="text-xs bg-yellow-100 text-yellow-800 px-2 py-1 rounded-full font-medium mt-1 inline-block">
                                ${selectedChallengeData.points} Points
                            </span>
                        </div>
                    </div>
                    <div class="w-5 h-5 bg-green-500 rounded-full"></div>
                </div>
                <div class="mt-2 text-sm text-gray-500">Progress</div>
                <div class="w-full bg-gray-300 rounded-full h-2 mt-1">
                    <div class="bg-yellow-400 h-2 rounded-full" style="width: ${Math.floor(Math.random() * 40 + 10)}%"></div>
                </div>
            `;

            onProgressContainer.appendChild(newProgress);
            modal.classList.add('hidden');
            selectedChallenge = null;
            selectedChallengeData = null;
        }
    });

    // Close modal when clicking outside
    modal.addEventListener('click', (e) => {
        if (e.target === modal) {
            modal.classList.add('hidden');
            selectedChallenge = null;
            selectedChallengeData = null;
        }
    });
</script>
@endsection