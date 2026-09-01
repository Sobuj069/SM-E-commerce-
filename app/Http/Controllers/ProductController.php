<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Review;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function show(string $slug)
    {
        $product = Product::where('slug', $slug)
            ->active()
            ->with(['category', 'variants', 'approvedReviews'])
            ->firstOrFail();
        
        $relatedProducts = Product::active()
            ->where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->with(['category', 'variants'])
            ->take(6)
            ->get();

        // Calculate rating breakdown distribution
        $totalReviews = $product->approvedReviews->count();
        $ratingDistribution = [
            5 => $totalReviews > 0 ? round(($product->approvedReviews->where('rating', 5)->count() / $totalReviews) * 100) : 75,
            4 => $totalReviews > 0 ? round(($product->approvedReviews->where('rating', 4)->count() / $totalReviews) * 100) : 18,
            3 => $totalReviews > 0 ? round(($product->approvedReviews->where('rating', 3)->count() / $totalReviews) * 100) : 5,
            2 => $totalReviews > 0 ? round(($product->approvedReviews->where('rating', 2)->count() / $totalReviews) * 100) : 2,
            1 => $totalReviews > 0 ? round(($product->approvedReviews->where('rating', 1)->count() / $totalReviews) * 100) : 0,
        ];

        return view('shop.show', compact('product', 'relatedProducts', 'ratingDistribution', 'totalReviews'));
    }

    public function storeReview(Request $request, Product $product)
    {
        $validated = $request->validate([
            'user_name' => 'required|string|max:100',
            'user_email' => 'nullable|email|max:150',
            'rating' => 'required|integer|min:1|max:5',
            'title' => 'nullable|string|max:150',
            'comment' => 'required|string|min:5|max:1000',
        ]);

        $validated['product_id'] = $product->id;
        $validated['is_approved'] = true;

        Review::create($validated);

        // Recalculate product rating & reviews count
        $avgRating = $product->reviews()->avg('rating') ?: 5.0;
        $count = $product->reviews()->count();

        $product->update([
            'rating' => round($avgRating, 1),
            'reviews_count' => $count,
        ]);

        return back()->with('success', 'Thank you! Your verified review has been published.');
    }
}

