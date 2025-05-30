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
                'id' => 'maintain_excellence',
                'title' => 'Maintain Excellence: Keep your energy usage under your current level for 7 days',
                'description' => 'Continue your great energy habits and maintain low consumption',
                'points' => 10,
                'difficulty' => 'Easy',
                'icon' => 'fa-leaf',
                'duration_days' => 7
            ],
            [
                'id' => 'green_champion',
                'title' => 'Green Champion: Use only LED lights for the entire week',
                'description' => 'Switch all your lighting to energy-efficient LED bulbs',
                'points' => 10,
                'difficulty' => 'Easy',
                'icon' => 'fa-lightbulb',
                'duration_days' => 7
            ],
            [
                'id' => 'eco_warrior',
                'title' => 'Eco Warrior: Unplug all devices when not in use for 5 days',
                'description' => 'Eliminate phantom loads by unplugging electronics',
                'points' => 10,
                'difficulty' => 'Medium',
                'icon' => 'fa-plug',
                'duration_days' => 5
            ],
            [
                'id' => 'solar_saver',
                'title' => 'Solar Saver: Use natural light during daytime for 3 days',
                'description' => 'Maximize daylight usage and minimize artificial lighting',
                'points' => 10,
                'difficulty' => 'Easy',
                'icon' => 'fa-sun',
                'duration_days' => 3
            ],
            [
                'id' => 'smart_thermostat',
                'title' => 'Smart Thermostat: Optimize AC temperature to 24-26°C for a week',
                'description' => 'Find the perfect balance between comfort and efficiency',
                'points' => 10,
                'difficulty' => 'Medium',
                'icon' => 'fa-thermometer-half',
                'duration_days' => 7
            ]
        ],
        'warning' => [
            [
                'id' => 'energy_detective',
                'title' => 'Energy Detective: Identify and reduce your top 3 energy consumers',
                'description' => 'Find which appliances use the most energy and optimize them',
                'points' => 10,
                'difficulty' => 'Medium',
                'icon' => 'fa-search',
                'duration_days' => 7
            ],
            [
                'id' => 'time_master',
                'title' => 'Time Master: Reduce daily appliance usage by 2 hours',
                'description' => 'Cut down on unnecessary appliance runtime',
                'points' => 10,
                'difficulty' => 'Medium',
                'icon' => 'fa-clock',
                'duration_days' => 7
            ],
            [
                'id' => 'standby_slayer',
                'title' => 'Standby Slayer: Eliminate standby power consumption for 5 days',
                'description' => 'Turn off devices completely instead of leaving them on standby',
                'points' => 10,
                'difficulty' => 'Medium',
                'icon' => 'fa-power-off',
                'duration_days' => 5
            ],
            [
                'id' => 'cooling_optimizer',
                'title' => 'Cooling Optimizer: Increase AC temperature by 2°C for a week',
                'description' => 'Small temperature adjustments can make big energy savings',
                'points' => 10,
                'difficulty' => 'Easy',
                'icon' => 'fa-snowflake',
                'duration_days' => 7
            ],
            [
                'id' => 'peak_avoider',
                'title' => 'Peak Avoider: Shift energy usage away from peak hours (6-9 PM)',
                'description' => 'Use major appliances during off-peak times',
                'points' => 10,
                'difficulty' => 'Hard',
                'icon' => 'fa-chart-line',
                'duration_days' => 14
            ]
        ],
        'bad' => [
            [
                'id' => 'energy_emergency',
                'title' => 'Energy Emergency: Reduce consumption by 15% this week',
                'description' => 'Take immediate action to cut down your energy usage significantly',
                'points' => 10,
                'difficulty' => 'Hard',
                'icon' => 'fa-exclamation-triangle',
                'duration_days' => 7
            ],
            [
                'id' => 'appliance_audit',
                'title' => 'Appliance Audit: Turn off 3 non-essential appliances for 3 days',
                'description' => 'Identify and temporarily stop using energy-hungry devices',
                'points' => 10,
                'difficulty' => 'Medium',
                'icon' => 'fa-list-check',
                'duration_days' => 3
            ],
            [
                'id' => 'ac_rehabilitation',
                'title' => 'AC Rehabilitation: Limit AC usage to 6 hours per day maximum',
                'description' => 'Drastically reduce air conditioning dependency',
                'points' => 10,
                'difficulty' => 'Hard',
                'icon' => 'fa-wind',
                'duration_days' => 7
            ],
            [
                'id' => 'hot_water_saver',
                'title' => 'Hot Water Saver: Take cold showers for 5 days',
                'description' => 'Eliminate water heating energy consumption temporarily',
                'points' => 10,
                'difficulty' => 'Hard',
                'icon' => 'fa-shower',
                'duration_days' => 5
            ],
            [
                'id' => 'lighting_lockdown',
                'title' => 'Lighting Lockdown: Use only 50% of your usual lighting for a week',
                'description' => 'Reduce lighting usage by turning off unnecessary lights',
                'points' => 10,
                'difficulty' => 'Medium',
                'icon' => 'fa-lightbulb',
                'duration_days' => 7
            ]
        ]
    ];

    // Get challenges for current status
    $availableChallenges = $challengesByStatus[$usageStatus];
@endphp

<div class="flex min-h-screen bg-green-100">
    <!-- Main Content -->
    <main class="flex-1 p-8">
        <h2 class="text-2xl font-bold mb-6">Challenges</h2>

        <div id="score-display" class="my-4">
            <h3 class="text-lg font-semibold">Your Score : <span id="score">0</span></h3>
        </div>

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
            <div class="space-y-3" id="availableChallengesContainer">
                @foreach($availableChallenges as $index => $challenge)
                    <div class="challenge-item flex justify-between items-center bg-white p-4 rounded shadow cursor-pointer hover:shadow-md transition-shadow" 
                         data-id="{{ $challenge['id'] }}" 
                         data-challenge="{{ json_encode($challenge) }}"
                         id="challenge-{{ $challenge['id'] }}">
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
                                    <span class="text-xs bg-blue-100 text-blue-800 px-2 py-1 rounded-full font-medium">
                                        {{ $challenge['duration_days'] }} {{ $challenge['duration_days'] == 1 ? 'Day' : 'Days' }}
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
                <!-- Progress challenges will be populated from localStorage -->
            </div>
            <div id="noProgressMessage" class="text-center text-gray-500 py-8">
                <i class="fas fa-trophy text-4xl mb-4 opacity-50"></i>
                <p class="text-lg font-medium">No challenges in progress</p>
                <p class="text-sm">Accept a challenge above to get started!</p>
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
                    <span id="challengeDuration" class="text-sm bg-blue-100 text-blue-800 px-3 py-1 rounded-full font-medium"></span>
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

    <!-- Complete Challenge Modal -->
    <div id="completeModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50">
        <div class="bg-white p-6 rounded-lg shadow-xl w-96 max-w-md mx-4">
            <div class="text-center mb-4">
                <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-check-circle text-green-600 text-2xl"></i>
                </div>
                <h2 class="text-xl font-bold text-gray-800 mb-2">Challenge Completed!</h2>
                <h3 id="completeTitle" class="text-lg font-semibold text-green-700 mb-2"></h3>
                <p class="text-gray-600 mb-4">Congratulations! You've successfully completed this challenge.</p>
                <div class="flex justify-center space-x-4 mb-4">
                    <span id="earnedPoints" class="text-sm bg-yellow-100 text-yellow-800 px-3 py-1 rounded-full font-medium"></span>
                </div>
            </div>
            
            <div class="flex justify-center">
                <button id="completeOkBtn" class="px-6 py-2 bg-green-500 hover:bg-green-600 text-white rounded-lg font-medium transition-colors">
                    Awesome!
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    const challengeItems = document.querySelectorAll('.challenge-item');
    const modal = document.getElementById('confirmationModal');
    const completeModal = document.getElementById('completeModal');
    const cancelBtn = document.getElementById('cancelBtn');
    const confirmBtn = document.getElementById('confirmBtn');
    const completeOkBtn = document.getElementById('completeOkBtn');
    const onProgressContainer = document.getElementById('onProgressContainer');
    const noProgressMessage = document.getElementById('noProgressMessage');
    const availableChallengesContainer = document.getElementById('availableChallengesContainer');

    // Modal elements
    const challengeTitle = document.getElementById('challengeTitle');
    const challengeDescription = document.getElementById('challengeDescription');
    const challengePoints = document.getElementById('challengePoints');
    const challengeDifficulty = document.getElementById('challengeDifficulty');
    const challengeDuration = document.getElementById('challengeDuration');

    let selectedChallenge = null;
    let selectedChallengeData = null;

    // Storage keys
    const STORAGE_KEYS = {
        ACTIVE_CHALLENGES: 'activeChallenges',
        ACCEPTED_CHALLENGES: 'acceptedChallenges'
    };

    // Utility functions for time calculations
    function formatTimeRemaining(endTime) {
        const now = new Date().getTime();
        const distance = endTime - now;

        if (distance < 0) {
            return "Completed!";
        }

        const days = Math.floor(distance / (1000 * 60 * 60 * 24));
        const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));

        if (days > 0) {
            return `${days}d ${hours}h left`;
        } else if (hours > 0) {
            return `${hours}h ${minutes}m left`;
        } else {
            return `${minutes}m left`;
        }
    }

    function calculateProgress(startTime, endTime) {
        const now = new Date().getTime();
        const totalDuration = endTime - startTime;
        const elapsed = now - startTime;
        
        if (elapsed <= 0) return 0;
        if (elapsed >= totalDuration) return 100;
        
        return Math.floor((elapsed / totalDuration) * 100);
    }

    // Storage management
    function getActiveChallenges() {
        try {
            return JSON.parse(localStorage.getItem(STORAGE_KEYS.ACTIVE_CHALLENGES)) || [];
        } catch (e) {
            return [];
        }
    }

    function saveActiveChallenges(challenges) {
        localStorage.setItem(STORAGE_KEYS.ACTIVE_CHALLENGES, JSON.stringify(challenges));
    }

    function getAcceptedChallenges() {
        try {
            return JSON.parse(localStorage.getItem(STORAGE_KEYS.ACCEPTED_CHALLENGES)) || [];
        } catch (e) {
            return [];
        }
    }

    function saveAcceptedChallenges(challenges) {
        localStorage.setItem(STORAGE_KEYS.ACCEPTED_CHALLENGES, JSON.stringify(challenges));
    }

    function isChallengeAccepted(challengeId) {
        const acceptedChallenges = getAcceptedChallenges();
        return acceptedChallenges.includes(challengeId);
    }

    function addAcceptedChallenge(challengeId) {
        const acceptedChallenges = getAcceptedChallenges();
        if (!acceptedChallenges.includes(challengeId)) {
            acceptedChallenges.push(challengeId);
            saveAcceptedChallenges(acceptedChallenges);
        }
    }

    // Challenge management
    function createProgressItem(challengeData) {
        const progressDiv = document.createElement('div');
        progressDiv.className = 'bg-white p-4 rounded shadow challenge-progress';
        progressDiv.dataset.challengeId = challengeData.id;
        
        const progress = calculateProgress(challengeData.startTime, challengeData.endTime);
        const timeRemaining = formatTimeRemaining(challengeData.endTime);
        const isCompleted = progress >= 100;
        
        progressDiv.innerHTML = `
            <div class="flex justify-between items-center mb-2">
                <div class="flex items-center flex-1">
                    <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center mr-3">
                        <i class="fas ${challengeData.icon} text-green-600 text-sm"></i>
                    </div>
                    <div class="flex-1">
                        <h5 class="font-medium text-gray-800 text-sm">${challengeData.title}</h5>
                        <div class="flex items-center space-x-2 mt-1">
                            <span class="text-xs bg-yellow-100 text-yellow-800 px-2 py-1 rounded-full font-medium">
                                ${challengeData.points} Points
                            </span>
                            ${isCompleted ? 
                                '<span class="text-xs bg-green-100 text-green-800 px-2 py-1 rounded-full font-medium">Completed!</span>' :
                                `<span class="text-xs bg-blue-100 text-blue-800 px-2 py-1 rounded-full font-medium">${timeRemaining}</span>`
                            }
                        </div>
                    </div>
                </div>
                <div class="w-5 h-5 ${isCompleted ? 'bg-green-500' : 'bg-yellow-500'} rounded-full"></div>
            </div>
            <div class="mt-2 text-sm text-gray-500">Progress</div>
            <div class="w-full bg-gray-300 rounded-full h-2 mt-1">
                <div class="progress-bar ${isCompleted ? 'bg-green-500' : 'bg-yellow-400'} h-2 rounded-full transition-all duration-500" style="width: ${progress}%"></div>
            </div>
            ${isCompleted ? 
                `<button class="complete-btn mt-3 w-full bg-green-500 hover:bg-green-600 text-white py-2 px-4 rounded-lg font-medium transition-colors" data-challenge-id="${challengeData.id}">
                    Claim Reward
                </button>` : ''
            }
        `;

        return progressDiv;
    }

    function updateProgressBars() {
        const activeChallenges = getActiveChallenges();
        const progressItems = document.querySelectorAll('.challenge-progress');
        
        progressItems.forEach(item => {
            const challengeId = item.dataset.challengeId;
            const challengeData = activeChallenges.find(c => c.id === challengeId);
            
            if (challengeData) {
                const progress = calculateProgress(challengeData.startTime, challengeData.endTime);
                const timeRemaining = formatTimeRemaining(challengeData.endTime);
                const isCompleted = progress >= 100;
                
                const progressBar = item.querySelector('.progress-bar');
                const statusSpan = item.querySelector('.text-xs.bg-blue-100, .text-xs.bg-green-100');
                const statusIcon = item.querySelector('.w-5.h-5');
                
                if (progressBar) {
                    progressBar.style.width = progress + '%';
                    if (isCompleted && !progressBar.classList.contains('bg-green-500')) {
                        progressBar.classList.remove('bg-yellow-400');
                        progressBar.classList.add('bg-green-500');
                    }
                }
                
                if (statusSpan && !isCompleted) {
                    statusSpan.textContent = timeRemaining;
                } else if (statusSpan && isCompleted) {
                    statusSpan.textContent = 'Completed!';
                    statusSpan.classList.remove('bg-blue-100', 'text-blue-800');
                    statusSpan.classList.add('bg-green-100', 'text-green-800');
                }
                
                if (statusIcon && isCompleted) {
                    statusIcon.classList.remove('bg-yellow-500');
                    statusIcon.classList.add('bg-green-500');
                }
                
                // Add complete button if completed and not already present
                if (isCompleted && !item.querySelector('.complete-btn')) {
                    const completeBtn = document.createElement('button');
                    completeBtn.className = 'complete-btn mt-3 w-full bg-green-500 hover:bg-green-600 text-white py-2 px-4 rounded-lg font-medium transition-colors';
                    completeBtn.dataset.challengeId = challengeId;
                    completeBtn.textContent = 'Claim Reward';
                    item.appendChild(completeBtn);
                    
                    completeBtn.addEventListener('click', () => completeChallenge(challengeId));
                }
            }
        });
    }

    function loadProgressChallenges() {
        const activeChallenges = getActiveChallenges();
        onProgressContainer.innerHTML = '';
        
        if (activeChallenges.length === 0) {
            noProgressMessage.style.display = 'block';
        } else {
            noProgressMessage.style.display = 'none';
            activeChallenges.forEach(challengeData => {
                const progressItem = createProgressItem(challengeData);
                onProgressContainer.appendChild(progressItem);
                
                // Add event listener for complete button if challenge is completed
                const completeBtn = progressItem.querySelector('.complete-btn');
                if (completeBtn) {
                    completeBtn.addEventListener('click', () => completeChallenge(challengeData.id));
                }
            });
        }
    }

    function hideAcceptedChallenges() {
        const acceptedChallenges = getAcceptedChallenges();
        acceptedChallenges.forEach(challengeId => {
            const challengeElement = document.getElementById(`challenge-${challengeId}`);
            if (challengeElement) {
                challengeElement.style.display = 'none';
            }
        });
    }

    function completeChallenge(challengeId) {
        const activeChallenges = getActiveChallenges();
        const challengeIndex = activeChallenges.findIndex(c => c.id === challengeId);
        
        if (challengeIndex !== -1) {
            const challengeData = activeChallenges[challengeIndex];
            
            // Show completion modal
            document.getElementById('completeTitle').textContent = challengeData.title;
            document.getElementById('earnedPoints').textContent = `+${challengeData.points} Points Earned!`;
            completeModal.classList.remove('hidden');
            
            // Remove from active challenges
            activeChallenges.splice(challengeIndex, 1);
            saveActiveChallenges(activeChallenges);
            
            // Reload progress challenges
            setTimeout(() => {
                loadProgressChallenges();
            }, 100);
        }
    }

    // Event listeners
    challengeItems.forEach(item => {
        item.addEventListener('click', () => {
            const challengeId = item.dataset.id;
            
            // Check if challenge is already accepted
            if (isChallengeAccepted(challengeId)) {
                return; // Don't show modal if already accepted
            }
            
            selectedChallenge = item;
            selectedChallengeData = JSON.parse(item.dataset.challenge);
            
            // Update modal content
            challengeTitle.textContent = selectedChallengeData.title;
            challengeDescription.textContent = selectedChallengeData.description;
            challengePoints.textContent = selectedChallengeData.points + ' Points';
            challengeDuration.textContent = selectedChallengeData.duration_days + (selectedChallengeData.duration_days == 1 ? ' Day' : ' Days');
            
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
            const now = new Date().getTime();
            const endTime = now + (selectedChallengeData.duration_days * 24 * 60 * 60 * 1000);
            
            const challengeWithTiming = {
                ...selectedChallengeData,
                startTime: now,
                endTime: endTime,
                acceptedAt: new Date().toISOString()
            };
            
            // Add to active challenges
            const activeChallenges = getActiveChallenges();
            activeChallenges.push(challengeWithTiming);
            saveActiveChallenges(activeChallenges);
            
            // Add to accepted challenges (to hide from available)
            addAcceptedChallenge(selectedChallengeData.id);
            
            // Hide from available challenges
            selectedChallenge.style.display = 'none';
            
            // Reload progress challenges
            loadProgressChallenges();
            
            modal.classList.add('hidden');
            selectedChallenge = null;
            selectedChallengeData = null;
        }
    });

    completeOkBtn.addEventListener('click', () => {
        completeModal.classList.add('hidden');
    });

    // Close modals when clicking outside
    modal.addEventListener('click', (e) => {
        if (e.target === modal) {
            modal.classList.add('hidden');
            selectedChallenge = null;
            selectedChallengeData = null;
        }
    });

    completeModal.addEventListener('click', (e) => {
        if (e.target === completeModal) {
            completeModal.classList.add('hidden');
        }
    });

    // Initialize page
    document.addEventListener('DOMContentLoaded', () => {
        loadProgressChallenges();
        hideAcceptedChallenges();
        
        // Update progress bars every 30 seconds
        setInterval(updateProgressBars, 30000);
        
        // Update progress bars every minute for more frequent updates
        setInterval(() => {
            updateProgressBars();
        }, 60000);
        
        // Initial update
        setTimeout(updateProgressBars, 1000);
    });

    // Clean up completed challenges from localStorage periodically
    function cleanupOldChallenges() {
        const activeChallenges = getActiveChallenges();
        const now = new Date().getTime();
        
        // Remove challenges that ended more than 7 days ago
        const cleanedChallenges = activeChallenges.filter(challenge => {
            return (now - challenge.endTime) < (7 * 24 * 60 * 60 * 1000);
        });
        
        if (cleanedChallenges.length !== activeChallenges.length) {
            saveActiveChallenges(cleanedChallenges);
        }
    }

    // Run cleanup on page load
    cleanupOldChallenges();
    
    // Add keyboard shortcuts
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') {
            if (!modal.classList.contains('hidden')) {
                modal.classList.add('hidden');
                selectedChallenge = null;
                selectedChallengeData = null;
            }
            if (!completeModal.classList.contains('hidden')) {
                completeModal.classList.add('hidden');
            }
        }
    });
    
    let totalScore = 0;

    function tambahSkor(nilai) {
        totalScore += nilai;
        document.getElementById('score').innerText = totalScore;
        document.getElementById('score-input').value = totalScore;
    }
</script>
@endsection