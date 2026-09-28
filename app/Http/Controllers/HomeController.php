<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\Banner;
use App\Models\Review;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $categories = Category::where('is_active', true)->withCount('products')->get();
        $featuredProducts = Product::active()->featured()->with(['category', 'variants'])->take(12)->get();
        $latestProducts = Product::active()->latest()->with(['category', 'variants'])->take(12)->get();
        $bestSellers = Product::active()->orderByDesc('rating')->orderByDesc('reviews_count')->with(['category', 'variants'])->take(12)->get();
        $deals = Product::active()->whereNotNull('sale_price')->with(['category', 'variants'])->take(8)->get();
        $banners = Banner::where('is_active', true)->get();
        $testimonials = Review::where('is_approved', true)->with('product')->get()->unique('title')->take(6);

        // Tech & Electronics Products
        $techSlugs = ['smartphones', 'laptops-pc', 'audio-gadgets', 'smartwatches', 'tech-accessories'];
        $techProducts = Product::active()
            ->whereHas('category', function($q) use ($techSlugs) {
                $q->whereIn('slug', $techSlugs);
            })
            ->with(['category', 'variants'])
            ->take(8)
            ->get();

        // Fashion & Apparel Products
        $fashionSlugs = ['women', 'men', 'seamless', 'hoodies-sweats', 'accessories'];
        $fashionProducts = Product::active()
            ->whereHas('category', function($q) use ($fashionSlugs) {
                $q->whereIn('slug', $fashionSlugs);
            })
            ->with(['category', 'variants'])
            ->take(8)
            ->get();

        return view('home', compact(
            'categories', 
            'featuredProducts', 
            'latestProducts', 
            'bestSellers', 
            'deals', 
            'banners', 
            'testimonials',
            'techProducts',
            'fashionProducts'
        ));
    }
}
