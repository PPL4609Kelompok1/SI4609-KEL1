<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductReview;
use Illuminate\Http\Request;

class ProductReviewController extends Controller
{
    public function store(Request $request, Product $product)
    {
        if (!auth()->check()) {
            return redirect()->back()->with('error', 'Anda harus login untuk memberikan ulasan.');
        }

        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|max:1000',
        ]);

        $username = auth()->user()->name ?? auth()->user()->username;
        
        if (empty($username)) {
            return redirect()->back()->with('error', 'Nama pengguna tidak ditemukan. Silakan periksa profil Anda.');
        }

        $review = new ProductReview([
            'username' => $username,
            'rating' => $request->rating,
            'comment' => $request->comment,
        ]);

        $product->reviews()->save($review);

        return redirect()->back()->with('success', 'Review submitted successfully!');
    }

    public function edit(ProductReview $review)
    {
        return view('reviews.edit', compact('review'));
    }

    public function update(Request $request, ProductReview $review)
    {
        $validated = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|min:10'
        ]);

        $review->update($validated);

        return redirect()->route('products.show', $review->product_id)
            ->with('success', 'Review updated successfully!');
    }

    public function destroy(ProductReview $review)
    {
        $productId = $review->product_id;
        $review->delete();

        return redirect()->route('products.show', $productId)
            ->with('success', 'Review deleted successfully!');
    }
} 