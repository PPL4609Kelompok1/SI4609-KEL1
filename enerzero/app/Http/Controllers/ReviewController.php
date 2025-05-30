<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store(Request $request, Product $product)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|max:1000'
        ]);

        $review = new Review();
        $review->user_id = Auth::id();
        $review->product_id = $product->id;
        $review->rating = $request->rating;
        $review->comment = $request->comment;
        $review->save();

        return redirect()->back()->with('success', 'Review berhasil ditambahkan');
    }

    public function show(Review $review)
    {
        return view('reviews.show', compact('review'));
    }

    public function update(Request $request, Review $review)
    {
        if ($review->user_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|max:1000'
        ]);

        $review->update([
            'rating' => $request->rating,
            'comment' => $request->comment
        ]);

        return redirect()->back()->with('success', 'Review berhasil diperbarui');
    }

    public function destroy(Review $review)
    {
        if ($review->user_id !== Auth::id()) {
            abort(403);
        }

        $review->delete();

        return redirect()->back()->with('success', 'Review berhasil dihapus');
    }
}
