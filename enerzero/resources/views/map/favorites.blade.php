@extends('layouts.app')
@section('title', 'My Favorites - Enerzero')

@section('content')
<div class="min-h-screen py-10 px-2 md:px-0 flex items-center justify-center">
    <div class="w-full max-w-none bg-white/80 rounded-3xl shadow-2xl p-0 backdrop-blur-md">
        <div class="rounded-t-3xl bg-gradient-to-r from-blue-600 to-blue-400 px-8 py-8 flex flex-col md:flex-row md:items-center md:justify-between gap-4 shadow-lg mb-10">
            <h1 class="text-3xl md:text-4xl font-extrabold text-white tracking-tight drop-shadow">My Favorite Charging Stations</h1>
            <a href="{{ route('map.index') }}" class="inline-flex items-center gap-2 px-5 py-2 rounded-lg bg-white text-blue-700 font-bold shadow hover:bg-blue-50 transition">
                <i class="fas fa-map-marked-alt"></i> Back to Map
            </a>
        </div>
        <div id="favorites-list" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 animate-fadein mt-4 w-full">
            <!-- Favorites will be loaded here -->
        </div>
    </div>
</div>

<!-- Tailwind CSS CDN -->
<script src="https://cdn.tailwindcss.com"></script>
<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

<script>
    document.addEventListener('DOMContentLoaded', function() {
        loadFavorites();
    });

    function loadFavorites() {
        const favorites = JSON.parse(localStorage.getItem('chargingStationFavorites') || '[]');
        const favoritesList = document.getElementById('favorites-list');

        if (favorites.length === 0) {
            favoritesList.innerHTML = `
                <div class="col-span-full flex flex-col items-center justify-center py-16">
                    <i class="fas fa-star fa-5x text-yellow-400 mb-6 animate-bounce"></i>
                    <h3 class="text-2xl font-bold text-gray-700 mb-2">No Favorite Stations Yet</h3>
                    <p class="text-gray-500 text-lg">Go to the map and mark some stations as your favorites!</p>
                </div>
            `;
            return;
        }

        favoritesList.innerHTML = '';

        favorites.forEach((station) => {
            if (!station || !station.AddressInfo) return;
            const card = createFavoriteCard(station);
            favoritesList.appendChild(card);
        });
    }

    function createFavoriteCard(station) {
        const connections = station.Connections || [];
        const connectionsList = connections.map(conn => `
            <div class="flex items-center gap-2 mb-1">
                <span class="inline-block px-2 py-1 rounded text-xs font-semibold ${conn.StatusType?.IsOperational ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700'}">
                    ${conn.ConnectionType?.Title || 'Unknown'} (${conn.PowerKW ? conn.PowerKW + ' kW' : 'N/A'})
                </span>
                <span class="text-xs text-gray-400">${conn.StatusType?.Title || 'Unknown'}</span>
            </div>
        `).join('');

        const card = document.createElement('div');
        card.className = 'bg-white rounded-2xl shadow-lg flex flex-col h-full border border-blue-100 hover:shadow-2xl transition';
        card.innerHTML = `
            <div class="flex items-center justify-between px-6 pt-6 pb-2">
                <h2 class="text-xl font-bold text-blue-800">${station.AddressInfo.Title}</h2>
                <button onclick="removeFavorite(${station.ID})" class="text-red-500 hover:bg-red-100 rounded-full p-2 transition" title="Remove from favorites">
                    <i class="fas fa-trash"></i>
                </button>
            </div>
            <div class="px-6 pb-4 flex-1">
                <div class="mb-3">
                    <span class="font-semibold text-gray-600">Location:</span>
                    <div class="text-gray-700 text-sm leading-tight">
                        ${station.AddressInfo.AddressLine1 || ''}<br>
                        ${station.AddressInfo.Town || ''}${station.AddressInfo.Town ? ',' : ''} ${station.AddressInfo.StateOrProvince || ''}<br>
                        ${station.AddressInfo.Country?.Title || ''}
                    </div>
                </div>
                <div class="mb-3">
                    <span class="font-semibold text-gray-600">Equipment Details:</span>
                    <div class="text-gray-700 text-sm">
                        Number of Points: ${connections.length}<br>
                        ${connectionsList}
                    </div>
                </div>
                <div class="mb-3">
                    <span class="font-semibold text-gray-600">Usage Information:</span>
                    <div class="text-gray-700 text-sm">
                        Status: <span class="inline-block px-2 py-1 rounded text-xs font-semibold bg-${station.StatusType?.IsOperational ? 'green' : 'red'}-100 text-${station.StatusType?.IsOperational ? 'green' : 'red'}-700">
                            ${station.StatusType?.Title || 'Unknown'}
                        </span><br>
                        ${station.UsageType ? `Usage Type: ${station.UsageType.Title}<br>` : ''}
                        ${station.UsageCost ? `Cost: ${station.UsageCost}<br>` : ''}
                    </div>
                </div>
            </div>
            <div class="px-6 pb-6 flex items-center justify-between gap-2">
                <button onclick="getDirections(${station.AddressInfo.Latitude}, ${station.AddressInfo.Longitude})" 
                        class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-blue-600 text-white font-semibold shadow hover:bg-blue-700 transition">
                    <i class="fas fa-directions"></i> Get Directions
                </button>
                <a href="https://openchargemap.org/site/poi/details/${station.ID}" 
                   target="_blank" 
                   class="inline-flex items-center gap-2 px-4 py-2 rounded-lg border border-blue-400 text-blue-700 font-semibold hover:bg-blue-50 transition">
                    <i class="fas fa-info-circle"></i> More Details
                </a>
            </div>
        `;
        return card;
    }

    function removeFavorite(stationId) {
        const favorites = JSON.parse(localStorage.getItem('chargingStationFavorites') || '[]');
        const idStr = String(stationId);
        const index = favorites.findIndex(fav => String(fav.ID) === idStr);
        if (index !== -1) {
            favorites.splice(index, 1);
            localStorage.setItem('chargingStationFavorites', JSON.stringify(favorites));
            // Reload the favorites list
            loadFavorites();
        }
    }

    function getDirections(destLat, destLng) {
        // Telkom University Bandung coordinates
        const telkomUnivLat = -6.9736;
        const telkomUnivLng = 107.6304;
        
        const origin = `${telkomUnivLat},${telkomUnivLng}`;
        const destination = `${destLat},${destLng}`;
        const googleMapsUrl = `https://www.google.com/maps/dir/?api=1&origin=${origin}&destination=${destination}&travelmode=driving`;
        window.open(googleMapsUrl, '_blank');
    }
</script>

<style>
@keyframes fadein {
  from { opacity: 0; transform: translateY(30px); }
  to { opacity: 1; transform: none; }
}
.animate-fadein { animation: fadein 0.7s cubic-bezier(.4,2,.6,1) both; }
</style>

<!-- Tidak perlu style tambahan, semua pakai Tailwind -->
@endsection 