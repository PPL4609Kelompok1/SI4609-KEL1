@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-[#E1F5E7] py-8">
    <div class="max-w-4xl mx-auto">
        <div class="bg-white rounded-lg shadow-sm overflow-hidden">
            <!-- Header -->
            <div class="px-6 py-4 bg-gray-50 border-b border-gray-100">
                <div class="flex justify-between items-center">
                    <h1 class="text-xl font-semibold text-gray-800">Add New Favorite Location</h1>
                    <a href="{{ route('maps.index') }}" class="text-blue-500 hover:text-blue-700 flex items-center">
                        <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                        </svg>
                        Back to Map
                    </a>
                </div>
            </div>

            <!-- Content -->
            <div class="p-6">
                <form action="{{ route('maps.store') }}" method="POST" class="space-y-6">
                    @csrf
                    
                    <!-- Location Details -->
                    <div class="grid md:grid-cols-2 gap-6">
                        <div class="space-y-6">
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700">Location Name</label>
                                <input type="text" 
                                       name="name" 
                                       id="name" 
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm @error('name') border-red-500 @enderror" 
                                       value="{{ old('name') }}" 
                                       placeholder="Enter a name for this location"
                                       required>
                                @error('name')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                                <textarea name="description" 
                                          id="description" 
                                          rows="3" 
                                          class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm @error('description') border-red-500 @enderror"
                                          placeholder="Add any notes about this location">{{ old('description') }}</textarea>
                                @error('description')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label for="latitude" class="block text-sm font-medium text-gray-700">Latitude</label>
                                    <input type="number" 
                                           step="any" 
                                           name="latitude" 
                                           id="latitude" 
                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm @error('latitude') border-red-500 @enderror" 
                                           value="{{ old('latitude') }}" 
                                           required>
                                    @error('latitude')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="longitude" class="block text-sm font-medium text-gray-700">Longitude</label>
                                    <input type="number" 
                                           step="any" 
                                           name="longitude" 
                                           id="longitude" 
                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm @error('longitude') border-red-500 @enderror" 
                                           value="{{ old('longitude') }}" 
                                           required>
                                    @error('longitude')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Map Section -->
                        <div class="space-y-2">
                            <label class="block text-sm font-medium text-gray-700">Select Location on Map</label>
                            <div id="map" class="w-full h-[400px] rounded-lg border border-gray-300 shadow-sm"></div>
                            <p class="text-sm text-gray-500">Click anywhere on the map to set the location or drag the marker to adjust</p>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex justify-end space-x-3 pt-4 border-t">
                        <a href="{{ route('maps.index') }}" class="inline-flex justify-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                            Cancel
                        </a>
                        <button type="submit" class="inline-flex justify-center rounded-md border border-transparent bg-blue-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                            Save Location
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function initMap() {
        // Default to Bandung's coordinates
        const defaultCenter = { lat: -6.914744, lng: 107.609810 };
        
        // Create map instance
        const map = new google.maps.Map(document.getElementById('map'), {
            zoom: 13,
            center: defaultCenter,
            mapTypeControl: true,
            streetViewControl: true,
            fullscreenControl: true,
            zoomControl: true,
            styles: [
                {
                    featureType: "poi",
                    elementType: "labels",
                    stylers: [{ visibility: "off" }]
                }
            ]
        });

        let marker = null;
        const latInput = document.getElementById('latitude');
        const lngInput = document.getElementById('longitude');

        // Function to update marker and form fields
        function updateLocation(location) {
            const lat = location.lat();
            const lng = location.lng();
            
            // Update form fields
            latInput.value = lat.toFixed(6);
            lngInput.value = lng.toFixed(6);
            
            // Update or create marker
            if (marker) {
                marker.setPosition(location);
            } else {
                marker = new google.maps.Marker({
                    position: location,
                    map: map,
                    draggable: true,
                    animation: google.maps.Animation.DROP
                });

                // Add drag end listener
                marker.addListener('dragend', function() {
                    updateLocation(marker.getPosition());
                });
            }
        }

        // Add click listener to map
        map.addListener('click', function(e) {
            updateLocation(e.latLng);
        });

        // Initialize marker if coordinates are already set
        const lat = parseFloat(latInput.value);
        const lng = parseFloat(lngInput.value);
        if (!isNaN(lat) && !isNaN(lng)) {
            const position = new google.maps.LatLng(lat, lng);
            updateLocation(position);
            map.setCenter(position);
        }

        // Add input change listeners
        latInput.addEventListener('change', function() {
            const lat = parseFloat(this.value);
            const lng = parseFloat(lngInput.value);
            if (!isNaN(lat) && !isNaN(lng)) {
                updateLocation(new google.maps.LatLng(lat, lng));
            }
        });

        lngInput.addEventListener('change', function() {
            const lat = parseFloat(latInput.value);
            const lng = parseFloat(this.value);
            if (!isNaN(lat) && !isNaN(lng)) {
                updateLocation(new google.maps.LatLng(lat, lng));
            }
        });

        // Try to get user's current location
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(
                function(position) {
                    const pos = {
                        lat: position.coords.latitude,
                        lng: position.coords.longitude
                    };
                    map.setCenter(pos);
                    updateLocation(new google.maps.LatLng(pos.lat, pos.lng));
                },
                function() {
                    // Use default location if geolocation fails
                    console.log('Geolocation failed. Using default location.');
                }
            );
        }
    }

    // Load Google Maps API
    (function loadGoogleMaps() {
        const script = document.createElement('script');
        script.src = `https://maps.googleapis.com/maps/api/js?key={{ config('services.google.maps_api_key') }}&callback=initMap`;
        script.async = true;
        script.defer = true;
        document.head.appendChild(script);
    })();
</script>
@endpush
@endsection 