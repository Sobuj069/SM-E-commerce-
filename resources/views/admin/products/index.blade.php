@extends('layouts.admin')

@section('title', 'Product Catalog Management')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-xl font-black text-white">Products & Inventory</h1>
            <p class="text-xs text-slate-400 mt-1">Manage catalog, 3D assets, prices, and stock levels</p>
        </div>
        <a href="{{ route('admin.products.create') }}" class="px-5 py-2.5 rounded-2xl bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-black transition flex items-center gap-2 shadow-lg shadow-indigo-600/25 self-start">
            <i class="fa-solid fa-plus"></i> Add New Product
        </a>
    </div>

    <div class="bg-slate-900/80 rounded-3xl border border-slate-800 shadow-xl overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead>
                    <tr class="text-slate-400 border-b border-slate-800 font-black uppercase text-[10px] tracking-wider bg-slate-950/40">
                        <th class="py-4 px-4">Item</th>
                        <th class="py-4 px-4">Category</th>
                        <th class="py-4 px-4">Price</th>
                        <th class="py-4 px-4">Stock</th>
                        <th class="py-4 px-4">Rating</th>
                        <th class="py-4 px-4 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-800/60 font-medium">
                    @forelse($products as $prod)
                        <tr class="hover:bg-slate-800/30 transition">
                            <td class="py-3 px-4">
                                <div class="flex items-center gap-3">
                                    <img src="{{ $prod->image }}" alt="{{ $prod->name }}" class="w-10 h-10 rounded-xl object-cover shrink-0">
                                    <div>
                                        <div class="font-bold text-white line-clamp-1">{{ $prod->name }}</div>
                                        <div class="text-[10px] text-slate-400 font-mono">SKU: {{ $prod->sku ?? 'N/A' }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="py-3 px-4 text-slate-300">{{ $prod->category->name ?? 'General' }}</td>
                            <td class="py-3 px-4">
                                @if($prod->has_discount)
                                    <span class="text-rose-400 font-black">${{ number_format($prod->sale_price, 2) }}</span>
                                    <span class="text-[10px] text-slate-500 line-through block">${{ number_format($prod->price, 2) }}</span>
                                @else
                                    <span class="text-white font-black">${{ number_format($prod->price, 2) }}</span>
                                @endif
                            </td>
                            <td class="py-3 px-4">
                                <span class="px-2 py-0.5 rounded-full text-[10px] font-black {{ $prod->stock > 5 ? 'bg-emerald-500/20 text-emerald-400' : ($prod->stock > 0 ? 'bg-amber-500/20 text-amber-300' : 'bg-rose-500/20 text-rose-400') }}">
                                    {{ $prod->stock }} in stock
                                </span>
                            </td>
                            <td class="py-3 px-4 text-amber-400 font-bold">★ {{ number_format($prod->rating, 1) }}</td>
                            <td class="py-3 px-4 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('product.show', $prod->slug) }}" target="_blank" class="p-2 rounded-xl bg-slate-800 hover:bg-slate-700 text-slate-300 hover:text-white transition" title="Preview Product">
                                        <i class="fa-solid fa-arrow-up-right-from-square text-xs"></i>
                                    </a>
                                    <form action="{{ route('admin.products.delete', $prod->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this product?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-2 rounded-xl bg-rose-500/10 hover:bg-rose-500 text-rose-400 hover:text-white transition" title="Delete">
                                            <i class="fa-solid fa-trash text-xs"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-8 text-center text-slate-500 italic">No products in inventory.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="p-4 border-t border-slate-800">
            {{ $products->links() }}
        </div>
    </div>
</div>
@endsection