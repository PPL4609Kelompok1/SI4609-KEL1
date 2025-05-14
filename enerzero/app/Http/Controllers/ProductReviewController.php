<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductReview;
use Illuminate\Http\Request;

class ProductReviewController extends Controller
{
    public function store(Request $request, Product $product)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|max:1000',
        ]);

        $review = new ProductReview([
            'username' => 'DefaultUser', // Hardcoded username
            'rating' => $request->rating,
            'comment' => $request->comment,
        ]);

        $product->reviews()->save($review);

        return redirect()->back()->with('success', 'Review submitted successfully!');
    }
} 