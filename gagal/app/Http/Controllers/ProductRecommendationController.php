<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductRecommendationController extends Controller
{
    public function getRecommendations(Request $request)
    {
        // Dummy data for products
        $dummyProducts = [
            [
                'id' => 1,
                'name' => 'Solar Panel 100W',
                'description' => 'High efficiency solar panel with 100W output',
                'price' => 1500000,
                'category' => 'solar',
                'energy_efficiency_rating' => 4,
                'image_url' => 'https://via.placeholder.com/300x200?text=Solar+Panel',
                'marketplace_url' => '#'
            ],
            [
                'id' => 2,
                'name' => 'Wind Turbine 500W',
                'description' => 'Compact wind turbine suitable for residential use',
                'price' => 2500000,
                'category' => 'wind',
                'energy_efficiency_rating' => 3,
                'image_url' => 'https://via.placeholder.com/300x200?text=Wind+Turbine',
                'marketplace_url' => '#'
            ],
            [
                'id' => 3,
                'name' => 'Solar Panel 200W',
                'description' => 'Premium solar panel with 200W output',
                'price' => 2800000,
                'category' => 'solar',
                'energy_efficiency_rating' => 5,
                'image_url' => 'https://via.placeholder.com/300x200?text=Premium+Solar',
                'marketplace_url' => '#'
            ]
        ];

        // Get the consumption pattern from the request or use a default
        $pattern = $request->input('consumption_pattern', 'medium');

        // Convert dummy data to Product objects
        $recommendations = collect($dummyProducts)->map(function($product) {
            return (object) $product;
        });

        return view('products.recommendations', [
            'recommendations' => $recommendations,
            'pattern' => $pattern
        ]);
    }
} 