@extends('layouts.admin')

@section('title', 'Category & Hierarchy Management')
@section('breadcrumb', 'Catalog / Categories')

@section('content')
<div class="flex flex-col gap-6 lg:gap-8" x-data="{ 
    imgPreview: '',
    catLevel: 'main', // 'main' | 'sub' | 'child'
    onFileChange(e) {
        const file = e.target.files[0];
        if (file) {
            this.imgPreview = URL.createObjectURL(file);
        }
    }
}">
    
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-xl lg:text-2xl font-bold text-gray-900 tracking-tight">Apparel Categories & Hierarchy</h1>
            <p class="text-xs text-gray-500 mt-0.5">Organize Main Categories, Subcategories, and Child Categories with direct image uploads</p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">
        
        <!-- Left: Categories Table (8 cols) -->
        <div class="lg:col-span-8 kt-card bg-white border border-gray-200/90 rounded-xl shadow-xs overflow-hidden">
            <div class="p-5 sm:p-6 border-b border-gray-100 flex justify-between items-center bg-gray-50/50">
                <div>
                    <h3 class="text-base font-bold text-gray-900">All Categories ({{ $categories->count() }})</h3>
                    <p class="text-[11px] text-gray-400">Includes Main Categories, Subcategories &amp; Child levels</p>
                </div>
                <span class="px-2.5 py-1 rounded-full bg-emerald-50 text-emerald-700 text-xs font-bold border border-emerald-200">
                    Live on Storefront
                </span>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs">
                    <thead>
                        <tr class="text-gray-500 border-b border-gray-100 font-bold uppercase text-[10px] tracking-wider bg-gray-50/70">
                            <th class="py-3.5 px-6">Category / Hierarchy</th>
                            <th class="py-3.5 px-6">Level / Parent</th>
                            <th class="py-3.5 px-6">Total Products</th>
                            <th class="py-3.5 px-6 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 font-medium text-gray-700">
                        @forelse($categories as $cat)
                            <tr class="hover:bg-gray-50/60 transition">
                                <td class="py-3.5 px-6">
                                    <div class="flex items-center gap-3">
                                        @if($cat->image)
                                            <img src="{{ $cat->image }}" alt="{{ $cat->name }}" class="w-11 h-11 rounded-lg object-cover bg-gray-100 border border-gray-200 shrink-0">
                                        @else
                                            <div class="w-11 h-11 rounded-lg bg-blue-50 text-[#1b84ff] flex items-center justify-center font-bold text-sm shrink-0">
                                                <i class="fa-solid fa-layer-group"></i>
                                            </div>
                                        @endif
                                        <div>
                                            <div class="font-bold text-gray-900 text-xs flex items-center gap-1.5">
                                                {{ $cat->name }}
                                            </div>
                                            <div class="text-[10px] text-gray-400 font-mono">
                                                /category/{{ $cat->slug }}
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-3.5 px-6">
                                    @if($cat->level == 1)
                                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-md text-[10px] font-black bg-blue-50 text-[#1b84ff] border border-blue-200">
                                            <i class="fa-solid fa-star text-[9px]"></i> Main Category
                                        </span>
                                    @elseif($cat->level == 2)
                                        <div class="space-y-0.5">
                                            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded text-[10px] font-bold bg-amber-50 text-amber-700 border border-amber-200">
                                                Subcategory
                                            </span>
                                            <div class="text-[10px] text-gray-500 font-semibold">Under: <strong>{{ $cat->parent->name ?? 'None' }}</strong></div>
                                        </div>
                                    @else
                                        <div class="space-y-0.5">
                                            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded text-[10px] font-bold bg-purple-50 text-purple-700 border border-purple-200">
                                                Child Category
                                            </span>
                                            <div class="text-[10px] text-gray-500">{!! $cat->hierarchy_name !!}</div>
                                        </div>
                                    @endif
                                </td>
                                <td class="py-3.5 px-6">
                                    <span class="kt-badge kt-badge-sm kt-badge-outline kt-badge-primary font-bold">
                                        {{ $cat->products_count }} Products
                                    </span>
                                </td>
                                <td class="py-3.5 px-6 text-right">
                                    <form action="{{ route('admin.categories.delete', $cat->id) }}" method="POST" onsubmit="return confirm('Delete this category? Products will remain safe.');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-2 rounded-lg bg-rose-50 hover:bg-rose-600 text-rose-600 hover:text-white transition cursor-pointer" title="Delete Category">
                                            <i class="fa-solid fa-trash text-xs"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="py-12 text-center text-gray-400 italic">No categories created yet. Use the form to create your first category or subcategory.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Right: Add Category Form (4 cols) -->
        <div class="lg:col-span-4 kt-card bg-white border border-gray-200/90 rounded-xl p-6 shadow-xs space-y-4">
            <h3 class="text-base font-bold text-gray-900 pb-3 border-b border-gray-100 flex items-center justify-between">
                <span>Add Category / Subcategory</span>
                <i class="fa-solid fa-folder-plus text-[#1b84ff]"></i>
            </h3>

            <form action="{{ route('admin.categories.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4 text-xs">
                @csrf
                
                <!-- Category Name -->
                <div class="space-y-1">
                    <label class="block font-bold text-gray-700 uppercase text-[10px]">Category Name *</label>
                    <input type="text" name="name" placeholder="e.g. Leggings, Power Tanks, Sports Bras" class="w-full px-4 py-2.5 rounded-lg bg-gray-50 border border-gray-200 text-gray-900 font-semibold focus:outline-none focus:border-primary focus:bg-white transition" required>
                </div>

                <!-- Hierarchy Level Selection -->
                <div class="space-y-1">
                    <label class="block font-bold text-gray-700 uppercase text-[10px]">Category Hierarchy Level</label>
                    <select name="parent_id" class="w-full px-4 py-2.5 rounded-lg bg-gray-50 border border-gray-200 text-gray-900 font-semibold focus:outline-none focus:border-primary focus:bg-white transition">
                        <option value="">👑 Top Level (Main Category)</option>
                        @foreach($parentCategories as $pCat)
                            <option value="{{ $pCat->id }}">
                                ↳ Sub / Child of: {{ $pCat->name }} {{ $pCat->parent ? '('.$pCat->parent->name.')' : '' }}
                            </option>
                        @endforeach
                    </select>
                    <span class="text-[10px] text-gray-400">Leave as 'Top Level' for main categories like Women, Men, Accessories.</span>
                </div>

                <!-- Image Upload (File or URL) -->
                <div class="space-y-2 pt-1 border-t border-gray-100">
                    <label class="block font-bold text-gray-700 uppercase text-[10px]">Category Image / Banner</label>
                    
                    <!-- Live Image Preview Frame -->
                    <div class="flex items-center gap-3">
                        <div class="w-14 h-14 rounded-xl bg-gray-100 border border-gray-200 overflow-hidden flex items-center justify-center shrink-0">
                            <template x-if="imgPreview">
                                <img :src="imgPreview" class="w-full h-full object-cover">
                            </template>
                            <template x-if="!imgPreview">
                                <i class="fa-solid fa-image text-gray-400 text-base"></i>
                            </template>
                        </div>
                        
                        <div class="flex-1 space-y-1.5">
                            <label class="px-3 py-2 bg-gray-100 hover:bg-gray-200 rounded-lg text-[11px] font-bold text-gray-800 flex items-center justify-center gap-1.5 cursor-pointer transition">
                                <i class="fa-solid fa-cloud-arrow-up text-xs"></i>
                                <span>Upload Image File</span>
                                <input type="file" name="image_file" accept="image/*" @change="onFileChange($event)" class="hidden">
                            </label>
                        </div>
                    </div>

                    <!-- Direct Image URL Alternative -->
                    <div class="space-y-1 pt-1">
                        <label class="block font-semibold text-gray-500 text-[10px]">Or Image URL (Web Link):</label>
                        <input type="url" name="image" x-on:input="imgPreview = $event.target.value" placeholder="https://images.unsplash.com/..." class="w-full px-3.5 py-2 rounded-lg bg-gray-50 border border-gray-200 text-gray-900 text-xs font-semibold focus:outline-none focus:border-primary focus:bg-white transition">
                    </div>
                </div>

                <!-- Description -->
                <div class="space-y-1">
                    <label class="block font-bold text-gray-700 uppercase text-[10px]">Description (Optional)</label>
                    <textarea name="description" rows="2" placeholder="Category highlights, fit characteristics..." class="w-full px-4 py-2.5 rounded-lg bg-gray-50 border border-gray-200 text-gray-900 font-semibold focus:outline-none focus:border-primary focus:bg-white transition"></textarea>
                </div>

                <button type="submit" class="w-full kt-btn kt-btn-primary text-xs font-semibold flex items-center justify-center gap-1.5 shadow-xs cursor-pointer py-3">
                    <i class="fa-solid fa-plus text-xs"></i>
                    <span>Save Category</span>
                </button>
            </form>
        </div>

    </div>

</div>
@endsection