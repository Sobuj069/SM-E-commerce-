@extends('layouts.admin')

@section('title', 'Add New Activewear Drop')
@section('breadcrumb', 'Catalog / Add Product')

@section('content')
<div class="max-w-4xl mx-auto flex flex-col gap-6">
    
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-xl lg:text-2xl font-bold text-gray-900 tracking-tight">Add New Activewear Drop</h1>
            <p class="text-xs text-gray-500 mt-0.5 font-medium">Publish new gym apparel, set fabric specs, pricing, and stock inventory</p>
        </div>
        <a href="{{ route('admin.products.index') }}" class="kt-btn kt-btn-outline kt-btn-sm text-xs font-semibold flex items-center gap-1.5 text-gray-700">
            <i class="fa-solid fa-arrow-left text-xs"></i> Back to Catalog
        </a>
    </div>

    <form action="{{ route('admin.products.store') }}" method="POST" class="p-8 rounded-xl bg-white border border-gray-200/90 shadow-xs space-y-6">
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="space-y-1.5">
                <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider">Product Name</label>
                <input type="text" name="name" placeholder="e.g. Vital Seamless 2.0 Leggings" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg text-xs font-semibold text-gray-900 placeholder-gray-400 focus:outline-none focus:border-primary focus:bg-white transition" required>
            </div>

            <div class="space-y-1.5">
                <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider">Apparel Category</label>
                <select name="category_id" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg text-xs font-semibold text-gray-900 focus:outline-none focus:border-primary focus:bg-white transition" required>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
            <div class="space-y-1.5">
                <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider">Regular Price ($)</label>
                <input type="number" step="0.01" name="price" placeholder="54.00" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg text-xs font-semibold text-gray-900 placeholder-gray-400 focus:outline-none focus:border-primary focus:bg-white transition" required>
            </div>

            <div class="space-y-1.5">
                <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider">Sale Price ($) (Optional)</label>
                <input type="number" step="0.01" name="sale_price" placeholder="44.00" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg text-xs font-semibold text-gray-900 placeholder-gray-400 focus:outline-none focus:border-primary focus:bg-white transition">
            </div>

            <div class="space-y-1.5">
                <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider">Stock Inventory</label>
                <input type="number" name="stock" value="50" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg text-xs font-semibold text-gray-900 placeholder-gray-400 focus:outline-none focus:border-primary focus:bg-white transition" required>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="space-y-1.5">
                <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider">SKU Identifier</label>
                <input type="text" name="sku" placeholder="VTL-SMS-001" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg text-xs font-semibold text-gray-900 placeholder-gray-400 focus:outline-none focus:border-primary focus:bg-white transition">
            </div>

            <div class="space-y-1.5">
                <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider">High-Res Image URL</label>
                <input type="url" name="image" placeholder="https://images.unsplash.com/..." class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg text-xs font-semibold text-gray-900 placeholder-gray-400 focus:outline-none focus:border-primary focus:bg-white transition" required>
            </div>
        </div>

        <div class="space-y-1.5">
            <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider">Short Tagline Description</label>
            <input type="text" name="short_description" placeholder="High-waisted compression fit, sweat-wicking DRY fabric, and supportive ribbed waistband." class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg text-xs font-semibold text-gray-900 placeholder-gray-400 focus:outline-none focus:border-primary focus:bg-white transition" required>
        </div>

        <div class="space-y-1.5">
            <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider">Full Story & Fabric Specifications</label>
            <textarea name="description" rows="4" placeholder="Detailed product story, fabric composition (e.g. 93% Nylon, 7% Elastane), washing instructions, and fit guide..." class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg text-xs font-semibold text-gray-900 placeholder-gray-400 focus:outline-none focus:border-primary focus:bg-white transition"></textarea>
        </div>

        <div class="flex items-center gap-3 pt-2">
            <input type="checkbox" name="is_featured" id="is_featured" value="1" class="rounded border-gray-300 text-[#1b84ff] focus:ring-0">
            <label for="is_featured" class="text-xs font-semibold text-gray-700 cursor-pointer">
                Mark as Featured New Drop on Storefront
            </label>
        </div>

        <div class="pt-6 flex items-center justify-end gap-3 border-t border-gray-100">
            <a href="{{ route('admin.products.index') }}" class="kt-btn kt-btn-outline text-xs font-semibold text-gray-600">
                Cancel
            </a>
            <button type="submit" class="kt-btn kt-btn-primary text-xs font-semibold flex items-center gap-2 shadow-xs cursor-pointer">
                <i class="fa-solid fa-cloud-arrow-up text-xs"></i>
                <span>Publish Drop</span>
            </button>
        </div>
    </form>
</div>
@endsection