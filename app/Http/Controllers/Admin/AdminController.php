<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\Category;
use App\Models\Brand;
use App\Models\Purchase;
use App\Models\CourierSetting;
use App\Models\FraudBlacklist;
use App\Models\Coupon;
use App\Models\Review;
use App\Models\User;
use App\Services\CourierService;
use App\Services\FraudService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    // ==========================================
    // 1. AUTHENTICATION
    // ==========================================
    public function loginView()
    {
        if (Auth::check()) {
            return redirect()->route('admin.dashboard');
        }
        return view('admin.auth.login');
    }

    public function loginPost(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $remember = $request->boolean('remember');

        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();
            return redirect()->intended(route('admin.dashboard'))->with('success', 'Welcome to SM Shop Admin Dashboard!');
        }

        return back()->withErrors([
            'email' => 'Invalid email or password. Please verify your admin credentials.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('admin.login')->with('success', 'You have been logged out securely.');
    }

    // ==========================================
    // 2. EXECUTIVE DASHBOARD
    // ==========================================
    public function dashboard()
    {
        $totalRevenue = Order::where('payment_status', '!=', 'failed')->sum('total_amount');
        $totalOrders = Order::count();
        $totalProducts = Product::count();
        $totalCustomers = User::count();

        $recentOrders = Order::latest()->take(6)->get();
        $topProducts = Product::orderByDesc('reviews_count')->take(5)->get();

        // 7-day revenue trend data
        $chartDates = [];
        $chartRevenue = [];
        $chartOrders = [];

        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i)->format('Y-m-d');
            $chartDates[] = now()->subDays($i)->format('M d');
            
            $dayRev = Order::whereDate('created_at', $date)->sum('total_amount');
            $dayOrders = Order::whereDate('created_at', $date)->count();

            $chartRevenue[] = (float) $dayRev;
            $chartOrders[] = $dayOrders;
        }

        // Order Status Distribution
        $statusCounts = [
            'pending' => Order::where('order_status', 'pending')->count(),
            'processing' => Order::where('order_status', 'processing')->count(),
            'shipped' => Order::where('order_status', 'shipped')->count(),
            'delivered' => Order::where('order_status', 'delivered')->count(),
        ];

        return view('admin.dashboard', compact(
            'totalRevenue',
            'totalOrders',
            'totalProducts',
            'totalCustomers',
            'recentOrders',
            'topProducts',
            'chartDates',
            'chartRevenue',
            'chartOrders',
            'statusCounts'
        ));
    }

    // ==========================================
    // 3. CATEGORIES MANAGEMENT (Category, Subcategory, Child Category)
    // ==========================================
    public function categories()
    {
        $categories = Category::with(['parent.parent'])->withCount('products')->latest()->get();
        $mainCategories = Category::whereNull('parent_id')->orderBy('name')->get();
        $subCategories = Category::whereNotNull('parent_id')->with('parent')->orderBy('name')->get();
        $parentCategories = Category::with('parent')->orderBy('name')->get();
        return view('admin.categories.index', compact('categories', 'mainCategories', 'subCategories', 'parentCategories'));
    }

    public function storeCategory(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'parent_id' => 'nullable|exists:categories,id',
            'image' => 'nullable|string',
            'image_file' => 'nullable|image|mimes:jpeg,png,jpg,webp,svg|max:4096',
            'description' => 'nullable|string',
        ]);

        if ($request->hasFile('image_file')) {
            $path = $request->file('image_file')->store('uploads/categories', 'public');
            $data['image'] = '/storage/' . $path;
        }

        $data['slug'] = Str::slug($data['name']);
        if (Category::where('slug', $data['slug'])->exists()) {
            $data['slug'] .= '-' . Str::random(4);
        }

        unset($data['image_file']);
        Category::create($data);

        return redirect()->route('admin.categories.index')->with('success', 'Category / Subcategory registered successfully!');
    }

    public function deleteCategory(Category $category)
    {
        $category->delete();
        return redirect()->route('admin.categories.index')->with('success', 'Category removed successfully.');
    }

    // ==========================================
    // 4. BRANDS MANAGEMENT
    // ==========================================
    public function brands()
    {
        $brands = Brand::withCount('products')->latest()->get();
        return view('admin.brands.index', compact('brands'));
    }

    public function storeBrand(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255|unique:brands,name',
            'logo' => 'nullable|string',
            'logo_file' => 'nullable|image|mimes:jpeg,png,jpg,webp,svg|max:4096',
            'description' => 'nullable|string',
        ]);

        if ($request->hasFile('logo_file')) {
            $path = $request->file('logo_file')->store('uploads/brands', 'public');
            $data['logo'] = '/storage/' . $path;
        }

        $data['slug'] = Str::slug($data['name']);
        $data['is_active'] = true;
        unset($data['logo_file']);
        Brand::create($data);

        return redirect()->route('admin.brands.index')->with('success', 'Activewear brand registered successfully with logo!');
    }

    public function deleteBrand(Brand $brand)
    {
        $brand->delete();
        return redirect()->route('admin.brands.index')->with('success', 'Brand removed successfully.');
    }

    // ==========================================
    // 5. PRODUCTS & CATALOG (MULTIPLE IMAGES SUPPORT)
    // ==========================================
    public function products()
    {
        $products = Product::with(['category', 'brand'])->latest()->paginate(10);
        return view('admin.products.index', compact('products'));
    }

    public function createProduct()
    {
        $categories = Category::with('parent')->get();
        $brands = Brand::all();
        return view('admin.products.create', compact('categories', 'brands'));
    }

    public function storeProduct(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'brand_id' => 'nullable|exists:brands,id',
            'price' => 'required|numeric|min:0',
            'sale_price' => 'nullable|numeric|min:0',
            'sku' => 'nullable|string|max:50',
            'stock' => 'required|integer|min:0',
            'image' => 'nullable|string',
            'image_file' => 'nullable|image|mimes:jpeg,png,jpg,webp,avif|max:5120',
            'gallery_files.*' => 'nullable|image|mimes:jpeg,png,jpg,webp,avif|max:5120',
            'gallery_urls' => 'nullable|array',
            'gallery_urls.*' => 'nullable|string',
            'short_description' => 'required|string|max:500',
            'description' => 'nullable|string',
            'is_featured' => 'nullable|boolean',
        ]);

        // 1. Handle Primary Image
        if ($request->hasFile('image_file')) {
            $path = $request->file('image_file')->store('uploads/products', 'public');
            $data['image'] = '/storage/' . $path;
        } elseif (empty($data['image'])) {
            $data['image'] = 'https://images.unsplash.com/photo-1518611012118-696072aa579a?w=800';
        }

        // 2. Handle Multiple Gallery Images
        $galleryImages = [];
        if ($request->hasFile('gallery_files')) {
            foreach ($request->file('gallery_files') as $file) {
                if ($file && $file->isValid()) {
                    $gPath = $file->store('uploads/products/gallery', 'public');
                    $galleryImages[] = '/storage/' . $gPath;
                }
            }
        }
        if (!empty($data['gallery_urls']) && is_array($data['gallery_urls'])) {
            foreach ($data['gallery_urls'] as $url) {
                $trimmed = trim($url);
                if (!empty($trimmed)) {
                    $galleryImages[] = $trimmed;
                }
            }
        }
        $data['gallery_images'] = $galleryImages;

        $data['slug'] = Str::slug($data['name']) . '-' . Str::random(5);
        $data['is_featured'] = $request->has('is_featured');
        $data['is_active'] = true;

        unset($data['image_file'], $data['gallery_files'], $data['gallery_urls']);
        $product = Product::create($data);

        // 3. Save Product Size & Color Variants
        $variantsData = $request->input('variants', []);
        if (is_array($variantsData) && count($variantsData) > 0) {
            foreach ($variantsData as $var) {
                if (!empty($var['size']) || !empty($var['color']) || !empty($var['name'])) {
                    $name = !empty($var['name']) ? $var['name'] : trim(($var['color'] ?? '') . ' ' . ($var['size'] ?? ''));
                    $product->variants()->create([
                        'name' => $name ?: 'Standard',
                        'size' => $var['size'] ?? null,
                        'color' => $var['color'] ?? null,
                        'sku' => $var['sku'] ?? null,
                        'price' => !empty($var['price']) ? (float)$var['price'] : null,
                        'stock' => isset($var['stock']) && $var['stock'] !== '' ? (int)$var['stock'] : 10,
                    ]);
                }
            }
        }

        return redirect()->route('admin.products.index')->with('success', 'Activewear drop with sizes, colors, and multiple gallery images published successfully!');
    }

    public function editProduct(Product $product)
    {
        $product->load('variants');
        $categories = Category::with('parent')->get();
        $brands = Brand::all();
        return view('admin.products.edit', compact('product', 'categories', 'brands'));
    }

    public function updateProduct(Request $request, Product $product)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'brand_id' => 'nullable|exists:brands,id',
            'price' => 'required|numeric|min:0',
            'sale_price' => 'nullable|numeric|min:0',
            'sku' => 'nullable|string|max:50',
            'stock' => 'required|integer|min:0',
            'image' => 'nullable|string',
            'image_file' => 'nullable|image|mimes:jpeg,png,jpg,webp,avif|max:5120',
            'existing_gallery' => 'nullable|array',
            'gallery_files.*' => 'nullable|image|mimes:jpeg,png,jpg,webp,avif|max:5120',
            'gallery_urls' => 'nullable|array',
            'gallery_urls.*' => 'nullable|string',
            'short_description' => 'required|string|max:500',
            'description' => 'nullable|string',
            'is_featured' => 'nullable|boolean',
            'is_active' => 'nullable|boolean',
        ]);

        // 1. Primary Image Update
        if ($request->hasFile('image_file')) {
            $path = $request->file('image_file')->store('uploads/products', 'public');
            $data['image'] = '/storage/' . $path;
        } elseif (empty($data['image'])) {
            $data['image'] = $product->image;
        }

        // 2. Manage Multiple Gallery Images (Retain kept + add new)
        $galleryImages = is_array($request->input('existing_gallery')) ? $request->input('existing_gallery') : [];

        if ($request->hasFile('gallery_files')) {
            foreach ($request->file('gallery_files') as $file) {
                if ($file && $file->isValid()) {
                    $gPath = $file->store('uploads/products/gallery', 'public');
                    $galleryImages[] = '/storage/' . $gPath;
                }
            }
        }

        if (!empty($data['gallery_urls']) && is_array($data['gallery_urls'])) {
            foreach ($data['gallery_urls'] as $url) {
                $trimmed = trim($url);
                if (!empty($trimmed)) {
                    $galleryImages[] = $trimmed;
                }
            }
        }
        $data['gallery_images'] = array_values(array_filter($galleryImages));

        $data['is_featured'] = $request->has('is_featured');
        $data['is_active'] = $request->has('is_active');

        unset($data['image_file'], $data['gallery_files'], $data['gallery_urls'], $data['existing_gallery']);
        $product->update($data);

        // 3. Synchronize Size & Color Variants
        if ($request->has('variants')) {
            $variantsData = $request->input('variants', []);
            $product->variants()->delete();
            if (is_array($variantsData)) {
                foreach ($variantsData as $var) {
                    if (!empty($var['size']) || !empty($var['color']) || !empty($var['name'])) {
                        $name = !empty($var['name']) ? $var['name'] : trim(($var['color'] ?? '') . ' ' . ($var['size'] ?? ''));
                        $product->variants()->create([
                            'name' => $name ?: 'Standard',
                            'size' => $var['size'] ?? null,
                            'color' => $var['color'] ?? null,
                            'sku' => $var['sku'] ?? null,
                            'price' => !empty($var['price']) ? (float)$var['price'] : null,
                            'stock' => isset($var['stock']) && $var['stock'] !== '' ? (int)$var['stock'] : 10,
                        ]);
                    }
                }
            }
        }

        return redirect()->route('admin.products.index')->with('success', "Activewear drop '{$product->name}' with variants & gallery updated successfully!");
    }

    public function deleteProduct(Product $product)
    {
        $product->delete();
        return redirect()->route('admin.products.index')->with('success', 'Product removed successfully.');
    }

    // ==========================================
    // 6. PRODUCT STOCK & PURCHASES INFLOW
    // ==========================================
    public function stocks()
    {
        $products = Product::with('category')->latest()->paginate(15);
        $lowStockCount = Product::where('stock', '<=', 5)->count();
        $outOfStockCount = Product::where('stock', '<=', 0)->count();
        $totalStockValue = Product::sum(\DB::raw('price * stock'));

        return view('admin.stocks.index', compact('products', 'lowStockCount', 'outOfStockCount', 'totalStockValue'));
    }

    public function updateStock(Request $request, Product $product)
    {
        $request->validate(['stock' => 'required|integer|min:0']);
        $product->update(['stock' => $request->stock]);

        return back()->with('success', "Stock inventory for {$product->name} updated to {$request->stock} units.");
    }

    public function purchases()
    {
        $purchases = Purchase::with('product')->latest()->paginate(12);
        $products = Product::all();
        $totalPurchasedValue = Purchase::sum('total_cost');

        return view('admin.purchases.index', compact('purchases', 'products', 'totalPurchasedValue'));
    }

    public function storePurchase(Request $request)
    {
        $data = $request->validate([
            'supplier_name' => 'required|string|max:255',
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'unit_cost' => 'required|numeric|min:0',
            'purchase_date' => 'required|date',
            'invoice_no' => 'nullable|string|max:100',
            'notes' => 'nullable|string',
        ]);

        $data['purchase_number'] = 'PO-' . strtoupper(Str::random(6));
        $data['total_cost'] = $data['quantity'] * $data['unit_cost'];

        $purchase = Purchase::create($data);

        // Automatically increase product stock!
        $product = Product::find($data['product_id']);
        $product->increment('stock', $data['quantity']);

        return redirect()->route('admin.purchases.index')->with('success', "Purchase {$purchase->purchase_number} recorded! +{$data['quantity']} units added to stock.");
    }

    // ==========================================
    // 7. WEB ORDERS & STATUS MAINTAINER
    // ==========================================
    public function orders(Request $request)
    {
        $status = $request->get('status', 'all');
        $query = Order::latest();

        if ($status !== 'all') {
            $query->where('order_status', $status);
        }

        $orders = $query->paginate(15);
        $statusTotals = [
            'all' => Order::count(),
            'pending' => Order::where('order_status', 'pending')->count(),
            'processing' => Order::where('order_status', 'processing')->count(),
            'shipped' => Order::where('order_status', 'shipped')->count(),
            'delivered' => Order::where('order_status', 'delivered')->count(),
            'partial_delivered' => Order::where('order_status', 'partial_delivered')->count(),
            'returned' => Order::where('order_status', 'returned')->count(),
            'cancelled' => Order::where('order_status', 'cancelled')->count(),
        ];

        return view('admin.orders.index', compact('orders', 'status', 'statusTotals'));
    }

    public function showOrder(Order $order, FraudService $fraudService)
    {
        $order->load('items.product');
        $fraudAnalysis = $fraudService->analyzeOrder($order);

        return view('admin.orders.show', compact('order', 'fraudAnalysis'));
    }

    public function updateOrderStatus(Request $request, Order $order)
    {
        $request->validate([
            'order_status' => 'required|in:pending,processing,shipped,delivered,partial_delivered,cancelled,returned',
            'payment_status' => 'required|in:pending,paid,partial,failed',
        ]);

        $newStatus = $request->order_status;
        $order->load('items.product');

        // Automatic Stock Restoration if returned or cancelled
        if (in_array($newStatus, ['returned', 'cancelled']) && !$order->stock_restored) {
            foreach ($order->items as $item) {
                if ($item->product) {
                    $item->product->increment('stock', $item->quantity);
                }
            }
            $order->stock_restored = true;
        }

        $order->update([
            'order_status' => $newStatus,
            'payment_status' => $request->payment_status,
            'courier_status' => $newStatus === 'returned' ? 'returned' : ($newStatus === 'delivered' ? 'delivered' : $order->courier_status),
        ]);

        return back()->with('success', 'Order status updated successfully! ' . ($order->stock_restored ? '(Inventory stock automatically restored)' : ''));
    }

    public function processCourierReturn(Request $request, Order $order)
    {
        $request->validate([
            'action_type' => 'required|in:full_return,partial_delivery',
            'return_reason' => 'nullable|string|max:500',
            'collected_amount' => 'nullable|numeric|min:0',
            'return_charge' => 'nullable|numeric|min:0',
            'returned_items' => 'nullable|array',
        ]);

        $order->load('items.product');
        $action = $request->action_type;

        if ($action === 'full_return') {
            // Full Return
            if (!$order->stock_restored) {
                foreach ($order->items as $item) {
                    if ($item->product) {
                        $item->product->increment('stock', $item->quantity);
                    }
                }
                $order->stock_restored = true;
            }

            $order->update([
                'order_status' => 'returned',
                'courier_status' => 'returned',
                'payment_status' => 'failed',
                'return_reason' => $request->return_reason ?: 'Customer returned parcel / Delivery refused',
                'return_charge' => (float)($request->return_charge ?? 0),
                'collected_amount' => 0,
            ]);

            return back()->with('success', "Order #{$order->order_number} marked as FULL RETURN. All items restored to stock (+inventory).");
        } else {
            // Partial Delivery
            $collected = (float)($request->collected_amount ?? 0);
            $returnedItems = $request->input('returned_items', []);

            // Restore stock for returned items
            $restoredCount = 0;
            if (is_array($returnedItems)) {
                foreach ($returnedItems as $itemId => $qty) {
                    $qty = (int)$qty;
                    if ($qty > 0) {
                        $item = $order->items->where('id', $itemId)->first();
                        if ($item && $item->product) {
                            $item->product->increment('stock', $qty);
                            $restoredCount += $qty;
                        }
                    }
                }
            }

            $order->update([
                'order_status' => 'partial_delivered',
                'courier_status' => 'delivered',
                'payment_status' => $collected >= $order->total_amount ? 'paid' : 'partial',
                'collected_amount' => $collected,
                'return_charge' => (float)($request->return_charge ?? 0),
                'return_reason' => $request->return_reason ?: 'Partial delivery accepted by customer',
                'stock_restored' => true,
            ]);

            return back()->with('success', "Order #{$order->order_number} marked as PARTIAL DELIVERY. Cash collected: \${$collected}. {$restoredCount} returned items restored to inventory.");
        }
    }

    // ==========================================
    // 8. COURIER INTEGRATION & COURIER PANEL
    // ==========================================
    public function courier()
    {
        $pendingOrders = Order::whereIn('order_status', ['pending', 'processing'])
            ->whereNull('consignment_id')
            ->latest()
            ->get();

        $dispatchedOrders = Order::whereNotNull('consignment_id')->latest()->paginate(10);
        $settings = CourierSetting::all()->keyBy('provider');

        return view('admin.courier.index', compact('pendingOrders', 'dispatchedOrders', 'settings'));
    }

    public function sendToCourier(Request $request, Order $order, CourierService $courierService)
    {
        $provider = $request->input('courier', 'steadfast');
        $result = $courierService->bookOrder($order, $provider);

        return back()->with('success', $result['message']);
    }

    public function saveCourierSettings(Request $request)
    {
        $provider = $request->input('provider');
        CourierSetting::updateOrCreate(
            ['provider' => $provider],
            [
                'api_key' => $request->api_key,
                'secret_key' => $request->secret_key,
                'client_id' => $request->client_id,
                'is_active' => $request->has('is_active'),
            ]
        );

        return back()->with('success', ucfirst($provider) . ' Courier API settings updated!');
    }

    // ==========================================
    // 9. FRAUD CHECKER & RISK ANALYZER
    // ==========================================
    public function fraudChecker(Request $request)
    {
        $searchPhone = $request->get('phone');
        $searchResult = null;

        if ($searchPhone) {
            $prevOrders = Order::where('customer_phone', $searchPhone)->latest()->get();
            $isBlacklisted = FraudBlacklist::where('phone', $searchPhone)->first();
            $totalOrders = $prevOrders->count();
            $delivered = $prevOrders->where('order_status', 'delivered')->count();
            $cancelled = $prevOrders->whereIn('order_status', ['cancelled', 'returned'])->count();

            $searchResult = [
                'phone' => $searchPhone,
                'total_orders' => $totalOrders,
                'delivered' => $delivered,
                'cancelled' => $cancelled,
                'success_rate' => $totalOrders > 0 ? round(($delivered / $totalOrders) * 100) : 100,
                'is_blacklisted' => (bool) $isBlacklisted,
                'orders' => $prevOrders,
            ];
        }

        $blacklists = FraudBlacklist::latest()->paginate(10);
        $recentSuspiciousOrders = Order::where('total_amount', '>', 300)
            ->orWhereIn('order_status', ['cancelled', 'returned'])
            ->latest()
            ->take(10)
            ->get();

        return view('admin.fraud.index', compact('searchResult', 'blacklists', 'recentSuspiciousOrders', 'searchPhone'));
    }

    public function blacklistAdd(Request $request)
    {
        $data = $request->validate([
            'phone' => 'required|string',
            'reason' => 'required|string',
        ]);

        FraudBlacklist::create($data);
        return back()->with('success', "Phone number {$data['phone']} has been added to Fraud Blacklist.");
    }

    public function blacklistRemove(FraudBlacklist $blacklist)
    {
        $blacklist->delete();
        return back()->with('success', 'Phone number removed from blacklist.');
    }

    // ==========================================
    // 10. CUSTOMERS, COUPONS, REVIEWS
    // ==========================================
    public function customers()
    {
        $customers = User::latest()->paginate(15);
        return view('admin.customers.index', compact('customers'));
    }

    public function coupons()
    {
        $coupons = Coupon::latest()->get();
        return view('admin.coupons.index', compact('coupons'));
    }

    public function storeCoupon(Request $request)
    {
        $data = $request->validate([
            'code' => 'required|string|unique:coupons,code|max:50',
            'type' => 'required|in:percentage,fixed',
            'value' => 'required|numeric|min:0',
            'min_spend' => 'nullable|numeric|min:0',
            'usage_limit' => 'nullable|integer|min:1',
        ]);

        $data['is_active'] = true;
        Coupon::create($data);

        return redirect()->route('admin.coupons.index')->with('success', 'Coupon voucher created and activated!');
    }

    public function deleteCoupon(Coupon $coupon)
    {
        $coupon->delete();
        return redirect()->route('admin.coupons.index')->with('success', 'Coupon deleted.');
    }

    public function reviews()
    {
        $reviews = Review::with('product')->latest()->paginate(15);
        return view('admin.reviews.index', compact('reviews'));
    }

    public function toggleReview(Review $review)
    {
        $review->update(['is_approved' => !$review->is_approved]);
        return back()->with('success', 'Review approval status updated.');
    }

    public function deleteReview(Review $review)
    {
        $review->delete();
        return redirect()->route('admin.reviews.index')->with('success', 'Review deleted permanently.');
    }
}