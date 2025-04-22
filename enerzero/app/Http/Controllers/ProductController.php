<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
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
}
