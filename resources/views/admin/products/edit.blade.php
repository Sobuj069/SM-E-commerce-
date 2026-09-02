@extends('layouts.admin')

@section('title', 'Edit ' . $product->name)
@section('breadcrumb', 'Catalog / Edit Product')

@section('content')
<div class="max-w-4xl mx-auto flex flex-col gap-6">
    
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-xl lg:text-2xl font-bold text-gray-900 tracking-tight">Edit Activewear Drop</h1>
            <p class="text-xs text-gray-500 mt-0.5 font-medium">Update pricing, inventory stock, images, description, and status</p>
        </div>
        <div class="flex items-center gap-2">
            <a href="{{ route('product.show', $product->slug) }}" target="_blank" class="kt-btn kt-btn-outline kt-btn-sm text-xs font-semibold flex items-center gap-1.5 text-gray-700">
                <i class="fa-solid fa-arrow-up-right-from-square text-xs text-primary"></i> Live Store
            </a>
            <a href="{{ route('admin.products.index') }}" class="kt-btn kt-btn-outline kt-btn-sm text-xs font-semibold flex items-center gap-1.5 text-gray-700">
                <i class="fa-solid fa-arrow-left text-xs"></i> Back to Catalog
            </a>
        </div>
    </div>

    <form action="{{ route('admin.products.update', $product->id) }}" method="POST" class="p-8 rounded-xl bg-white border border-gray-200/90 shadow-xs space-y-6">
        @csrf
        @method('PUT')

        <!-- Product Name & Category -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="space-y-1.5">
                <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider">Product Name</label>
                <input type="text" name="name" value="{{ old('name', $product->name) }}" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg text-xs font-semibold text-gray-900 placeholder-gray-400 focus:outline-none focus:border-primary focus:bg-white transition" required>
            </div>

            <div class="space-y-1.5">
                <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider">Apparel Category</label>
                <select name="category_id" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg text-xs font-semibold text-gray-900 focus:outline-none focus:border-primary focus:bg-white transition" required>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ old('category_id', $product->category_id) == $cat->id ? 'selected' : '' }}>
                            {{ $cat->name }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        <!-- Brand & SKU -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="space-y-1.5">
                <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider">Brand Label</label>
                <select name="brand_id" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg text-xs font-semibold text-gray-900 focus:outline-none focus:border-primary focus:bg-white transition">
                    <option value="">-- Select Brand (Optional) --</option>
                    @foreach($brands as $brand)
                        <option value="{{ $brand->id }}" {{ old('brand_id', $product->brand_id) == $brand->id ? 'selected' : '' }}>
                            {{ $brand->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="space-y-1.5">
                <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider">SKU Identifier</label>
                <input type="text" name="sku" value="{{ old('sku', $product->sku) }}" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg text-xs font-semibold text-gray-900 font-mono placeholder-gray-400 focus:outline-none focus:border-primary focus:bg-white transition">
            </div>
        </div>

        <!-- Pricing & Stock -->
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
            <div class="space-y-1.5">
                <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider">Regular Price ($)</label>
                <input type="number" step="0.01" name="price" value="{{ old('price', $product->price) }}" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg text-xs font-semibold text-gray-900 placeholder-gray-400 focus:outline-none focus:border-primary focus:bg-white transition" required>
            </div>

            <div class="space-y-1.5">
                <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider">Sale Price ($) (Optional)</label>
                <input type="number" step="0.01" name="sale_price" value="{{ old('sale_price', $product->sale_price) }}" placeholder="Leave blank if no discount" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg text-xs font-semibold text-gray-900 placeholder-gray-400 focus:outline-none focus:border-primary focus:bg-white transition">
            </div>

            <div class="space-y-1.5">
                <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider">Stock Inventory Units</label>
                <input type="number" name="stock" value="{{ old('stock', $product->stock) }}" min="0" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg text-xs font-semibold text-gray-900 placeholder-gray-400 focus:outline-none focus:border-primary focus:bg-white transition" required>
            </div>
        </div>

        <!-- Image with Live Preview -->
        <div class="space-y-1.5" x-data="{ imgUrl: '{{ old('image', $product->image) }}' }">
            <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider">High-Res Image URL</label>
            <div class="flex items-center gap-4">
                <img :src="imgUrl" alt="Preview" class="w-16 h-16 rounded-lg object-cover bg-gray-100 border border-gray-200 shrink-0" onerror="this.src='https://images.unsplash.com/photo-1518611012118-696072aa579a?w=400'">
                <input type="url" name="image" x-model="imgUrl" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg text-xs font-semibold text-gray-900 placeholder-gray-400 focus:outline-none focus:border-primary focus:bg-white transition" required>
            </div>
        </div>

        <!-- Short Description -->
        <div class="space-y-1.5">
            <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider">Short Tagline Description</label>
            <input type="text" name="short_description" value="{{ old('short_description', $product->short_description) }}" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg text-xs font-semibold text-gray-900 placeholder-gray-400 focus:outline-none focus:border-primary focus:bg-white transition" required>
        </div>

        <!-- Full Description -->
        <div class="space-y-1.5">
            <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider">Full Story & Fabric Specifications</label>
            <textarea name="description" rows="4" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg text-xs font-semibold text-gray-900 placeholder-gray-400 focus:outline-none focus:border-primary focus:bg-white transition">{{ old('description', $product->description) }}</textarea>
        </div>

        <!-- Checkboxes -->
        <div class="flex flex-col sm:flex-row sm:items-center gap-6 pt-2">
            <label class="flex items-center gap-2 cursor-pointer text-xs font-semibold text-gray-700">
                <input type="checkbox" name="is_featured" value="1" {{ old('is_featured', $product->is_featured) ? 'checked' : '' }} class="rounded border-gray-300 text-[#1b84ff] focus:ring-0">
                <span>Featured New Drop on Storefront</span>
            </label>

            <label class="flex items-center gap-2 cursor-pointer text-xs font-semibold text-gray-700">
                <input type="checkbox" name="is_active" value="1" {{ old('is_active', $product->is_active) ? 'checked' : '' }} class="rounded border-gray-300 text-emerald-600 focus:ring-0">
                <span>Active & Visible in Catalog</span>
            </label>
        </div>

        <!-- Action Buttons -->
        <div class="pt-6 flex items-center justify-end gap-3 border-t border-gray-100">
            <a href="{{ route('admin.products.index') }}" class="kt-btn kt-btn-outline text-xs font-semibold text-gray-600">
                Cancel
            </a>
            <button type="submit" class="kt-btn kt-btn-primary text-xs font-semibold flex items-center gap-2 shadow-xs cursor-pointer">
                <i class="fa-solid fa-floppy-disk text-xs"></i>
                <span>Update Drop Details</span>
            </button>
        </div>
    </form>
</div>
@endsection
