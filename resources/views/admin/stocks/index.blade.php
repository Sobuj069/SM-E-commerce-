@extends('layouts.admin')

@section('title', 'Product Stock & Inventory')
@section('breadcrumb', 'Inventory / Stock')

@section('content')
<div class="flex flex-col gap-6 lg:gap-8">
    
    <!-- Top Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-xl lg:text-2xl font-bold text-gray-900 tracking-tight">Stock & Inventory Manager</h1>
            <p class="text-xs text-gray-500 mt-0.5">Real-time stock monitoring, low-stock warnings, and fast inline inventory updates</p>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.purchases.index') }}" class="kt-btn kt-btn-outline kt-btn-sm text-xs font-semibold text-gray-700 flex items-center gap-1.5">
                <i class="fa-solid fa-truck-ramp-box text-xs text-primary"></i>
                <span>Supplier Purchases</span>
            </a>
            <a href="{{ route('admin.products.create') }}" class="kt-btn kt-btn-primary kt-btn-sm text-xs font-semibold shadow-xs flex items-center gap-1.5">
                <i class="fa-solid fa-plus text-xs"></i>
                <span>Add Product</span>
            </a>
        </div>
    </div>

    <!-- Inventory KPI Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">
        <div class="kt-card p-5 bg-white border border-gray-200/90 rounded-xl shadow-xs">
            <div class="text-xs font-semibold text-gray-500 uppercase">Estimated Stock Asset Value</div>
            <div class="text-2xl font-black text-gray-900 mt-2">${{ number_format($totalStockValue, 2) }}</div>
            <div class="text-[11px] text-gray-400 mt-1">Across all product inventory</div>
        </div>

        <div class="kt-card p-5 bg-white border border-gray-200/90 rounded-xl shadow-xs">
            <div class="text-xs font-semibold text-amber-600 uppercase flex items-center gap-1">
                <i class="fa-solid fa-triangle-exclamation"></i> Low Stock Drops (≤ 5)
            </div>
            <div class="text-2xl font-black text-amber-600 mt-2">{{ $lowStockCount }} Items</div>
            <div class="text-[11px] text-gray-400 mt-1">Needs purchase re-order soon</div>
        </div>

        <div class="kt-card p-5 bg-white border border-gray-200/90 rounded-xl shadow-xs">
            <div class="text-xs font-semibold text-rose-600 uppercase flex items-center gap-1">
                <i class="fa-solid fa-circle-xmark"></i> Out of Stock (0 Units)
            </div>
            <div class="text-2xl font-black text-rose-600 mt-2">{{ $outOfStockCount }} Items</div>
            <div class="text-[11px] text-gray-400 mt-1">Customers cannot purchase</div>
        </div>
    </div>

    <!-- Stock Data Table -->
    <div class="kt-card bg-white border border-gray-200/90 rounded-xl shadow-xs overflow-hidden">
        <div class="p-6 border-b border-gray-100 flex justify-between items-center">
            <h3 class="text-base font-bold text-gray-900">Inventory Levels by SKU</h3>
            <span class="text-xs text-gray-500 font-medium">Auto-synced with checkout</span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead>
                    <tr class="text-gray-500 border-b border-gray-100 font-bold uppercase text-[10px] tracking-wider bg-gray-50/70">
                        <th class="py-3.5 px-6">Product Details</th>
                        <th class="py-3.5 px-6">SKU Code</th>
                        <th class="py-3.5 px-6">Price</th>
                        <th class="py-3.5 px-6">Current Stock</th>
                        <th class="py-3.5 px-6">Stock Status</th>
                        <th class="py-3.5 px-6 text-right">Update Stock</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 font-medium text-gray-700">
                    @forelse($products as $prod)
                        <tr class="hover:bg-gray-50/60 transition">
                            <td class="py-3.5 px-6">
                                <div class="flex items-center gap-3">
                                    <img src="{{ $prod->image }}" alt="{{ $prod->name }}" class="w-11 h-11 rounded-lg object-cover bg-gray-100 border border-gray-200 shrink-0">
                                    <div>
                                        <div class="font-bold text-gray-900 text-xs">{{ $prod->name }}</div>
                                        <div class="text-[10px] text-gray-400">{{ $prod->category->name ?? 'Activewear' }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="py-3.5 px-6 font-mono text-gray-600 font-bold">
                                {{ $prod->sku ?? 'N/A' }}
                            </td>
                            <td class="py-3.5 px-6 font-bold text-gray-900">
                                ${{ number_format($prod->effective_price, 2) }}
                            </td>
                            <td class="py-3.5 px-6 font-black text-sm text-gray-900">
                                {{ $prod->stock }} Units
                            </td>
                            <td class="py-3.5 px-6">
                                <span class="kt-badge kt-badge-sm
                                    @if($prod->stock > 10) kt-badge-outline kt-badge-success
                                    @elseif($prod->stock > 0) kt-badge-outline kt-badge-warning
                                    @else kt-badge-outline kt-badge-destructive
                                    @endif
                                ">
                                    @if($prod->stock > 10) Healthy Stock
                                    @elseif($prod->stock > 0) Low Stock
                                    @else Out of Stock
                                    @endif
                                </span>
                            </td>
                            <td class="py-3.5 px-6 text-right">
                                <form action="{{ route('admin.stocks.update', $prod->id) }}" method="POST" class="inline-flex items-center gap-1.5">
                                    @csrf
                                    <input type="number" name="stock" value="{{ $prod->stock }}" min="0" class="w-20 px-2.5 py-1.5 bg-gray-50 border border-gray-200 rounded-lg text-xs font-bold text-gray-900 text-center focus:outline-none focus:border-primary">
                                    <button type="submit" class="kt-btn kt-btn-primary kt-btn-sm text-xs font-semibold py-1.5 px-2.5 shadow-xs cursor-pointer" title="Save Stock">
                                        <i class="fa-solid fa-check text-xs"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-8 text-center text-gray-400 italic">No products in inventory.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($products->hasPages())
            <div class="p-4 border-t border-gray-100 bg-gray-50/50">
                {{ $products->links() }}
            </div>
        @endif
    </div>

</div>
@endsection