<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use App\Models\Category;
use App\Models\Product;
use App\Models\Review;

class HomeController extends Controller
{
    public function index()
    {
        $categories = Category::where('is_active', true)->withCount('products')->get();

        // 1. Featured Products
        $featuredProducts = Product::active()
            ->where('is_featured', true)
            ->with(['category', 'variants'])
            ->take(15)
            ->get();
        if ($featuredProducts->isEmpty()) {
            $featuredProducts = Product::active()->with(['category', 'variants'])->take(10)->get();
        }

        // 2. New Arrivals (Dedicated New Arrival Section)
        $newArrivals = Product::active()
            ->where('is_new_arrival', true)
            ->with(['category', 'variants'])
            ->latest()
            ->take(15)
            ->get();
        if ($newArrivals->isEmpty()) {
            $newArrivals = Product::active()->latest()->with(['category', 'variants'])->take(10)->get();
        }

        // 3. Trending Products (Dedicated Trending Section)
        $trendingProducts = Product::active()
            ->where('is_trending', true)
            ->with(['category', 'variants'])
            ->take(15)
            ->get();
        if ($trendingProducts->isEmpty()) {
            $trendingProducts = Product::active()
                ->orderByDesc('rating')
                ->orderByDesc('reviews_count')
                ->with(['category', 'variants'])
                ->take(10)
                ->get();
        }

        // 4. Best Deals / Flash Sale (Dedicated Best Deals Section)
        $bestDeals = Product::active()
            ->where('is_best_deal', true)
            ->with(['category', 'variants'])
            ->take(15)
            ->get();
        if ($bestDeals->isEmpty()) {
            $bestDeals = Product::active()
                ->whereNotNull('sale_price')
                ->with(['category', 'variants'])
                ->take(10)
                ->get();
        }

        // 5. Top Rated Products (Customer Favorites)
        $topRatedProducts = Product::active()
            ->where('rating', '>=', 4.5)
            ->orderByDesc('rating')
            ->orderByDesc('reviews_count')
            ->with(['category', 'variants'])
            ->take(10)
            ->get();

        $banners = Banner::where('is_active', true)->get();
        $testimonials = Review::where('is_approved', true)->with('product')->get()->unique('title')->take(6);

        return view('home', compact(
            'categories',
            'featuredProducts',
            'newArrivals',
            'trendingProducts',
            'bestDeals',
            'topRatedProducts',
            'banners',
            'testimonials'
        ));
    }
}
