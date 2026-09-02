@extends('layouts.admin')

@section('title', 'Edit ' . $product->name)
@section('breadcrumb', 'Catalog / Edit Product')

@section('content')
<div class="max-w-5xl mx-auto flex flex-col gap-6" x-data="{
    primaryPreview: '{{ $product->image }}',
    existingGallery: {{ json_encode($product->gallery_images ?? []) }},
    newGalleryPreviews: [],
    newGalleryUrls: [''],
    variants: {{ json_encode($product->variants->map(function($v) {
        return [
            'name' => $v->name,
            'size' => $v->size ?? '',
            'color' => $v->color ?? '#000000',
            'stock' => $v->stock,
            'price' => $v->price ?? '',
            'sku' => $v->sku ?? '',
        ];
    })) }},

    // Quick Helpers
    commonSizes: ['XS', 'S', 'M', 'L', 'XL', 'XXL'],
    commonColors: [
        { name: 'Black', hex: '#000000' },
        { name: 'Onyx Grey', hex: '#374151' },
        { name: 'Navy Blue', hex: '#1e3a8a' },
        { name: 'Rose Red', hex: '#e11d48' },
        { name: 'Sage Green', hex: '#059669' },
        { name: 'White', hex: '#ffffff' }
    ],

    onPrimaryChange(e) {
        const file = e.target.files[0];
        if (file) {
            this.primaryPreview = URL.createObjectURL(file);
        }
    },
    onNewGalleryFiles(e) {
        const files = Array.from(e.target.files);
        files.forEach(f => {
            this.newGalleryPreviews.push(URL.createObjectURL(f));
        });
    },
    removeExistingPhoto(index) {
        this.existingGallery.splice(index, 1);
    },
    removeNewPreview(index) {
        this.newGalleryPreviews.splice(index, 1);
    },
    addNewGalleryUrl() {
        this.newGalleryUrls.push('');
    },
    removeNewGalleryUrl(index) {
        this.newGalleryUrls.splice(index, 1);
    },

    // Variant Actions
    addVariant(size = '', color = '#000000', colorName = '') {
        const name = (colorName || (color ? 'Color' : '')) + (size ? ' / ' + size : '');
        this.variants.push({
            name: name.trim() || 'Standard Variant',
            size: size,
            color: color,
            price: '',
            stock: 10,
            sku: ''
        });
    },
    removeVariant(index) {
        this.variants.splice(index, 1);
    },
    quickAddSize(size) {
        this.addVariant(size, '#000000', 'Black');
    },
    quickAddColor(col) {
        this.addVariant('M', col.hex, col.name);
    }
}">
    
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-xl lg:text-2xl font-bold text-gray-900 tracking-tight">Edit Activewear Drop</h1>
            <p class="text-xs text-gray-500 mt-0.5 font-medium">Update pricing, inventory stock, sizes, colors, multiple gallery photos, and specs</p>
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

    <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data" class="p-6 sm:p-8 rounded-xl bg-white border border-gray-200/90 shadow-xs space-y-6">
        @csrf
        @method('PUT')

        <!-- Product Name & Category -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="space-y-1.5">
                <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider">Product Name *</label>
                <input type="text" name="name" value="{{ old('name', $product->name) }}" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg text-xs font-semibold text-gray-900 placeholder-gray-400 focus:outline-none focus:border-primary focus:bg-white transition" required>
            </div>

            <div class="space-y-1.5">
                <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider">Apparel Category & Hierarchy *</label>
                <select name="category_id" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg text-xs font-semibold text-gray-900 focus:outline-none focus:border-primary focus:bg-white transition" required>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ old('category_id', $product->category_id) == $cat->id ? 'selected' : '' }}>
                            @if($cat->level == 1)
                                👑 {{ $cat->name }} (Main)
                            @elseif($cat->level == 2)
                                &nbsp;&nbsp;↳ {{ $cat->name }} (Sub of {{ $cat->parent->name ?? '' }})
                            @else
                                &nbsp;&nbsp;&nbsp;&nbsp;↳ {{ $cat->name }} (Child)
                            @endif
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
                    <option value="">-- No Brand (In-House Label) --</option>
                    @foreach($brands as $brand)
                        <option value="{{ $brand->id }}" {{ old('brand_id', $product->brand_id) == $brand->id ? 'selected' : '' }}>
                            {{ $brand->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="space-y-1.5">
                <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider">Master SKU Identifier</label>
                <input type="text" name="sku" value="{{ old('sku', $product->sku) }}" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg text-xs font-semibold text-gray-900 font-mono placeholder-gray-400 focus:outline-none focus:border-primary focus:bg-white transition">
            </div>
        </div>

        <!-- Pricing & Stock -->
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
            <div class="space-y-1.5">
                <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider">Regular Price ($) *</label>
                <input type="number" step="0.01" name="price" value="{{ old('price', $product->price) }}" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg text-xs font-semibold text-gray-900 placeholder-gray-400 focus:outline-none focus:border-primary focus:bg-white transition" required>
            </div>

            <div class="space-y-1.5">
                <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider">Sale Price ($) (Optional)</label>
                <input type="number" step="0.01" name="sale_price" value="{{ old('sale_price', $product->sale_price) }}" placeholder="Leave blank if no discount" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg text-xs font-semibold text-gray-900 placeholder-gray-400 focus:outline-none focus:border-primary focus:bg-white transition">
            </div>

            <div class="space-y-1.5">
                <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider">Total Stock Inventory *</label>
                <input type="number" name="stock" value="{{ old('stock', $product->stock) }}" min="0" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg text-xs font-semibold text-gray-900 placeholder-gray-400 focus:outline-none focus:border-primary focus:bg-white transition" required>
            </div>
        </div>

        <!-- =========================================================================
             SECTION: SIZE & COLOR VARIATIONS MANAGEMENT
             ========================================================================= -->
        <div class="p-5 rounded-2xl bg-zinc-50 border border-zinc-200 space-y-4">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 border-b border-zinc-200 pb-3">
                <div>
                    <h3 class="font-bold text-xs text-gray-900 uppercase tracking-wider flex items-center gap-2">
                        <i class="fa-solid fa-layer-group text-primary"></i>
                        <span>Product Sizes &amp; Colors (Variants)</span>
                    </h3>
                    <p class="text-[11px] text-gray-500">Manage available size options (XS, S, M, L) and color swatches for this drop</p>
                </div>
                
                <button 
                    type="button" 
                    @click="addVariant('M', '#000000', 'Black')"
                    class="px-3 py-1.5 bg-black hover:bg-zinc-800 text-white text-[11px] font-bold rounded-lg flex items-center gap-1.5 shadow-xs transition cursor-pointer self-start sm:self-auto"
                >
                    <i class="fa-solid fa-plus text-[10px]"></i> Add Size/Color Option
                </button>
            </div>

            <!-- Quick Add Presets Bar -->
            <div class="flex flex-wrap items-center gap-4 bg-white p-3 rounded-xl border border-zinc-200 text-xs">
                <!-- Size chips -->
                <div class="flex items-center gap-1.5 flex-wrap">
                    <span class="text-[10px] font-bold text-gray-400 uppercase">Quick Sizes:</span>
                    <template x-for="sz in commonSizes" :key="sz">
                        <button type="button" @click="quickAddSize(sz)" class="px-2 py-0.5 rounded-md bg-zinc-100 hover:bg-black hover:text-white border border-zinc-300 text-[10px] font-bold transition cursor-pointer" x-text="'+ ' + sz"></button>
                    </template>
                </div>

                <div class="h-4 w-px bg-zinc-300 hidden sm:block"></div>

                <!-- Color swatches -->
                <div class="flex items-center gap-1.5 flex-wrap">
                    <span class="text-[10px] font-bold text-gray-400 uppercase">Quick Colors:</span>
                    <template x-for="col in commonColors" :key="col.name">
                        <button type="button" @click="quickAddColor(col)" class="flex items-center gap-1 px-2 py-0.5 rounded-md bg-zinc-100 hover:bg-zinc-200 border border-zinc-300 text-[10px] font-bold transition cursor-pointer">
                            <span class="w-2.5 h-2.5 rounded-full border border-zinc-400" :style="'background-color: ' + col.hex"></span>
                            <span x-text="col.name"></span>
                        </button>
                    </template>
                </div>
            </div>

            <!-- Dynamic Variations Table -->
            <div x-show="variants.length > 0" class="overflow-x-auto rounded-xl border border-zinc-200 bg-white">
                <table class="w-full text-left text-xs">
                    <thead>
                        <tr class="bg-zinc-100/70 text-gray-600 uppercase text-[10px] font-bold border-b border-zinc-200">
                            <th class="py-2.5 px-3">Option Name</th>
                            <th class="py-2.5 px-3">Size</th>
                            <th class="py-2.5 px-3">Color Swatch</th>
                            <th class="py-2.5 px-3">Stock</th>
                            <th class="py-2.5 px-3">Price ($) (Optional)</th>
                            <th class="py-2.5 px-3">SKU</th>
                            <th class="py-2.5 px-3 text-right">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-zinc-100 font-medium">
                        <template x-for="(v, vIdx) in variants" :key="vIdx">
                            <tr class="hover:bg-zinc-50/50">
                                <td class="py-2 px-3">
                                    <input type="text" :name="'variants[' + vIdx + '][name]'" x-model="v.name" placeholder="e.g. Black / M" class="w-full px-2.5 py-1.5 bg-zinc-50 border border-zinc-200 rounded text-xs font-semibold focus:outline-none focus:border-black">
                                </td>
                                <td class="py-2 px-3 w-28">
                                    <input type="text" :name="'variants[' + vIdx + '][size]'" x-model="v.size" placeholder="S, M, L..." class="w-full px-2.5 py-1.5 bg-zinc-50 border border-zinc-200 rounded text-xs font-bold uppercase focus:outline-none focus:border-black">
                                </td>
                                <td class="py-2 px-3 w-36">
                                    <div class="flex items-center gap-2">
                                        <input type="color" :name="'variants[' + vIdx + '][color]'" x-model="v.color" class="w-7 h-7 rounded border border-zinc-300 cursor-pointer p-0.5 shrink-0">
                                        <input type="text" x-model="v.color" placeholder="#000000" class="w-20 px-2 py-1 bg-zinc-50 border border-zinc-200 rounded text-[10px] font-mono uppercase">
                                    </div>
                                </td>
                                <td class="py-2 px-3 w-24">
                                    <input type="number" :name="'variants[' + vIdx + '][stock]'" x-model="v.stock" placeholder="10" class="w-full px-2.5 py-1.5 bg-zinc-50 border border-zinc-200 rounded text-xs font-bold focus:outline-none focus:border-black">
                                </td>
                                <td class="py-2 px-3 w-28">
                                    <input type="number" step="0.01" :name="'variants[' + vIdx + '][price]'" x-model="v.price" placeholder="Base" class="w-full px-2.5 py-1.5 bg-zinc-50 border border-zinc-200 rounded text-xs font-semibold focus:outline-none focus:border-black">
                                </td>
                                <td class="py-2 px-3 w-28">
                                    <input type="text" :name="'variants[' + vIdx + '][sku]'" x-model="v.sku" placeholder="VTL-BLK-M" class="w-full px-2.5 py-1.5 bg-zinc-50 border border-zinc-200 rounded text-xs font-mono uppercase focus:outline-none focus:border-black">
                                </td>
                                <td class="py-2 px-3 text-right">
                                    <button type="button" @click="removeVariant(vIdx)" class="p-1.5 rounded-lg bg-red-50 hover:bg-red-600 text-red-600 hover:text-white transition cursor-pointer" title="Remove Variation">
                                        <i class="fa-solid fa-trash text-xs"></i>
                                    </button>
                                </td>
                            </tr>
                        </template>
                    </tbody>
                </table>
            </div>

            <div x-show="variants.length === 0" class="p-4 text-center text-xs text-gray-400 italic bg-white rounded-xl border border-dashed border-zinc-300">
                No size or color variations configured. Click above to add sizes (XS, S, M, L) and color swatches!
            </div>
        </div>

        <!-- =========================================================================
             SECTION 1: PRIMARY MAIN COVER IMAGE
             ========================================================================= -->
        <div class="p-5 rounded-2xl bg-gray-50/70 border border-gray-200 space-y-4">
            <div class="flex items-center justify-between border-b border-gray-200 pb-3">
                <div>
                    <h3 class="font-bold text-xs text-gray-900 uppercase tracking-wider">Primary Showcase Image (Cover)</h3>
                    <p class="text-[11px] text-gray-500">Main thumbnail image for shop listings and banners</p>
                </div>
                <span class="text-[10px] font-bold px-2 py-0.5 rounded bg-blue-50 text-[#1b84ff] border border-blue-200">Current Cover</span>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-12 gap-4 items-center">
                <!-- Preview box -->
                <div class="sm:col-span-3 flex justify-center sm:justify-start">
                    <div class="w-24 h-28 rounded-xl bg-white border border-gray-300 overflow-hidden flex items-center justify-center p-1 shadow-xs">
                        <img :src="primaryPreview" class="w-full h-full object-cover rounded-lg" onerror="this.src='https://images.unsplash.com/photo-1518611012118-696072aa579a?w=400'">
                    </div>
                </div>

                <!-- Inputs -->
                <div class="sm:col-span-9 space-y-3">
                    <div>
                        <label class="block text-[11px] font-bold text-gray-700 mb-1">Upload New Cover File (Replaces Current):</label>
                        <input type="file" name="image_file" accept="image/*" @change="onPrimaryChange($event)" class="block w-full text-xs text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-[#1b84ff] file:text-white hover:file:bg-blue-600 cursor-pointer">
                    </div>
                    <div>
                        <label class="block text-[11px] font-semibold text-gray-500 mb-1">Or Direct Image URL:</label>
                        <input type="url" name="image" x-model="primaryPreview" placeholder="https://..." class="w-full px-3.5 py-2 rounded-lg bg-white border border-gray-200 text-gray-900 text-xs font-semibold focus:outline-none focus:border-primary transition">
                    </div>
                </div>
            </div>
        </div>

        <!-- =========================================================================
             SECTION 2: MULTIPLE GALLERY IMAGES MANAGEMENT
             ========================================================================= -->
        <div class="p-5 rounded-2xl bg-gray-50/70 border border-gray-200 space-y-4">
            <div class="flex items-center justify-between border-b border-gray-200 pb-3">
                <div>
                    <h3 class="font-bold text-xs text-gray-900 uppercase tracking-wider">Multiple Product Gallery Photos</h3>
                    <p class="text-[11px] text-gray-500">Manage multiple angles, model poses, and fabric details</p>
                </div>
                <span class="text-[10px] font-bold px-2 py-0.5 rounded bg-emerald-50 text-emerald-700 border border-emerald-200">
                    <span x-text="existingGallery.length"></span> Saved Photos
                </span>
            </div>

            <!-- Existing Gallery Photos Grid with Delete Actions -->
            <div x-show="existingGallery.length > 0" class="space-y-2">
                <label class="block text-xs font-bold text-gray-700">Currently Saved Gallery Photos:</label>
                <div class="grid grid-cols-3 sm:grid-cols-6 gap-3">
                    <template x-for="(img, idx) in existingGallery" :key="idx">
                        <div class="relative aspect-square rounded-xl bg-white border border-gray-200 overflow-hidden group shadow-xs">
                            <img :src="img" class="w-full h-full object-cover">
                            <!-- Hidden input to submit kept images -->
                            <input type="hidden" name="existing_gallery[]" :value="img">
                            <!-- Delete button -->
                            <button type="button" @click="removeExistingPhoto(idx)" class="absolute top-1 right-1 w-6 h-6 rounded-full bg-red-600 text-white flex items-center justify-center text-[10px] opacity-90 hover:opacity-100 transition shadow-md cursor-pointer" title="Delete Photo">
                                <i class="fa-solid fa-trash"></i>
                            </button>
                        </div>
                    </template>
                </div>
            </div>

            <!-- Multi-file uploader for NEW gallery photos -->
            <div class="space-y-2 pt-2">
                <label class="block text-xs font-bold text-gray-700">Upload Additional Gallery Photos (Select Multiple Files):</label>
                <div class="p-6 border-2 border-dashed border-gray-300 hover:border-[#1b84ff] rounded-2xl bg-white text-center cursor-pointer transition relative">
                    <input type="file" name="gallery_files[]" multiple accept="image/*" @change="onNewGalleryFiles($event)" class="absolute inset-0 opacity-0 cursor-pointer w-full h-full">
                    <i class="fa-solid fa-cloud-arrow-up text-2xl text-[#1b84ff] mb-2"></i>
                    <p class="text-xs font-bold text-gray-800">Click or Drag &amp; Drop to Add More Gallery Photos</p>
                    <p class="text-[10px] text-gray-400 mt-0.5">JPEG, PNG, WEBP up to 5MB each</p>
                </div>
            </div>

            <!-- New Gallery Preview Grid -->
            <template x-if="newGalleryPreviews.length > 0">
                <div class="space-y-2 pt-2">
                    <label class="block text-xs font-bold text-emerald-700">New Photos Ready to Upload (<span x-text="newGalleryPreviews.length"></span>):</label>
                    <div class="grid grid-cols-3 sm:grid-cols-6 gap-3">
                        <template x-for="(img, idx) in newGalleryPreviews" :key="idx">
                            <div class="relative aspect-square rounded-xl bg-white border border-emerald-300 overflow-hidden group shadow-xs">
                                <img :src="img" class="w-full h-full object-cover">
                                <button type="button" @click="removeNewPreview(idx)" class="absolute top-1 right-1 w-6 h-6 rounded-full bg-red-600 text-white flex items-center justify-center text-[10px] opacity-90 hover:opacity-100 transition shadow-md cursor-pointer" title="Cancel">
                                    <i class="fa-solid fa-xmark"></i>
                                </button>
                            </div>
                        </template>
                    </div>
                </div>
            </template>

            <!-- Or Add New Gallery Image URLs -->
            <div class="space-y-2 pt-3 border-t border-gray-200">
                <div class="flex items-center justify-between">
                    <label class="block text-[11px] font-bold text-gray-700">Add New Photo Web URLs:</label>
                    <button type="button" @click="addNewGalleryUrl()" class="px-2.5 py-1 bg-white border border-gray-300 hover:border-black rounded-lg text-[10px] font-bold text-gray-800 flex items-center gap-1 transition cursor-pointer">
                        <i class="fa-solid fa-plus text-[9px]"></i> Add Another URL
                    </button>
                </div>

                <div class="space-y-2">
                    <template x-for="(url, uIdx) in newGalleryUrls" :key="uIdx">
                        <div class="flex items-center gap-2">
                            <input type="url" name="gallery_urls[]" x-model="newGalleryUrls[uIdx]" placeholder="https://images.unsplash.com/..." class="flex-1 px-3.5 py-2 rounded-lg bg-white border border-gray-200 text-gray-900 text-xs font-semibold focus:outline-none focus:border-primary transition">
                            <button type="button" @click="removeNewGalleryUrl(uIdx)" x-show="newGalleryUrls.length > 1" class="w-8 h-8 rounded-lg bg-red-50 text-red-600 hover:bg-red-600 hover:text-white flex items-center justify-center transition cursor-pointer">
                                <i class="fa-solid fa-trash text-xs"></i>
                            </button>
                        </div>
                    </template>
                </div>
            </div>
        </div>

        <!-- Short Description -->
        <div class="space-y-1.5">
            <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider">Short Tagline Description *</label>
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
            <button type="submit" class="kt-btn kt-btn-primary text-xs font-semibold flex items-center gap-2 shadow-xs cursor-pointer px-6 py-3">
                <i class="fa-solid fa-floppy-disk text-xs"></i>
                <span>Update Drop Details</span>
            </button>
        </div>
    </form>
</div>
@endsection
