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
            return redirect()->intended(route('admin.dashboard'))->with('success', 'Welcome to Metronic Executive Control Center!');
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
    // 3. CATEGORIES MANAGEMENT
    // ==========================================
    public function categories()
    {
        $categories = Category::withCount('products')->latest()->get();
        return view('admin.categories.index', compact('categories'));
    }

    public function storeCategory(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255|unique:categories,name',
            'image' => 'nullable|url',
            'description' => 'nullable|string',
        ]);

        $data['slug'] = Str::slug($data['name']);
        Category::create($data);

        return redirect()->route('admin.categories.index')->with('success', 'Apparel category created successfully!');
    }

    public function deleteCategory(Category $category)
    {
        $category->delete();
        return redirect()->route('admin.categories.index')->with('success', 'Category deleted successfully.');
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
            'logo' => 'nullable|url',
            'description' => 'nullable|string',
        ]);

        $data['slug'] = Str::slug($data['name']);
        $data['is_active'] = true;
        Brand::create($data);

        return redirect()->route('admin.brands.index')->with('success', 'Activewear brand registered successfully!');
    }

    public function deleteBrand(Brand $brand)
    {
        $brand->delete();
        return redirect()->route('admin.brands.index')->with('success', 'Brand removed successfully.');
    }

    // ==========================================
    // 5. PRODUCTS & CATALOG
    // ==========================================
    public function products()
    {
        $products = Product::with(['category', 'brand'])->latest()->paginate(10);
        return view('admin.products.index', compact('products'));
    }

    public function createProduct()
    {
        $categories = Category::all();
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
            'image' => 'required|url',
            'short_description' => 'required|string|max:500',
            'description' => 'nullable|string',
            'is_featured' => 'nullable|boolean',
        ]);

        $data['slug'] = Str::slug($data['name']) . '-' . Str::random(5);
        $data['is_featured'] = $request->has('is_featured');
        $data['is_active'] = true;

        Product::create($data);

        return redirect()->route('admin.products.index')->with('success', 'Activewear drop published successfully!');
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
            'order_status' => 'required|in:pending,processing,shipped,delivered,cancelled,returned',
            'payment_status' => 'required|in:pending,paid,failed',
        ]);

        $order->update([
            'order_status' => $request->order_status,
            'payment_status' => $request->payment_status,
        ]);

        return back()->with('success', 'Order status updated successfully!');
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