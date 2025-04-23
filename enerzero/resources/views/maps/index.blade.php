@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Map Locations</h1>
        <a href="{{ route('maps.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
            Add New Location
        </a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Map Display -->
        <div class="bg-white rounded-lg shadow-lg p-4">
            <div id="map" style="width: 100%; height: 500px; position: relative;"></div>
            <div id="map-error" class="hidden mt-2 text-red-500 text-sm"></div>
        </div>

        <!-- Locations List -->
        <div class="bg-white rounded-lg shadow-lg p-4">
            <h2 class="text-xl font-semibold mb-4">Saved Locations</h2>
            <div class="space-y-4">
                @foreach($maps as $map)
                <div class="border rounded-lg p-4 hover:bg-gray-50">
                    <div class="flex justify-between items-start">
                        <div>
                            <h3 class="font-semibold">{{ $map->name }}</h3>
                            <p class="text-gray-600 text-sm">{{ $map->description }}</p>
                            <p class="text-gray-500 text-sm">Lat: {{ $map->latitude }}, Long: {{ $map->longitude }}</p>
                            @if(isset($stations[$map->id]) && count($stations[$map->id]) > 0)
                                <p class="text-green-600 text-sm mt-2">
                                    {{ count($stations[$map->id]) }} charging stations nearby
                                </p>
                            @endif
                        </div>
                        <div class="flex space-x-2">
                            <a href="{{ route('maps.edit', $map) }}" class="text-blue-500 hover:text-blue-700">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                </svg>
                            </a>
                            <form action="{{ route('maps.destroy', $map) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500 hover:text-red-700" onclick="return confirm('Are you sure?')">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function showMapError(message) {
        const errorDiv = document.getElementById('map-error');
        errorDiv.textContent = message;
        errorDiv.classList.remove('hidden');
    }

    function initMap() {
        try {
            const mapElement = document.getElementById('map');
            if (!mapElement) {
                showMapError('Map container not found');
                return;
            }

            const map = new google.maps.Map(mapElement, {
                zoom: 2,
                center: { lat: 0, lng: 0 },
                mapTypeControl: true,
                streetViewControl: true,
                fullscreenControl: true
            });

            const locations = @json($maps);
            const stations = @json($stations);
            const markers = [];
            const infoWindows = [];

            // Add markers for saved locations
            locations.forEach(location => {
                const marker = new google.maps.Marker({
                    position: { 
                        lat: parseFloat(location.latitude), 
                        lng: parseFloat(location.longitude) 
                    },
                    map: map,
                    title: location.name,
                    icon: {
                        url: 'http://maps.google.com/mapfiles/ms/icons/blue-dot.png'
                    }
                });

                const infoWindow = new google.maps.InfoWindow({
                    content: `
                        <div class="p-2">
                            <h3 class="font-bold">${location.name}</h3>
                            <p>${location.description || ''}</p>
                        </div>
                    `
                });

                marker.addListener('click', () => {
                    infoWindows.forEach(iw => iw.close());
                    infoWindow.open(map, marker);
                });

                markers.push(marker);
                infoWindows.push(infoWindow);
            });

            // Add markers for charging stations
            Object.entries(stations).forEach(([locationId, locationStations]) => {
                locationStations.forEach(station => {
                    const marker = new google.maps.Marker({
                        position: { 
                            lat: parseFloat(station.AddressInfo.Latitude), 
                            lng: parseFloat(station.AddressInfo.Longitude) 
                        },
                        map: map,
                        title: station.AddressInfo.Title,
                        icon: {
                            url: 'http://maps.google.com/mapfiles/ms/icons/green-dot.png'
                        }
                    });

                    const connections = station.Connections
                        .map(conn => `${conn.ConnectionType.Title} (${conn.PowerKW || 'N/A'} kW)`)
                        .join('<br>');

                    const infoWindow = new google.maps.InfoWindow({
                        content: `
                            <div class="p-2">
                                <h3 class="font-bold">${station.AddressInfo.Title}</h3>
                                <p class="text-sm">${station.AddressInfo.AddressLine1 || ''}</p>
                                <p class="text-sm">${station.AddressInfo.Town || ''}</p>
                                <div class="mt-2">
                                    <strong>Connections:</strong><br>
                                    ${connections}
                                </div>
                                <button onclick="getStationDetails(${station.ID})" class="mt-2 text-blue-500 hover:text-blue-700 text-sm">
                                    View Details
                                </button>
                            </div>
                        `
                    });

                    marker.addListener('click', () => {
                        infoWindows.forEach(iw => iw.close());
                        infoWindow.open(map, marker);
                    });

                    markers.push(marker);
                    infoWindows.push(infoWindow);
                });
            });

            // Fit bounds to show all markers
            if (markers.length > 0) {
                const bounds = new google.maps.LatLngBounds();
                markers.forEach(marker => bounds.extend(marker.getPosition()));
                map.fitBounds(bounds);
            }
        } catch (error) {
            console.error('Error initializing map:', error);
            showMapError('Error loading map: ' + error.message);
        }
    }

    async function getStationDetails(id) {
        try {
            const response = await fetch(`/maps/stations/${id}`);
            const station = await response.json();
            
            // Create and show a modal with station details
            const modal = document.createElement('div');
            modal.className = 'fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center';
            modal.innerHTML = `
                <div class="bg-white p-6 rounded-lg max-w-lg w-full mx-4">
                    <h2 class="text-xl font-bold mb-4">${station.AddressInfo.Title}</h2>
                    <div class="space-y-2">
                        <p><strong>Address:</strong> ${station.AddressInfo.AddressLine1}</p>
                        <p><strong>Town:</strong> ${station.AddressInfo.Town}</p>
                        <p><strong>State:</strong> ${station.AddressInfo.StateOrProvince}</p>
                        <p><strong>Country:</strong> ${station.AddressInfo.Country.Title}</p>
                        <h3 class="font-bold mt-4">Connections</h3>
                        <div class="space-y-2">
                            ${station.Connections.map(conn => `
                                <div class="border p-2 rounded">
                                    <p><strong>Type:</strong> ${conn.ConnectionType.Title}</p>
                                    <p><strong>Power:</strong> ${conn.PowerKW || 'N/A'} kW</p>
                                    <p><strong>Status:</strong> ${conn.StatusType ? conn.StatusType.Title : 'Unknown'}</p>
                                </div>
                            `).join('')}
                        </div>
                    </div>
                    <button onclick="this.closest('.fixed').remove()" class="mt-4 bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-700">
                        Close
                    </button>
                </div>
            `;
            document.body.appendChild(modal);
        } catch (error) {
            console.error('Error fetching station details:', error);
        }
    }

    // Load Google Maps API
    function loadGoogleMaps() {
        const script = document.createElement('script');
        script.src = `https://maps.googleapis.com/maps/api/js?key={{ config('services.google.maps_api_key') }}&callback=initMap`;
        script.async = true;
        script.defer = true;
        script.onerror = function() {
            showMapError('Failed to load Google Maps API');
        };
        document.head.appendChild(script);
    }

    // Initialize map when the page loads
    window.onload = loadGoogleMaps;
</script>
@endpush
@endsection 