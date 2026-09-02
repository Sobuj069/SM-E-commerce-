<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\Category;
use App\Models\Coupon;
use App\Models\Review;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    // Admin Login Page
    public function loginView()
    {
        if (Auth::check()) {
            return redirect()->route('admin.dashboard');
        }
        return view('admin.auth.login');
    }

    // Admin Login Post Action
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

    // Admin Logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('admin.login')->with('success', 'You have been logged out securely.');
    }

    // Dashboard with ApexCharts Analytics
    public function dashboard()
    {
        $totalRevenue = Order::where('payment_status', '!=', 'failed')->sum('total_amount');
        $totalOrders = Order::count();
        $totalProducts = Product::count();
        $totalCustomers = User::count();

        $recentOrders = Order::latest()->take(6)->get();
        $topProducts = Product::orderByDesc('reviews_count')->take(5)->get();

        // 7-day revenue trend data for ApexCharts
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

    // Products Index
    public function products()
    {
        $products = Product::with('category')->latest()->paginate(10);
        return view('admin.products.index', compact('products'));
    }

    // Create Product
    public function createProduct()
    {
        $categories = Category::all();
        return view('admin.products.create', compact('categories'));
    }

    // Store Product
    public function storeProduct(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
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
        $data['in_stock'] = $data['stock'] > 0;

        Product::create($data);

        return redirect()->route('admin.products.index')->with('success', 'Activewear drop published successfully to storefront!');
    }

    // Delete Product
    public function deleteProduct(Product $product)
    {
        $product->delete();
        return redirect()->route('admin.products.index')->with('success', 'Product removed successfully.');
    }

    // Orders Index
    public function orders()
    {
        $orders = Order::latest()->paginate(15);
        return view('admin.orders.index', compact('orders'));
    }

    // Show Order
    public function showOrder(Order $order)
    {
        $order->load('items.product');
        return view('admin.orders.show', compact('order'));
    }

    // Update Order Status
    public function updateOrderStatus(Request $request, Order $order)
    {
        $request->validate([
            'order_status' => 'required|in:pending,processing,shipped,delivered,cancelled',
            'payment_status' => 'required|in:pending,paid,failed',
        ]);

        $order->update([
            'order_status' => $request->order_status,
            'payment_status' => $request->payment_status,
        ]);

        return back()->with('success', 'Order status updated successfully!');
    }

    // Customers List
    public function customers()
    {
        $customers = User::latest()->paginate(15);
        return view('admin.customers.index', compact('customers'));
    }

    // Coupons Index
    public function coupons()
    {
        $coupons = Coupon::latest()->get();
        return view('admin.coupons.index', compact('coupons'));
    }

    // Store Coupon
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

    // Delete Coupon
    public function deleteCoupon(Coupon $coupon)
    {
        $coupon->delete();
        return redirect()->route('admin.coupons.index')->with('success', 'Coupon deleted.');
    }

    // Reviews Moderation Index
    public function reviews()
    {
        $reviews = Review::with('product')->latest()->paginate(15);
        return view('admin.reviews.index', compact('reviews'));
    }

    // Toggle Review Approval
    public function toggleReview(Review $review)
    {
        $review->update(['is_approved' => !$review->is_approved]);
        return back()->with('success', 'Review approval status updated.');
    }

    // Delete Review
    public function deleteReview(Review $review)
    {
        $review->delete();
        return redirect()->route('admin.reviews.index')->with('success', 'Review deleted permanently.');
    }
}