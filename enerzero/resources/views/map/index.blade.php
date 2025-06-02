@extends('layouts.app') {{-- Gunakan layout utama dashboard kamu --}}
@section('title', 'Map - Enerzero')

@section('content')
<div class="min-h-screen">
    <div class="w-full">
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
            <div class="p-4 bg-gradient-to-r from-blue-600 to-blue-800">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                    <h1 class="text-2xl md:text-3xl font-extrabold text-white tracking-tight">
                        Charging Stations Map
                    </h1>
                    <div class="flex flex-wrap gap-3 items-center">
                        <form id="searchForm" class="flex items-center bg-white rounded-lg shadow px-2 py-1 mr-2" onsubmit="return false;">
                            <input id="searchInput" type="text" placeholder="Search location..." class="bg-transparent focus:outline-none px-2 py-1 text-blue-800 placeholder-gray-400 w-40 md:w-56" />
                            <button type="submit" class="text-blue-600 hover:text-blue-800 px-2 py-1">
                                <i class="fas fa-search"></i>
                            </button>
                        </form>
                        <button id="currentLocation" class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-white text-blue-600 font-semibold shadow hover:bg-blue-50 transition">
                            <i class="fas fa-location-arrow"></i> Use My Location
                        </button>
                        <a href="{{ route('map.favorites') }}" class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-yellow-400 text-white font-semibold shadow hover:bg-yellow-500 transition">
                            <i class="fas fa-star"></i> My Favorites
                        </a>
                    </div>
                </div>
            </div>
            
            <div class="p-0">
                <div id="map" class="w-full" style="height:calc(100vh - 180px);"></div>
            </div>
            
            <div class="p-4 bg-white border-t border-gray-200 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <p class="text-sm text-gray-500">
                    Map data provided by <a href="https://openchargemap.org" target="_blank" class="text-blue-600 hover:text-blue-800">OpenChargeMap</a>
                </p>
                <div id="status-message" class="text-sm font-medium"></div>
            </div>
        </div>
    </div>
</div>

<!-- Leaflet CSS -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"/>
<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<!-- Tailwind CSS -->
<script src="https://cdn.tailwindcss.com"></script>

<!-- Leaflet JS -->
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<!-- Google Maps JavaScript API -->
<script src="https://maps.googleapis.com/maps/api/js?key=YOUR_GOOGLE_MAPS_API_KEY&libraries=places"></script>

<script>
    // Debug function
    function showStatus(message, isError = false) {
        const statusDiv = document.getElementById('status-message');
        statusDiv.innerHTML = message;
        statusDiv.className = isError ? 'text-red-600' : 'text-green-600';
        console.log(isError ? 'Error:' : 'Status:', message);
    }

    // Initialize map centered on Indonesia
    const map = L.map('map').setView([-6.200000, 106.816666], 13);
    let currentUserLocation = null;
    let userLocationMarker = null;
    
    showStatus('Map initialized');
    
    // Add OpenStreetMap tiles
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap contributors'
    }).addTo(map);

    // Initialize favorites from localStorage
    let favorites = JSON.parse(localStorage.getItem('chargingStationFavorites') || '[]');
    showStatus(`Loaded ${favorites.length} favorites`);

    function createStationPopup(station) {
        try {
            console.log('Popup for station:', station.ID, station.AddressInfo?.Title);
            const connections = station.Connections || [];
            const connectionsList = connections.map(conn => `
                <div class="flex flex-col md:flex-row md:items-center gap-2 mb-2">
                    <span class="inline-block px-2 py-1 rounded text-xs font-semibold ${conn.StatusType?.IsOperational ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700'}">
                        ${conn.ConnectionType?.Title || 'Unknown'} (${conn.PowerKW ? conn.PowerKW + ' kW' : 'N/A'})
                    </span>
                    <span class="text-xs text-gray-500">${conn.StatusType?.Title || 'Unknown'}</span>
                </div>
            `).join('');

            const isFavorite = favorites.some(fav => String(fav.ID) === String(station.ID));
            
            return `
                <div class="station-popup p-4 min-w-[300px] max-w-[350px]">
                    <div class="flex items-center justify-between mb-4">
                        <h5 class="text-xl font-bold text-blue-800 leading-tight">${station.AddressInfo.Title}</h5>
                        <button onclick="toggleFavorite(${station.ID})" 
                                class="p-2 rounded-full ${isFavorite ? 'bg-yellow-400 text-white' : 'bg-gray-100 text-gray-400'} hover:bg-yellow-400 hover:text-white transition">
                            <i class="fas fa-star"></i>
                        </button>
                    </div>
                    <div class="space-y-5">
                        <div class="location-details">
                            <div class="font-semibold text-gray-700 mb-1">Location</div>
                            <div class="text-gray-700 text-sm leading-tight mb-1">
                                ${station.AddressInfo.AddressLine1 || ''}<br>
                                ${station.AddressInfo.Town || ''}${station.AddressInfo.Town ? ',' : ''} ${station.AddressInfo.StateOrProvince || ''}<br>
                                ${station.AddressInfo.Country?.Title || ''}
                            </div>
                            <div class="text-xs text-gray-500 mb-1">
                                Lat/Long: ${station.AddressInfo.Latitude}, ${station.AddressInfo.Longitude}
                            </div>
                        </div>
                        <div class="equipment-details">
                            <div class="font-semibold text-gray-700 mb-1">Equipment Details</div>
                            <div class="text-sm text-gray-700 mb-1">Number of Points: ${connections.length}</div>
                            <div class="flex flex-col gap-1">${connectionsList}</div>
                        </div>
                        <div class="usage-details">
                            <div class="font-semibold text-gray-700 mb-1">Usage Information</div>
                            <div class="flex items-center gap-2 mb-2">
                                <span class="inline-block px-2 py-1 rounded text-xs font-semibold bg-${station.StatusType?.IsOperational ? 'green' : 'red'}-100 text-${station.StatusType?.IsOperational ? 'green' : 'red'}-700">
                                    ${station.StatusType?.Title || 'Unknown'}
                                </span>
                            </div>
                            ${station.UsageType ? `<div class='text-sm text-gray-700 mb-1'>Usage Type: ${station.UsageType.Title}</div>` : ''}
                            ${station.UsageCost ? `<div class='text-sm text-gray-700 mb-1'>Cost: ${station.UsageCost}</div>` : ''}
                        </div>
                        <div class="operator-details">
                            <div class="font-semibold text-gray-700 mb-1">Network/Operator</div>
                            <div class="text-sm text-gray-700 mb-1">${station.OperatorInfo?.Title || 'Unknown'}</div>
                            ${station.OperatorInfo?.WebsiteURL ? 
                                `<a href="${station.OperatorInfo.WebsiteURL}" target="_blank" class="text-blue-600 hover:text-blue-800 text-sm underline">Visit Website</a>` : 
                                ''}
                        </div>
                        <div class="flex gap-2 pt-2">
                            <button onclick="getDirections(${station.AddressInfo.Latitude}, ${station.AddressInfo.Longitude})" 
                                    class="flex-1 inline-flex items-center justify-center gap-2 px-4 py-2 rounded-lg bg-blue-600 text-white font-semibold shadow hover:bg-blue-700 transition">
                                <i class="fas fa-directions"></i> Get Directions
                            </button>
                            <a href="https://openchargemap.org/site/poi/details/${station.ID}" 
                               target="_blank" 
                               class="flex-1 inline-flex items-center justify-center gap-2 px-4 py-2 rounded-lg border border-blue-400 text-blue-700 font-semibold hover:bg-blue-50 transition">
                                <i class="fas fa-info-circle"></i> More Details
                            </a>
                        </div>
                    </div>
                </div>
            `;
        } catch (error) {
            console.error('Error creating popup:', error);
            return `<div class="p-4 text-red-600">Error loading station details</div>`;
        }
    }

    // Function to load charging stations
    async function loadChargingStations(lat, lng) {
        try {
            showStatus('Loading charging stations...');
            const response = await fetch(`/api/charging-stations?lat=${lat}&lng=${lng}`);
            
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            
            const stations = await response.json();
            
            if (stations.error) {
                throw new Error(stations.error);
            }
            
            showStatus(`Found ${stations.length} stations`);
            
            // Clear existing markers
            map.eachLayer((layer) => {
                if (layer instanceof L.Marker) {
                    map.removeLayer(layer);
                }
            });

            // Add markers for each station
            stations.forEach(station => {
                if (station.AddressInfo && station.AddressInfo.Latitude && station.AddressInfo.Longitude) {
                    const marker = L.marker([
                        station.AddressInfo.Latitude,
                        station.AddressInfo.Longitude
                    ], { stationData: station }).addTo(map);
                    marker.bindPopup(createStationPopup(station));
                }
            });

            // Simpan data stasiun terakhir yang di-load (untuk fallback)
            window.lastStations = stations;
        } catch (error) {
            console.error('Error loading charging stations:', error);
            showStatus('Error loading charging stations: ' + error.message, true);
        }
    }

    // Function to get directions using Google Maps
    function getDirections(destLat, destLng) {
        // Koordinat Telkom University Bandung
        const telkomUnivLat = -6.973265;
        const telkomUnivLng = 107.630539;
        const origin = `${telkomUnivLat},${telkomUnivLng}`;
        const destination = `${destLat},${destLng}`;
        const googleMapsUrl = `https://www.google.com/maps/dir/?api=1&origin=${origin}&destination=${destination}&travelmode=driving`;
        window.open(googleMapsUrl, '_blank');
        showStatus('Opening Google Maps with directions');
    }

    // Simpan seluruh objek stasiun ke localStorage
    function toggleFavorite(stationId) {
        try {
            // Ambil data stasiun dari marker yang sedang dibuka pop-upnya
            let station = null;
            // Cari marker yang pop-upnya terbuka
            map.eachLayer(function(layer) {
                if (layer instanceof L.Marker && layer.isPopupOpen && layer.isPopupOpen()) {
                    // Ambil data stasiun dari konten popup
                    if (layer.options.stationData) {
                        station = layer.options.stationData;
                    }
                }
            });
            // Jika tidak ketemu, fallback: cari dari data terakhir yang di-load
            if (!station && window.lastStations) {
                station = window.lastStations.find(s => String(s.ID) === String(stationId));
            }
            if (!station) {
                showStatus('Station data not found', true);
                return;
            }
            // Ambil favorites dari localStorage
            let favorites = JSON.parse(localStorage.getItem('chargingStationFavorites') || '[]');
            // Cek apakah sudah ada
            const index = favorites.findIndex(fav => String(fav.ID) === String(stationId));
            if (index === -1) {
                favorites.push(station);
                showStatus('Added to favorites');
            } else {
                favorites.splice(index, 1);
                showStatus('Removed from favorites');
            }
            localStorage.setItem('chargingStationFavorites', JSON.stringify(favorites));
            // Reload the popup to update the favorite status
            const marker = Array.from(map._layers).find(layer => 
                layer instanceof L.Marker && 
                layer.getPopup() && 
                layer.getPopup().getContent().includes(`toggleFavorite(${stationId})`)
            );
            if (marker) {
                marker.closePopup();
                marker.openPopup();
            }
        } catch (error) {
            console.error('Error toggling favorite:', error);
            showStatus('Error updating favorites: ' + error.message, true);
        }
    }

    // Handle current location button click with improved accuracy
    document.getElementById('currentLocation').addEventListener('click', () => {
        // Koordinat default Telkom University Bandung
        const lat = -6.973265;
        const lng = 107.630539;
        currentUserLocation = { lat, lng };
        // Hapus marker lokasi user sebelumnya jika ada
        if (userLocationMarker) {
            map.removeLayer(userLocationMarker);
        }
        // Tambahkan marker lokasi user (bulatan biru)
        userLocationMarker = L.circleMarker([lat, lng], {
            radius: 10,
            color: '#007bff',
            fillColor: '#007bff',
            fillOpacity: 0.5,
            weight: 3
        }).addTo(map).bindTooltip('Default: Telkom University', {permanent: false, direction: 'top'});
        map.setView([lat, lng], 17, { animate: true });
        showStatus('Using default location: Telkom University Bandung. Loading nearby stations...');
        loadChargingStations(lat, lng);
    });

    // Search location feature
    document.getElementById('searchForm').addEventListener('submit', async function(e) {
        e.preventDefault();
        const query = document.getElementById('searchInput').value.trim();
        if (!query) return;
        showStatus('Searching location...');
        try {
            // Nominatim OpenStreetMap Geocoding API
            const url = `https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(query)}`;
            const res = await fetch(url);
            const data = await res.json();
            if (data && data.length > 0) {
                const lat = parseFloat(data[0].lat);
                const lng = parseFloat(data[0].lon);
                map.setView([lat, lng], 15, { animate: true });
                showStatus(`Found location: ${data[0].display_name}`);
                loadChargingStations(lat, lng);
            } else {
                showStatus('Location not found', true);
            }
        } catch (err) {
            showStatus('Error searching location', true);
        }
    });

    // Load initial data for Jakarta
    loadChargingStations(-6.200000, 106.816666);
</script>

<style>
    .station-popup .leaflet-popup-content-wrapper {
        padding: 0;
        border-radius: 0.5rem;
    }
    
    .station-popup .leaflet-popup-tip {
        background: white;
    }
</style>
@endsection