@extends('layouts.admin')

@section('title', 'Product Catalog Management')
@section('breadcrumb', 'Catalog')

@section('content')
<div class="space-y-6">
    
    <!-- Top Header & Action Row -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-xl font-black text-white">Apparel Catalog & Inventory</h1>
            <p class="text-xs text-gray-400 mt-0.5">Manage Gymshark-style activewear drops, prices, variants, and stock</p>
        </div>
        
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.products.create') }}" class="px-4 py-2.5 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-black transition flex items-center gap-2 shadow-lg shadow-indigo-600/25">
                <i class="fa-solid fa-plus text-xs"></i>
                <span>Add New Product</span>
            </a>
        </div>
    </div>

    <!-- Metronic Data Table Card -->
    <div class="bg-[#1e1e2d] rounded-2xl border border-[#2b2b40] shadow-xl overflow-hidden">
        
        <!-- Table Toolbar -->
        <div class="p-5 border-b border-[#2b2b40] flex flex-col sm:flex-row sm:items-center justify-between gap-3">
            <div class="text-xs font-bold text-gray-400">
                Showing <span class="text-white font-black">{{ $products->total() }}</span> total activewear products
            </div>
            <div class="inline-flex items-center gap-2">
                <span class="text-xs text-gray-400 font-bold">Catalog Filter:</span>
                <span class="px-2.5 py-1 bg-[#151521] border border-[#2b2b40] text-indigo-400 text-xs font-black rounded-lg">All Drops</span>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead>
                    <tr class="text-gray-400 border-b border-[#2b2b40] font-black uppercase text-[10px] tracking-wider bg-[#151521]/60">
                        <th class="py-4 px-5">Activewear Item</th>
                        <th class="py-4 px-5">Category</th>
                        <th class="py-4 px-5">Pricing</th>
                        <th class="py-4 px-5">Inventory Stock</th>
                        <th class="py-4 px-5">Rating</th>
                        <th class="py-4 px-5 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#2b2b40] font-medium">
                    @forelse($products as $prod)
                        <tr class="hover:bg-[#151521]/40 transition">
                            <td class="py-3.5 px-5">
                                <div class="flex items-center gap-3">
                                    <img src="{{ $prod->image }}" alt="{{ $prod->name }}" class="w-12 h-12 rounded-xl object-cover bg-zinc-900 shrink-0 border border-[#2b2b40]">
                                    <div>
                                        <div class="font-bold text-white line-clamp-1 text-xs">{{ $prod->name }}</div>
                                        <div class="text-[10px] text-gray-500 font-mono mt-0.5">SKU: {{ $prod->sku ?? 'N/A' }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="py-3.5 px-5">
                                <span class="px-2.5 py-1 rounded-lg bg-[#151521] border border-[#2b2b40] text-gray-300 font-bold text-[11px]">
                                    {{ $prod->category->name ?? 'Activewear' }}
                                </span>
                            </td>
                            <td class="py-3.5 px-5">
                                @if($prod->has_discount)
                                    <span class="text-rose-400 font-black text-sm">${{ number_format($prod->sale_price, 2) }}</span>
                                    <span class="text-[10px] text-gray-500 line-through block">${{ number_format($prod->price, 2) }}</span>
                                @else
                                    <span class="text-white font-black text-sm">${{ number_format($prod->price, 2) }}</span>
                                @endif
                            </td>
                            <td class="py-3.5 px-5">
                                <span class="px-2.5 py-1 rounded-full text-[10px] font-black uppercase tracking-wider
                                    @if($prod->stock > 10) bg-emerald-500/15 text-emerald-400 border border-emerald-500/30
                                    @elseif($prod->stock > 0) bg-amber-500/15 text-amber-400 border border-amber-500/30
                                    @else bg-rose-500/15 text-rose-400 border border-rose-500/30
                                    @endif
                                ">
                                    {{ $prod->stock }} Units
                                </span>
                            </td>
                            <td class="py-3.5 px-5">
                                <span class="text-amber-400 font-bold flex items-center gap-1">
                                    <i class="fa-solid fa-star text-[10px]"></i>
                                    <span>{{ number_format($prod->rating, 1) }}</span>
                                </span>
                            </td>
                            <td class="py-3.5 px-5 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('product.show', $prod->slug) }}" target="_blank" class="p-2 rounded-xl bg-[#151521] hover:bg-[#2b2b40] text-gray-300 hover:text-white transition border border-[#2b2b40]" title="View in Store">
                                        <i class="fa-solid fa-arrow-up-right-from-square text-xs"></i>
                                    </a>
                                    <form action="{{ route('admin.products.delete', $prod->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to remove this product?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-2 rounded-xl bg-rose-500/10 hover:bg-rose-500 text-rose-400 hover:text-white transition border border-rose-500/20 cursor-pointer" title="Delete Product">
                                            <i class="fa-solid fa-trash text-xs"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-12 text-center text-gray-500 italic">No products in inventory.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($products->hasPages())
            <div class="p-4 border-t border-[#2b2b40] bg-[#1a1a27]">
                {{ $products->links() }}
            </div>
        @endif
    </div>

</div>
@endsection