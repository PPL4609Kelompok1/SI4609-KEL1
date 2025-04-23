@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-2xl mx-auto">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold">Add New Location</h1>
            <a href="{{ route('maps.index') }}" class="text-blue-500 hover:text-blue-700">
                Back to Map
            </a>
        </div>

        <div class="bg-white rounded-lg shadow-lg p-6">
            <form action="{{ route('maps.store') }}" method="POST">
                @csrf
                
                <div class="mb-4">
                    <label for="name" class="block text-gray-700 text-sm font-bold mb-2">Location Name</label>
                    <input type="text" name="name" id="name" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('name') border-red-500 @enderror" value="{{ old('name') }}" required>
                    @error('name')
                        <p class="text-red-500 text-xs italic">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="description" class="block text-gray-700 text-sm font-bold mb-2">Description</label>
                    <textarea name="description" id="description" rows="3" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('description') border-red-500 @enderror">{{ old('description') }}</textarea>
                    @error('description')
                        <p class="text-red-500 text-xs italic">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Select Location on Map</label>
                    <div id="map" class="w-full h-[400px] rounded-lg mb-2"></div>
                    <p class="text-sm text-gray-500">Click on the map to set the location</p>
                </div>

                <div class="grid grid-cols-2 gap-4 mb-4">
                    <div>
                        <label for="latitude" class="block text-gray-700 text-sm font-bold mb-2">Latitude</label>
                        <input type="number" step="any" name="latitude" id="latitude" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('latitude') border-red-500 @enderror" value="{{ old('latitude') }}" required>
                        @error('latitude')
                            <p class="text-red-500 text-xs italic">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="longitude" class="block text-gray-700 text-sm font-bold mb-2">Longitude</label>
                        <input type="number" step="any" name="longitude" id="longitude" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('longitude') border-red-500 @enderror" value="{{ old('longitude') }}" required>
                        @error('longitude')
                            <p class="text-red-500 text-xs italic">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="flex items-center justify-end">
                    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                        Save Location
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://maps.googleapis.com/maps/api/js?key={{ config('services.google.maps_api_key') }}"></script>
<script>
    let map;
    let marker;

    function initMap() {
        // Default center (can be set to your preferred default location)
        const defaultCenter = { lat: -6.200000, lng: 106.816666 }; // Jakarta coordinates
        
        map = new google.maps.Map(document.getElementById('map'), {
            zoom: 13,
            center: defaultCenter
        });

        // Add click listener to map
        map.addListener('click', function(e) {
            placeMarker(e.latLng);
        });

        // If there are old values, place marker at that location
        const lat = document.getElementById('latitude').value;
        const lng = document.getElementById('longitude').value;
        if (lat && lng) {
            const position = { lat: parseFloat(lat), lng: parseFloat(lng) };
            placeMarker(position);
            map.setCenter(position);
        }
    }

    function placeMarker(location) {
        if (marker) {
            marker.setMap(null);
        }

        marker = new google.maps.Marker({
            position: location,
            map: map,
            draggable: true
        });

        // Update form fields
        document.getElementById('latitude').value = location.lat();
        document.getElementById('longitude').value = location.lng();

        // Add drag end listener
        marker.addListener('dragend', function() {
            const position = marker.getPosition();
            document.getElementById('latitude').value = position.lat();
            document.getElementById('longitude').value = position.lng();
        });
    }

    window.onload = initMap;
</script>
@endpush
@endsection 