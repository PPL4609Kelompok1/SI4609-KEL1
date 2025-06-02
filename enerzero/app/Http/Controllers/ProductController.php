<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Storage;
use App\Models\Review;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $query = Product::query()->with('reviews');
    
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%');
        }
    
        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }
    
        $products = $query->paginate(6);
    
        // If no products found and no search/filter applied, show all products
        if ($products->isEmpty() && !$request->filled('search') && !$request->filled('category')) {
            $products = Product::with('reviews')->paginate(6);
        }
    
        return view('products.index', compact('products'));
    }

    public function show(Product $product, Request $request)
    {
        $product->load('reviews');

        $user = Auth::user();

        // Dummy data for recommendations
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

        // Convert dummy data to Product objects
        $recommendations = collect($dummyProducts)->map(function($product) {
            return (object) $product;
        });
        return view('products.show', compact('product', 'recommendations', 'user'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048', // 2MB max size
        ]);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->storeAs('public/products', $imageName);
            $validated['image'] = 'products/' . $imageName;
        }

        Product::create($validated);

        return redirect()->route('products.index')
            ->with('success', 'Product created successfully.');
    }

    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048', // 2MB max size
        ]);

        if ($request->hasFile('image')) {
            // Delete old image
            if ($product->image) {
                Storage::delete('public/' . $product->image);
            }
            
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->storeAs('public/products', $imageName);
            $validated['image'] = 'products/' . $imageName;
        }

        $product->update($validated);

        return redirect()->route('products.index')
            ->with('success', 'Product updated successfully.');
    }
}
