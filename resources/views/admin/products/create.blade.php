@extends('layouts.admin')

@section('title', 'Add New Activewear Drop')
@section('breadcrumb', 'Catalog / Add Product')

@section('content')
<div class="max-w-5xl mx-auto flex flex-col gap-6" x-data="{
    primaryPreview: '',
    galleryPreviews: [],
    galleryUrls: [''],
    variants: [],
    
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
    onGalleryFilesChange(e) {
        const files = Array.from(e.target.files);
        files.forEach(f => {
            this.galleryPreviews.push(URL.createObjectURL(f));
        });
    },
    removeGalleryPreview(index) {
        this.galleryPreviews.splice(index, 1);
    },
    addGalleryUrl() {
        this.galleryUrls.push('');
    },
    removeGalleryUrl(index) {
        this.galleryUrls.splice(index, 1);
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
            <h1 class="text-xl lg:text-2xl font-bold text-gray-900 tracking-tight">Add New Activewear Drop</h1>
            <p class="text-xs text-gray-500 mt-0.5 font-medium">Publish new gym apparel with sizes, color swatches, multiple photos, and inventory</p>
        </div>
        <a href="{{ route('admin.products.index') }}" class="kt-btn kt-btn-outline kt-btn-sm text-xs font-semibold flex items-center gap-1.5 text-gray-700">
            <i class="fa-solid fa-arrow-left text-xs"></i> Back to Catalog
        </a>
    </div>

    <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data" class="p-6 sm:p-8 rounded-xl bg-white border border-gray-200/90 shadow-xs space-y-6">
        @csrf

        <!-- Basic Information -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="space-y-1.5">
                <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider">Product Name *</label>
                <input type="text" name="name" placeholder="e.g. Vital Seamless 2.0 High Waisted Leggings" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg text-xs font-semibold text-gray-900 placeholder-gray-400 focus:outline-none focus:border-primary focus:bg-white transition" required>
            </div>

            <div class="space-y-1.5">
                <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider">Apparel Category & Hierarchy *</label>
                <select name="category_id" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg text-xs font-semibold text-gray-900 focus:outline-none focus:border-primary focus:bg-white transition" required>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}">
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
                <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider">Partner Brand Label (Optional)</label>
                <select name="brand_id" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg text-xs font-semibold text-gray-900 focus:outline-none focus:border-primary focus:bg-white transition">
                    <option value="">-- No Brand (In-House SM Label) --</option>
                    @foreach($brands as $brand)
                        <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="space-y-1.5">
                <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider">Master SKU Identifier</label>
                <input type="text" name="sku" placeholder="VTL-SMS-001" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg text-xs font-semibold text-gray-900 font-mono placeholder-gray-400 focus:outline-none focus:border-primary focus:bg-white transition">
            </div>
        </div>

        <!-- Pricing & Stock -->
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
            <div class="space-y-1.5">
                <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider">Regular Price ($) *</label>
                <input type="number" step="0.01" name="price" placeholder="54.00" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg text-xs font-semibold text-gray-900 placeholder-gray-400 focus:outline-none focus:border-primary focus:bg-white transition" required>
            </div>

            <div class="space-y-1.5">
                <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider">Sale Price ($) (Optional)</label>
                <input type="number" step="0.01" name="sale_price" placeholder="44.00" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg text-xs font-semibold text-gray-900 placeholder-gray-400 focus:outline-none focus:border-primary focus:bg-white transition">
            </div>

            <div class="space-y-1.5">
                <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider">Total Stock Units *</label>
                <input type="number" name="stock" value="50" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg text-xs font-semibold text-gray-900 placeholder-gray-400 focus:outline-none focus:border-primary focus:bg-white transition" required>
            </div>
        </div>

        <!-- =========================================================================
             SECTION: SIZE & COLOR VARIATIONS BUILDER
             ========================================================================= -->
        <div class="p-5 rounded-2xl bg-zinc-50 border border-zinc-200 space-y-4">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 border-b border-zinc-200 pb-3">
                <div>
                    <h3 class="font-bold text-xs text-gray-900 uppercase tracking-wider flex items-center gap-2">
                        <i class="fa-solid fa-layer-group text-primary"></i>
                        <span>Product Sizes &amp; Colors (Variants)</span>
                    </h3>
                    <p class="text-[11px] text-gray-500">Add different sizes (XS, S, M, L, XL) and color swatches for customers to choose</p>
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
                No size or color variations added. Click the buttons above to add sizes (XS, S, M, L) and colors!
            </div>
        </div>

        <!-- =========================================================================
             SECTION 1: PRIMARY MAIN PRODUCT IMAGE
             ========================================================================= -->
        <div class="p-5 rounded-2xl bg-gray-50/70 border border-gray-200 space-y-4">
            <div class="flex items-center justify-between border-b border-gray-200 pb-3">
                <div>
                    <h3 class="font-bold text-xs text-gray-900 uppercase tracking-wider">Primary Showcase Image (Cover)</h3>
                    <p class="text-[11px] text-gray-500">Main cover image displayed on catalog cards and store banners</p>
                </div>
                <span class="text-[10px] font-bold px-2 py-0.5 rounded bg-blue-50 text-[#1b84ff] border border-blue-200">Required</span>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-12 gap-4 items-center">
                <!-- Preview box -->
                <div class="sm:col-span-3 flex justify-center sm:justify-start">
                    <div class="w-24 h-28 rounded-xl bg-white border border-gray-300 overflow-hidden flex items-center justify-center p-1 shadow-xs">
                        <template x-if="primaryPreview">
                            <img :src="primaryPreview" class="w-full h-full object-cover rounded-lg">
                        </template>
                        <template x-if="!primaryPreview">
                            <div class="text-center p-2 text-gray-400">
                                <i class="fa-solid fa-image text-2xl mb-1"></i>
                                <div class="text-[9px] font-bold">Cover Preview</div>
                            </div>
                        </template>
                    </div>
                </div>

                <!-- Inputs -->
                <div class="sm:col-span-9 space-y-3">
                    <div>
                        <label class="block text-[11px] font-bold text-gray-700 mb-1">Upload Primary Image File:</label>
                        <input type="file" name="image_file" accept="image/*" @change="onPrimaryChange($event)" class="block w-full text-xs text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-[#1b84ff] file:text-white hover:file:bg-blue-600 cursor-pointer">
                    </div>
                    <div>
                        <label class="block text-[11px] font-semibold text-gray-500 mb-1">Or Paste Direct Image URL:</label>
                        <input type="url" name="image" x-on:input="primaryPreview = $event.target.value" placeholder="https://images.unsplash.com/..." class="w-full px-3.5 py-2 rounded-lg bg-white border border-gray-200 text-gray-900 text-xs font-semibold focus:outline-none focus:border-primary transition">
                    </div>
                </div>
            </div>
        </div>

        <!-- =========================================================================
             SECTION 2: MULTIPLE GALLERY IMAGES
             ========================================================================= -->
        <div class="p-5 rounded-2xl bg-gray-50/70 border border-gray-200 space-y-4">
            <div class="flex items-center justify-between border-b border-gray-200 pb-3">
                <div>
                    <h3 class="font-bold text-xs text-gray-900 uppercase tracking-wider">Multiple Product Gallery Images</h3>
                    <p class="text-[11px] text-gray-500">Upload multiple side angles, back view, fabric close-ups, and on-model photos</p>
                </div>
                <span class="text-[10px] font-bold px-2 py-0.5 rounded bg-emerald-50 text-emerald-700 border border-emerald-200">Multiple Photos</span>
            </div>

            <!-- Multi-file uploader -->
            <div class="space-y-2">
                <label class="block text-xs font-bold text-gray-700">Upload Multiple Photos (Select Multiple Files at Once):</label>
                <div class="p-6 border-2 border-dashed border-gray-300 hover:border-[#1b84ff] rounded-2xl bg-white text-center cursor-pointer transition relative">
                    <input type="file" name="gallery_files[]" multiple accept="image/*" @change="onGalleryFilesChange($event)" class="absolute inset-0 opacity-0 cursor-pointer w-full h-full">
                    <i class="fa-solid fa-images text-2xl text-[#1b84ff] mb-2"></i>
                    <p class="text-xs font-bold text-gray-800">Drag & Drop or Click to Select Multiple Gallery Images</p>
                    <p class="text-[10px] text-gray-400 mt-0.5">JPEG, PNG, WEBP, AVIF up to 5MB each</p>
                </div>
            </div>

            <!-- Live Gallery Preview Grid -->
            <template x-if="galleryPreviews.length > 0">
                <div class="space-y-2 pt-2">
                    <label class="block text-xs font-bold text-gray-700">Selected Gallery Photos Preview (<span x-text="galleryPreviews.length"></span>):</label>
                    <div class="grid grid-cols-3 sm:grid-cols-6 gap-3">
                        <template x-for="(img, idx) in galleryPreviews" :key="idx">
                            <div class="relative aspect-square rounded-xl bg-white border border-gray-200 overflow-hidden group shadow-xs">
                                <img :src="img" class="w-full h-full object-cover">
                                <button type="button" @click="removeGalleryPreview(idx)" class="absolute top-1 right-1 w-6 h-6 rounded-full bg-red-600 text-white flex items-center justify-center text-[10px] opacity-90 hover:opacity-100 transition shadow-md cursor-pointer" title="Remove Photo">
                                    <i class="fa-solid fa-xmark"></i>
                                </button>
                            </div>
                        </template>
                    </div>
                </div>
            </template>

            <!-- Or Add Gallery Image URLs -->
            <div class="space-y-2 pt-3 border-t border-gray-200">
                <div class="flex items-center justify-between">
                    <label class="block text-[11px] font-bold text-gray-700">Or Add Gallery Image URLs:</label>
                    <button type="button" @click="addGalleryUrl()" class="px-2.5 py-1 bg-white border border-gray-300 hover:border-black rounded-lg text-[10px] font-bold text-gray-800 flex items-center gap-1 transition cursor-pointer">
                        <i class="fa-solid fa-plus text-[9px]"></i> Add Another URL
                    </button>
                </div>

                <div class="space-y-2">
                    <template x-for="(url, uIdx) in galleryUrls" :key="uIdx">
                        <div class="flex items-center gap-2">
                            <input type="url" name="gallery_urls[]" x-model="galleryUrls[uIdx]" placeholder="https://images.unsplash.com/..." class="flex-1 px-3.5 py-2 rounded-lg bg-white border border-gray-200 text-gray-900 text-xs font-semibold focus:outline-none focus:border-primary transition">
                            <button type="button" @click="removeGalleryUrl(uIdx)" x-show="galleryUrls.length > 1" class="w-8 h-8 rounded-lg bg-red-50 text-red-600 hover:bg-red-600 hover:text-white flex items-center justify-center transition cursor-pointer">
                                <i class="fa-solid fa-trash text-xs"></i>
                            </button>
                        </div>
                    </template>
                </div>
            </div>
        </div>

        <!-- Tagline & Descriptions -->
        <div class="space-y-1.5">
            <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider">Short Tagline Description *</label>
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
            <button type="submit" class="kt-btn kt-btn-primary text-xs font-semibold flex items-center gap-2 shadow-xs cursor-pointer px-6 py-3">
                <i class="fa-solid fa-cloud-arrow-up text-xs"></i>
                <span>Publish Drop with Sizes &amp; Gallery</span>
            </button>
        </div>
    </form>
</div>
@endsection