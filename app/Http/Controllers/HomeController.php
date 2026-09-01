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
        $featuredProducts = Product::active()->featured()->with(['category', 'variants'])->take(8)->get();
        $latestProducts = Product::active()->latest()->with(['category', 'variants'])->take(8)->get();
        $bestSellers = Product::active()->orderByDesc('rating')->orderByDesc('reviews_count')->with(['category', 'variants'])->take(8)->get();
        $deals = Product::active()->whereNotNull('sale_price')->with(['category', 'variants'])->take(4)->get();
        $banners = Banner::where('is_active', true)->get();
        $testimonials = Review::where('is_approved', true)->with('product')->take(6)->get();

        return view('home', compact(
            'categories', 
            'featuredProducts', 
            'latestProducts', 
            'bestSellers', 
            'deals', 
            'banners', 
            'testimonials'
        ));
    }
}

