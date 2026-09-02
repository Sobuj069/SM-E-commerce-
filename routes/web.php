<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\Admin\AdminController;
use Illuminate\Support\Facades\Route;

// Home & Catalog
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/shop', [ShopController::class, 'index'])->name('shop.index');
Route::get('/product/{slug}', [ProductController::class, 'show'])->name('product.show');
Route::post('/product/{product}/review', [ProductController::class, 'storeReview'])->name('product.review');
Route::post('/newsletter/subscribe', function(\Illuminate\Http\Request $request) {
    $request->validate(['email' => 'required|email']);
    return back()->with('success', 'Thanks for subscribing! Use code SM20 at checkout for 20% off.');
})->name('newsletter.subscribe');

// Shopping Cart & Coupons
Route::prefix('cart')->name('cart.')->group(function () {
    Route::get('/', [CartController::class, 'index'])->name('index');
    Route::post('/add/{product}', [CartController::class, 'add'])->name('add');
    Route::post('/update/{id}', [CartController::class, 'update'])->name('update');
    Route::post('/remove/{id}', [CartController::class, 'remove'])->name('remove');
    Route::post('/clear', [CartController::class, 'clear'])->name('clear');
    Route::post('/coupon/apply', [CartController::class, 'applyCoupon'])->name('coupon.apply');
    Route::post('/coupon/remove', [CartController::class, 'removeCoupon'])->name('coupon.remove');
});

// Checkout & Orders
Route::prefix('checkout')->name('checkout.')->group(function () {
    Route::get('/', [CheckoutController::class, 'index'])->name('index');
    Route::post('/process', [CheckoutController::class, 'store'])->name('store');
    Route::get('/success/{orderNumber}', [CheckoutController::class, 'success'])->name('success');
});

// Admin Authentication (Metronic Login & Logout)
Route::get('/admin/login', [AdminController::class, 'loginView'])->name('admin.login');
Route::post('/admin/login', [AdminController::class, 'loginPost'])->name('admin.login.post');
Route::post('/admin/logout', [AdminController::class, 'logout'])->name('admin.logout');

// Admin Control Panel (Metronic Tailwind Demo 1 Dark Sidebar)
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminController::class, 'dashboard'])->name('dashboard');
    
    // Products
    Route::get('/products', [AdminController::class, 'products'])->name('products.index');
    Route::get('/products/create', [AdminController::class, 'createProduct'])->name('products.create');
    Route::post('/products', [AdminController::class, 'storeProduct'])->name('products.store');
    Route::delete('/products/{product}', [AdminController::class, 'deleteProduct'])->name('products.delete');

    // Orders
    Route::get('/orders', [AdminController::class, 'orders'])->name('orders.index');
    Route::get('/orders/{order}', [AdminController::class, 'showOrder'])->name('orders.show');
    Route::post('/orders/{order}/status', [AdminController::class, 'updateOrderStatus'])->name('orders.status');

    // Coupons
    Route::get('/coupons', [AdminController::class, 'coupons'])->name('coupons.index');
    Route::post('/coupons', [AdminController::class, 'storeCoupon'])->name('coupons.store');
    Route::delete('/coupons/{coupon}', [AdminController::class, 'deleteCoupon'])->name('coupons.delete');

    // Reviews
    Route::get('/reviews', [AdminController::class, 'reviews'])->name('reviews.index');
    Route::post('/reviews/{review}/toggle', [AdminController::class, 'toggleReview'])->name('reviews.toggle');
    Route::delete('/reviews/{review}', [AdminController::class, 'deleteReview'])->name('reviews.delete');
});