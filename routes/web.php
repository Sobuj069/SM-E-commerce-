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

// Live Chatbot Order Tracking API
Route::post('/api/track-order', function(\Illuminate\Http\Request $request) {
    $orderNumber = trim($request->input('order_number'));
    $order = \App\Models\Order::where('order_number', $orderNumber)->first();
    if ($order) {
        return response()->json([
            'found' => true,
            'order_number' => $order->order_number,
            'status' => ucfirst($order->order_status),
            'courier' => $order->courier_name ? ucfirst($order->courier_name) : 'Pending Dispatch',
            'consignment' => $order->consignment_id ?? 'Will be generated shortly',
            'amount' => '$' . number_format($order->total_amount, 2),
            'date' => $order->created_at->format('M d, Y'),
        ]);
    }
    return response()->json(['found' => false]);
})->name('api.track.order');

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

// Admin Control Panel (Protected by Auth Middleware)
Route::prefix('admin')->name('admin.')->middleware('auth')->group(function () {
    Route::get('/', [AdminController::class, 'dashboard'])->name('dashboard');
    
    // Categories
    Route::get('/categories', [AdminController::class, 'categories'])->name('categories.index');
    Route::post('/categories', [AdminController::class, 'storeCategory'])->name('categories.store');
    Route::delete('/categories/{category}', [AdminController::class, 'deleteCategory'])->name('categories.delete');

    // Brands
    Route::get('/brands', [AdminController::class, 'brands'])->name('brands.index');
    Route::post('/brands', [AdminController::class, 'storeBrand'])->name('brands.store');
    Route::delete('/brands/{brand}', [AdminController::class, 'deleteBrand'])->name('brands.delete');

    // Products & Drops
    Route::get('/products', [AdminController::class, 'products'])->name('products.index');
    Route::get('/products/create', [AdminController::class, 'createProduct'])->name('products.create');
    Route::post('/products', [AdminController::class, 'storeProduct'])->name('products.store');
    Route::get('/products/{product}/edit', [AdminController::class, 'editProduct'])->name('products.edit');
    Route::put('/products/{product}', [AdminController::class, 'updateProduct'])->name('products.update');
    Route::delete('/products/{product}', [AdminController::class, 'deleteProduct'])->name('products.delete');

    // Stocks & Purchases Inflow
    Route::get('/stocks', [AdminController::class, 'stocks'])->name('stocks.index');
    Route::post('/stocks/{product}', [AdminController::class, 'updateStock'])->name('stocks.update');
    Route::get('/purchases', [AdminController::class, 'purchases'])->name('purchases.index');
    Route::post('/purchases', [AdminController::class, 'storePurchase'])->name('purchases.store');

    // Orders & Status Maintainer
    Route::get('/orders', [AdminController::class, 'orders'])->name('orders.index');
    Route::get('/orders/{order}', [AdminController::class, 'showOrder'])->name('orders.show');
    Route::post('/orders/{order}/status', [AdminController::class, 'updateOrderStatus'])->name('orders.status');
    Route::post('/orders/{order}/return', [AdminController::class, 'processCourierReturn'])->name('orders.return');

    // Courier Integration & Panel
    Route::get('/courier', [AdminController::class, 'courier'])->name('courier.index');
    Route::post('/courier/{order}/send', [AdminController::class, 'sendToCourier'])->name('courier.send');
    Route::post('/courier/settings', [AdminController::class, 'saveCourierSettings'])->name('courier.settings');

    // Fraud Checker & Risk Analyzer
    Route::get('/fraud-checker', [AdminController::class, 'fraudChecker'])->name('fraud.index');
    Route::post('/fraud-checker/blacklist', [AdminController::class, 'blacklistAdd'])->name('fraud.blacklist.add');
    Route::delete('/fraud-checker/blacklist/{blacklist}', [AdminController::class, 'blacklistRemove'])->name('fraud.blacklist.remove');

    // Customers, Coupons, Reviews
    Route::get('/customers', [AdminController::class, 'customers'])->name('customers.index');
    Route::get('/coupons', [AdminController::class, 'coupons'])->name('coupons.index');
    Route::post('/coupons', [AdminController::class, 'storeCoupon'])->name('coupons.store');
    Route::delete('/coupons/{coupon}', [AdminController::class, 'deleteCoupon'])->name('coupons.delete');
    Route::get('/reviews', [AdminController::class, 'reviews'])->name('reviews.index');
    Route::post('/reviews/{review}/toggle', [AdminController::class, 'toggleReview'])->name('reviews.toggle');
    Route::delete('/reviews/{review}', [AdminController::class, 'deleteReview'])->name('reviews.delete');
});