@extends('layouts.admin')

@section('title', 'Activewear Catalog Management')
@section('breadcrumb', 'Catalog')

@section('content')
<div class="flex flex-col gap-6 lg:gap-8">
    
    <!-- Top Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-xl lg:text-2xl font-bold text-gray-900 tracking-tight">Apparel Catalog & Inventory</h1>
            <p class="text-xs text-gray-500 mt-0.5">Manage Gymshark-style activewear drops, prices, variants, and stock inventory</p>
        </div>
        
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.products.create') }}" class="kt-btn kt-btn-primary kt-btn-sm text-xs font-semibold shadow-xs flex items-center gap-2">
                <i class="fa-solid fa-plus text-xs"></i>
                <span>Add New Product</span>
            </a>
        </div>
    </div>

    <!-- Metronic Data Table Card -->
    <div class="kt-card bg-white border border-gray-200/90 rounded-xl shadow-xs overflow-hidden">
        
        <!-- Table Toolbar -->
        <div class="p-6 border-b border-gray-100 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
            <div class="text-xs font-semibold text-gray-500">
                Displaying <span class="text-gray-900 font-bold">{{ $products->total() }}</span> total activewear drops
            </div>
            <div class="inline-flex items-center gap-2">
                <span class="text-xs text-gray-500 font-medium">Catalog Filter:</span>
                <span class="px-2.5 py-1 bg-gray-50 border border-gray-200 text-primary text-xs font-bold rounded-md">All Active Drops</span>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead>
                    <tr class="text-gray-500 border-b border-gray-100 font-bold uppercase text-[10px] tracking-wider bg-gray-50/70">
                        <th class="py-3.5 px-6">Activewear Item</th>
                        <th class="py-3.5 px-6">Category</th>
                        <th class="py-3.5 px-6">Pricing</th>
                        <th class="py-3.5 px-6">Inventory Stock</th>
                        <th class="py-3.5 px-6">Rating</th>
                        <th class="py-3.5 px-6 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 font-medium text-gray-700">
                    @forelse($products as $prod)
                        <tr class="hover:bg-gray-50/60 transition">
                            <td class="py-3.5 px-6">
                                <div class="flex items-center gap-3">
                                    <img src="{{ $prod->image }}" alt="{{ $prod->name }}" class="w-12 h-12 rounded-lg object-cover bg-gray-100 shrink-0 border border-gray-200">
                                    <div>
                                        <div class="font-bold text-gray-900 text-xs">{{ $prod->name }}</div>
                                        <div class="text-[10px] text-gray-400 font-mono mt-0.5">SKU: {{ $prod->sku ?? 'N/A' }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="py-3.5 px-6">
                                <span class="px-2.5 py-1 rounded-md bg-gray-100 text-gray-700 font-semibold text-[11px]">
                                    {{ $prod->category->name ?? 'Activewear' }}
                                </span>
                            </td>
                            <td class="py-3.5 px-6">
                                @if($prod->has_discount)
                                    <span class="text-rose-600 font-black text-sm">${{ number_format($prod->sale_price, 2) }}</span>
                                    <span class="text-[10px] text-gray-400 line-through block">${{ number_format($prod->price, 2) }}</span>
                                @else
                                    <span class="text-gray-900 font-black text-sm">${{ number_format($prod->price, 2) }}</span>
                                @endif
                            </td>
                            <td class="py-3.5 px-6">
                                <span class="kt-badge kt-badge-sm
                                    @if($prod->stock > 10) kt-badge-outline kt-badge-success
                                    @elseif($prod->stock > 0) kt-badge-outline kt-badge-warning
                                    @else kt-badge-outline kt-badge-destructive
                                    @endif
                                ">
                                    {{ $prod->stock }} Units
                                </span>
                            </td>
                            <td class="py-3.5 px-6">
                                <span class="text-amber-500 font-bold flex items-center gap-1">
                                    <i class="fa-solid fa-star text-[10px]"></i>
                                    <span>{{ number_format($prod->rating, 1) }}</span>
                                </span>
                            </td>
                            <td class="py-3.5 px-6 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('product.show', $prod->slug) }}" target="_blank" class="p-2 rounded-lg bg-gray-100 hover:bg-gray-200 text-gray-700 transition" title="View in Store">
                                        <i class="fa-solid fa-arrow-up-right-from-square text-xs"></i>
                                    </a>
                                    <form action="{{ route('admin.products.delete', $prod->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to remove this product?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-2 rounded-lg bg-rose-50 hover:bg-rose-600 text-rose-600 hover:text-white transition cursor-pointer" title="Delete Product">
                                            <i class="fa-solid fa-trash text-xs"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-12 text-center text-gray-400 italic">No products in inventory.</td>
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