@extends('layouts.admin')

@section('title', 'Add New 3D Product')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-xl font-black text-white">Add New Product</h1>
            <p class="text-xs text-slate-400 mt-1">Publish a new catalog item with pricing & 3D attributes</p>
        </div>
        <a href="{{ route('admin.products.index') }}" class="text-xs font-bold text-slate-400 hover:text-white">
            <i class="fa-solid fa-arrow-left mr-1"></i> Back to Products
        </a>
    </div>

    <form action="{{ route('admin.products.store') }}" method="POST" class="p-8 rounded-3xl bg-slate-900/80 border border-slate-800 shadow-xl space-y-6">
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-xs font-bold text-slate-300 uppercase tracking-wider mb-2">Product Name</label>
                <input type="text" name="name" placeholder="e.g. Next-Gen 3D VR Spatial Headset" class="w-full px-4 py-3 rounded-2xl bg-slate-800/80 border border-slate-700 text-white text-xs font-bold focus:outline-none focus:ring-2 focus:ring-indigo-500" required>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-300 uppercase tracking-wider mb-2">Category</label>
                <select name="category_id" class="w-full px-4 py-3 rounded-2xl bg-slate-800/80 border border-slate-700 text-white text-xs font-bold focus:outline-none focus:ring-2 focus:ring-indigo-500" required>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
            <div>
                <label class="block text-xs font-bold text-slate-300 uppercase tracking-wider mb-2">Regular Price ($)</label>
                <input type="number" step="0.01" name="price" placeholder="199.99" class="w-full px-4 py-3 rounded-2xl bg-slate-800/80 border border-slate-700 text-white text-xs font-bold focus:outline-none focus:ring-2 focus:ring-indigo-500" required>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-300 uppercase tracking-wider mb-2">Sale Price ($) (Optional)</label>
                <input type="number" step="0.01" name="sale_price" placeholder="149.99" class="w-full px-4 py-3 rounded-2xl bg-slate-800/80 border border-slate-700 text-white text-xs font-bold focus:outline-none focus:ring-2 focus:ring-indigo-500">
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-300 uppercase tracking-wider mb-2">Stock Inventory</label>
                <input type="number" name="stock" value="25" class="w-full px-4 py-3 rounded-2xl bg-slate-800/80 border border-slate-700 text-white text-xs font-bold focus:outline-none focus:ring-2 focus:ring-indigo-500" required>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-xs font-bold text-slate-300 uppercase tracking-wider mb-2">SKU Code</label>
                <input type="text" name="sku" placeholder="VR-NXT-001" class="w-full px-4 py-3 rounded-2xl bg-slate-800/80 border border-slate-700 text-white text-xs font-bold focus:outline-none focus:ring-2 focus:ring-indigo-500">
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-300 uppercase tracking-wider mb-2">Primary Image URL</label>
                <input type="url" name="image" placeholder="https://images.unsplash.com/..." class="w-full px-4 py-3 rounded-2xl bg-slate-800/80 border border-slate-700 text-white text-xs font-bold focus:outline-none focus:ring-2 focus:ring-indigo-500" required>
            </div>
        </div>

        <div>
            <label class="block text-xs font-bold text-slate-300 uppercase tracking-wider mb-2">Short Tagline Description</label>
            <input type="text" name="short_description" placeholder="Ultra-low latency, 8K micro-OLED panels, and spatial audio tracking." class="w-full px-4 py-3 rounded-2xl bg-slate-800/80 border border-slate-700 text-white text-xs font-bold focus:outline-none focus:ring-2 focus:ring-indigo-500" required>
        </div>

        <div>
            <label class="block text-xs font-bold text-slate-300 uppercase tracking-wider mb-2">Full Specifications & Description</label>
            <textarea name="description" rows="4" placeholder="Detailed product story, tech specs, dimensions, and in-box items..." class="w-full px-4 py-3 rounded-2xl bg-slate-800/80 border border-slate-700 text-white text-xs font-bold focus:outline-none focus:ring-2 focus:ring-indigo-500"></textarea>
        </div>

        <div class="flex items-center gap-3">
            <input type="checkbox" name="is_featured" id="is_featured" value="1" class="rounded text-indigo-600 focus:ring-0">
            <label for="is_featured" class="text-xs font-bold text-slate-300 cursor-pointer">
                Mark as 3D Featured Showcase on Homepage
            </label>
        </div>

        <div class="pt-4 flex justify-end gap-3 border-t border-slate-800">
            <a href="{{ route('admin.products.index') }}" class="px-6 py-3 rounded-2xl bg-slate-800 text-slate-300 hover:text-white text-xs font-bold transition">
                Cancel
            </a>
            <button type="submit" class="px-8 py-3 rounded-2xl bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-black transition shadow-lg shadow-indigo-600/25">
                Save & Publish
            </button>
        </div>
    </form>
</div>
@endsection