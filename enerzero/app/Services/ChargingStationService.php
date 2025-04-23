<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class ChargingStationService
{
    protected $apiKey;
    protected $baseUrl = 'https://api.openchargemap.io/v3';

    public function __construct()
    {
        $this->apiKey = config('services.openchargemap.key');
    }

    public function getNearbyStations($latitude, $longitude, $radius = 10)
    {
        $cacheKey = "charging_stations_{$latitude}_{$longitude}_{$radius}";
        
        return Cache::remember($cacheKey, 3600, function () use ($latitude, $longitude, $radius) {
            $response = Http::withHeaders([
                'X-API-Key' => $this->apiKey
            ])->get($this->baseUrl . '/poi', [
                'latitude' => $latitude,
                'longitude' => $longitude,
                'distance' => $radius,
                'distanceunit' => 'KM',
                'maxresults' => 100,
                'compact' => true,
                'verbose' => false,
                'includecomments' => false,
                'includeconnectiontypes' => true,
                'includeoperatorinfo' => true,
                'includeaddressinfo' => true,
            ]);

            if ($response->successful()) {
                return $response->json();
            }

            return [];
        });
    }

    public function getStationDetails($id)
    {
        $cacheKey = "charging_station_{$id}";
        
        return Cache::remember($cacheKey, 3600, function () use ($id) {
            $response = Http::withHeaders([
                'X-API-Key' => $this->apiKey
            ])->get($this->baseUrl . '/poi/' . $id, [
                'includecomments' => true,
                'includeconnectiontypes' => true,
                'includeoperatorinfo' => true,
                'includeaddressinfo' => true,
            ]);

            if ($response->successful()) {
                return $response->json();
            }

            return null;
        });
    }
} 