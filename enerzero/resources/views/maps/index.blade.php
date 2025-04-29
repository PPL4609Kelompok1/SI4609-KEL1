@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Map Locations</h1>
        <a href="{{ route('maps.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
            Add New Location
        </a>
    </div>

    @if(isset($error))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
            <strong class="font-bold">Error!</strong>
            <span class="block sm:inline">{{ $error }}</span>
        </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Map Display -->
        <div class="bg-white rounded-lg shadow-lg p-4">
            <div id="map" style="width: 100%; height: 500px; position: relative; background-color: #f0f0f0;"></div>
            <div id="map-error" class="hidden mt-2 text-red-500 text-sm"></div>
            <div id="map-debug" class="mt-2 text-gray-500 text-sm"></div>
            <div id="map-status" class="mt-2 text-blue-500 text-sm"></div>
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
                            @else
                                <p class="text-gray-500 text-sm mt-2">
                                    No charging stations found nearby
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
        console.error('Map Error:', message);
    }

    function showMapDebug(message) {
        const debugDiv = document.getElementById('map-debug');
        debugDiv.textContent = message;
        console.log('Map Debug:', message);
    }

    function showMapStatus(message) {
        const statusDiv = document.getElementById('map-status');
        statusDiv.textContent = message;
        console.log('Map Status:', message);
    }

    function initMap() {
        try {
            showMapStatus('Initializing map...');
            
            const mapElement = document.getElementById('map');
            if (!mapElement) {
                showMapError('Map container not found');
                return;
            }

            const map = new google.maps.Map(mapElement, {
                zoom: 12,
                center: { lat: -6.914744, lng: 107.609810 }, // Centered on Bandung
                mapTypeControl: true,
                streetViewControl: true,
                fullscreenControl: true,
                zoomControl: true
            });

            const locations = @json($maps);
            const stations = @json($stations);
            showMapDebug(`Found ${locations.length} locations and ${Object.keys(stations).length} station groups`);

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
                if (!Array.isArray(locationStations)) {
                    showMapDebug(`Invalid stations data for location ${locationId}`);
                    return;
                }

                locationStations.forEach(station => {
                    if (!station.AddressInfo || !station.AddressInfo.Latitude || !station.AddressInfo.Longitude) {
                        showMapDebug('Invalid station data: missing coordinates');
                        return;
                    }

                    const marker = new google.maps.Marker({
                        position: { 
                            lat: parseFloat(station.AddressInfo.Latitude), 
                            lng: parseFloat(station.AddressInfo.Longitude) 
                        },
                        map: map,
                        title: station.AddressInfo.Title || 'Unknown Station',
                        icon: {
                            url: 'http://maps.google.com/mapfiles/ms/icons/green-dot.png'
                        }
                    });

                    const connections = station.Connections && Array.isArray(station.Connections)
                        ? station.Connections
                            .map(conn => `${conn.ConnectionType?.Title || 'Unknown'} (${conn.PowerKW || 'N/A'} kW)`)
                            .join('<br>')
                        : 'No connection information available';

                    const infoWindow = new google.maps.InfoWindow({
                        content: `
                            <div class="p-2">
                                <h3 class="font-bold">${station.AddressInfo.Title || 'Unknown Station'}</h3>
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
                showMapStatus(`Map initialized with ${markers.length} markers`);
            } else {
                showMapStatus('Map initialized but no markers to display');
            }
        } catch (error) {
            console.error('Error initializing map:', error);
            showMapError('Error initializing map: ' + error.message);
        }
    }

    // Load Google Maps API
    (function loadGoogleMaps() {
        const apiKey = 'AIzaSyCHyUYFBkjES-mwcnFsyKzXcQSvNz8TBtc';
        showMapDebug('Loading Google Maps API...');
        
        const script = document.createElement('script');
        script.src = `https://maps.googleapis.com/maps/api/js?key=${apiKey}&callback=initMap`;
        script.async = true;
        script.defer = true;
        
        script.onerror = function() {
            showMapError('Failed to load Google Maps API. Please check if your API key is valid and has the correct permissions.');
        };

        script.onload = function() {
            showMapStatus('Google Maps API loaded successfully');
        };

        document.head.appendChild(script);
    })();
</script>
@endpush
@endsection 