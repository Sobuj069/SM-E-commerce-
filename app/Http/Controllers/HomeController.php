<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $categories = Category::where('is_active', true)->withCount('products')->get();
        $featuredProducts = Product::active()->featured()->with('category')->take(8)->get();
        $latestProducts = Product::active()->latest()->with('category')->take(8)->get();
        $deals = Product::active()->whereNotNull('sale_price')->with('category')->take(4)->get();

        return view('home', compact('categories', 'featuredProducts', 'latestProducts', 'deals'));
    }
}
