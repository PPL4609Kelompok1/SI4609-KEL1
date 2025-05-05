@extends('layouts.app') {{-- Gunakan layout utama dashboard kamu --}}
@section('title', 'Map - Enerzero')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title">Charging Stations Map</h3>
                    <div>
                        <button id="currentLocation" class="btn btn-info me-2">
                            <i class="fas fa-location-arrow"></i> Use My Location
                        </button>
                        <a href="{{ route('map.favorites') }}" class="btn btn-warning me-2">
                            <i class="fas fa-star"></i> My Favorites
                        </a>
                        <a href="https://openchargemap.org" target="_blank" class="btn btn-primary">
                            <i class="fas fa-external-link-alt"></i> View on OpenChargeMap
                        </a>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div id="map" style="width: 100%; height: 700px;"></div>
                </div>
                <div class="card-footer d-flex justify-content-between align-items-center">
                    <p class="text-muted mb-0">
                        <small>
                            Map data provided by <a href="https://openchargemap.org" target="_blank">OpenChargeMap</a>
                        </small>
                    </p>
                    <div id="status-message"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Leaflet CSS -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"/>
<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

<!-- Leaflet JS -->
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<!-- Google Maps JavaScript API -->
<script src="https://maps.googleapis.com/maps/api/js?key=YOUR_GOOGLE_MAPS_API_KEY&libraries=places"></script>

<script>
    // Debug function
    function showStatus(message, isError = false) {
        const statusDiv = document.getElementById('status-message');
        statusDiv.innerHTML = message;
        statusDiv.className = isError ? 'text-danger' : 'text-success';
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
                <div class="connection-item mb-2">
                    <span class="badge ${conn.StatusType?.IsOperational ? 'bg-success' : 'bg-danger'}">
                        ${conn.ConnectionType?.Title || 'Unknown'} (${conn.PowerKW ? conn.PowerKW + ' kW' : 'N/A'})
                    </span>
                    <br>
                    <small>Status: ${conn.StatusType?.Title || 'Unknown'}</small>
                </div>
            `).join('');

            const isFavorite = favorites.includes(station.ID);
            
            return `
                <div class="station-popup">
                    <h5 class="mb-3">
                        <strong>${station.AddressInfo.Title}</strong>
                        <button onclick="toggleFavorite(${station.ID})" class="btn btn-sm float-end ${isFavorite ? 'btn-warning' : 'btn-outline-warning'}">
                            <i class="fas fa-star"></i>
                        </button>
                    </h5>
                    
                    <div class="location-details mb-3">
                        <strong>Location:</strong><br>
                        ${station.AddressInfo.AddressLine1 || ''}<br>
                        ${station.AddressInfo.Town || ''}, 
                        ${station.AddressInfo.StateOrProvince || ''}<br>
                        ${station.AddressInfo.Country?.Title || ''}<br>
                        <small class="text-muted">Lat/Long: ${station.AddressInfo.Latitude}, ${station.AddressInfo.Longitude}</small>
                    </div>

                    <div class="equipment-details mb-3">
                        <strong>Equipment Details:</strong><br>
                        Number of Points: ${connections.length}<br>
                        ${connectionsList}
                    </div>

                    <div class="usage-details mb-3">
                        <strong>Usage Information:</strong><br>
                        Status: <span class="badge bg-${station.StatusType?.IsOperational ? 'success' : 'danger'}">
                            ${station.StatusType?.Title || 'Unknown'}
                        </span><br>
                        ${station.UsageType ? `Usage Type: ${station.UsageType.Title}<br>` : ''}
                        ${station.UsageCost ? `Cost: ${station.UsageCost}<br>` : ''}
                    </div>

                    <div class="operator-details mb-3">
                        <strong>Network/Operator:</strong><br>
                        ${station.OperatorInfo?.Title || 'Unknown'}<br>
                        ${station.OperatorInfo?.WebsiteURL ? 
                            `<a href="${station.OperatorInfo.WebsiteURL}" target="_blank">Visit Website</a>` : 
                            ''}
                    </div>

                    <div class="action-buttons">
                        <button onclick="getDirections(${station.AddressInfo.Latitude}, ${station.AddressInfo.Longitude})" 
                                class="btn btn-sm btn-primary">
                            <i class="fas fa-directions"></i> Get Directions
                        </button>
                        <a href="https://openchargemap.org/site/poi/details/${station.ID}" 
                           target="_blank" 
                           class="btn btn-sm btn-info">
                            <i class="fas fa-info-circle"></i> More Details
                        </a>
                    </div>
                </div>
            `;
        } catch (error) {
            console.error('Error creating popup:', error);
            return `<div class="error">Error loading station details</div>`;
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
        // Default: Telkom University Bandung
        const defaultOrigin = { lat: -6.973265, lng: 107.630539 };
        const origin = currentUserLocation ? `${currentUserLocation.lat},${currentUserLocation.lng}` : `${defaultOrigin.lat},${defaultOrigin.lng}`;
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

    // Load initial data for Jakarta
    loadChargingStations(-6.200000, 106.816666);
</script>

<style>
    .station-popup {
        min-width: 300px;
        max-width: 350px;
    }
    .station-popup .badge {
        margin-right: 5px;
        margin-bottom: 5px;
    }
    .station-popup .action-buttons {
        display: flex;
        gap: 10px;
        justify-content: space-between;
    }
    .connection-item {
        padding: 5px 0;
    }
    .btn-sm {
        padding: 0.25rem 0.5rem;
        font-size: 0.875rem;
        line-height: 1.5;
        border-radius: 0.2rem;
    }
    #status-message {
        font-weight: bold;
    }
    .text-danger {
        color: #dc3545;
    }
    .text-success {
        color: #28a745;
    }
</style>
@endsection
