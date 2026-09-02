@extends('layouts.admin')

@section('title', 'Category & Hierarchy Management')
@section('breadcrumb', 'Catalog / Categories')

@section('content')
<div class="flex flex-col gap-6 lg:gap-8" x-data="{ 
    imgPreview: '',
    activeTab: 'all', // 'all' | 'main' | 'sub' | 'child'
    formType: 'main', // 'main' | 'sub' | 'child'
    selectedParentId: '',
    
    onFileChange(e) {
        const file = e.target.files[0];
        if (file) {
            this.imgPreview = URL.createObjectURL(file);
        }
    },
    
    setType(type) {
        this.formType = type;
        if (type === 'main') {
            this.selectedParentId = '';
        }
    }
}">
    
    <!-- Top Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-xl lg:text-2xl font-bold text-gray-900 tracking-tight">Category, Subcategory &amp; Child Categories</h1>
            <p class="text-xs text-gray-500 mt-0.5 font-medium">Manage top-level apparel collections, subcategories, and specific child fit types</p>
        </div>
        
        <!-- Category Statistics Pill Badges -->
        <div class="flex items-center gap-2 flex-wrap">
            <span class="px-3 py-1.5 rounded-lg bg-white border border-gray-200 text-xs font-bold text-gray-700 shadow-xs flex items-center gap-1.5">
                <span class="w-2 h-2 rounded-full bg-[#1b84ff]"></span>
                <span>Main: {{ $mainCategories->count() }}</span>
            </span>
            <span class="px-3 py-1.5 rounded-lg bg-white border border-gray-200 text-xs font-bold text-gray-700 shadow-xs flex items-center gap-1.5">
                <span class="w-2 h-2 rounded-full bg-amber-500"></span>
                <span>Sub: {{ $categories->where('level', 2)->count() }}</span>
            </span>
            <span class="px-3 py-1.5 rounded-lg bg-white border border-gray-200 text-xs font-bold text-gray-700 shadow-xs flex items-center gap-1.5">
                <span class="w-2 h-2 rounded-full bg-purple-500"></span>
                <span>Child: {{ $categories->where('level', 3)->count() }}</span>
            </span>
        </div>
    </div>

    <!-- Filter Tabs Bar -->
    <div class="flex items-center gap-2 border-b border-gray-200 pb-3 overflow-x-auto">
        <button 
            type="button" 
            @click="activeTab = 'all'"
            :class="activeTab === 'all' ? 'bg-black text-white shadow-xs' : 'bg-white text-gray-700 border border-gray-200 hover:bg-gray-100'"
            class="px-4 py-2 rounded-lg text-xs font-bold flex items-center gap-2 transition cursor-pointer shrink-0"
        >
            <i class="fa-solid fa-list-ul text-xs"></i>
            <span>All Categories ({{ $categories->count() }})</span>
        </button>

        <button 
            type="button" 
            @click="activeTab = 'main'"
            :class="activeTab === 'main' ? 'bg-[#1b84ff] text-white shadow-xs' : 'bg-white text-gray-700 border border-gray-200 hover:bg-gray-100'"
            class="px-4 py-2 rounded-lg text-xs font-bold flex items-center gap-2 transition cursor-pointer shrink-0"
        >
            <span>👑 1. Main Categories ({{ $mainCategories->count() }})</span>
        </button>

        <button 
            type="button" 
            @click="activeTab = 'sub'"
            :class="activeTab === 'sub' ? 'bg-amber-500 text-white shadow-xs' : 'bg-white text-gray-700 border border-gray-200 hover:bg-gray-100'"
            class="px-4 py-2 rounded-lg text-xs font-bold flex items-center gap-2 transition cursor-pointer shrink-0"
        >
            <span>📂 2. Subcategories ({{ $categories->where('level', 2)->count() }})</span>
        </button>

        <button 
            type="button" 
            @click="activeTab = 'child'"
            :class="activeTab === 'child' ? 'bg-purple-600 text-white shadow-xs' : 'bg-white text-gray-700 border border-gray-200 hover:bg-gray-100'"
            class="px-4 py-2 rounded-lg text-xs font-bold flex items-center gap-2 transition cursor-pointer shrink-0"
        >
            <span>📄 3. Child Categories ({{ $categories->where('level', 3)->count() }})</span>
        </button>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">
        
        <!-- Left: Categories Table (8 cols) -->
        <div class="lg:col-span-8 kt-card bg-white border border-gray-200/90 rounded-xl shadow-xs overflow-hidden">
            <div class="p-5 sm:p-6 border-b border-gray-100 flex justify-between items-center bg-gray-50/50">
                <div>
                    <h3 class="text-base font-bold text-gray-900" x-show="activeTab === 'all'">All Active Categories ({{ $categories->count() }})</h3>
                    <h3 class="text-base font-bold text-gray-900" x-show="activeTab === 'main'">👑 Main Categories (Level 1)</h3>
                    <h3 class="text-base font-bold text-gray-900" x-show="activeTab === 'sub'">📂 Subcategories (Level 2)</h3>
                    <h3 class="text-base font-bold text-gray-900" x-show="activeTab === 'child'">📄 Child Categories (Level 3)</h3>
                    <p class="text-[11px] text-gray-400">Live navigation structure on storefront</p>
                </div>
                <span class="px-2.5 py-1 rounded-full bg-emerald-50 text-emerald-700 text-xs font-bold border border-emerald-200">
                    Live on Storefront
                </span>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs">
                    <thead>
                        <tr class="text-gray-500 border-b border-gray-100 font-bold uppercase text-[10px] tracking-wider bg-gray-50/70">
                            <th class="py-3.5 px-6">Category Details</th>
                            <th class="py-3.5 px-6">Hierarchy Level &amp; Parent</th>
                            <th class="py-3.5 px-6">Products</th>
                            <th class="py-3.5 px-6 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 font-medium text-gray-700">
                        @forelse($categories as $cat)
                            <tr 
                                x-show="activeTab === 'all' || (activeTab === 'main' && {{ $cat->level }} === 1) || (activeTab === 'sub' && {{ $cat->level }} === 2) || (activeTab === 'child' && {{ $cat->level }} >= 3)"
                                class="hover:bg-gray-50/60 transition"
                            >
                                <td class="py-3.5 px-6">
                                    <div class="flex items-center gap-3">
                                        @if($cat->image)
                                            <img src="{{ $cat->image }}" alt="{{ $cat->name }}" class="w-11 h-11 rounded-lg object-cover bg-gray-100 border border-gray-200 shrink-0">
                                        @else
                                            <div class="w-11 h-11 rounded-lg bg-blue-50 text-[#1b84ff] flex items-center justify-center font-bold text-sm shrink-0">
                                                <i class="fa-solid {{ $cat->level == 1 ? 'fa-star' : ($cat->level == 2 ? 'fa-folder' : 'fa-file') }}"></i>
                                            </div>
                                        @endif
                                        <div>
                                            <div class="font-bold text-gray-900 text-xs flex items-center gap-1.5">
                                                @if($cat->level == 2)
                                                    <span class="text-gray-400 font-mono">↳</span>
                                                @elseif($cat->level >= 3)
                                                    <span class="text-gray-400 font-mono">&nbsp;&nbsp;↳</span>
                                                @endif
                                                <span>{{ $cat->name }}</span>
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
                                            👑 Main Category
                                        </span>
                                    @elseif($cat->level == 2)
                                        <div class="space-y-0.5">
                                            <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded text-[10px] font-bold bg-amber-50 text-amber-700 border border-amber-200">
                                                📂 Subcategory
                                            </span>
                                            <div class="text-[10px] text-gray-500 font-semibold">Under: <strong>{{ $cat->parent->name ?? 'None' }}</strong></div>
                                        </div>
                                    @else
                                        <div class="space-y-0.5">
                                            <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded text-[10px] font-bold bg-purple-50 text-purple-700 border border-purple-200">
                                                📄 Child Category
                                            </span>
                                            <div class="text-[10px] text-gray-500 font-semibold">Under: <strong>{{ $cat->parent->name ?? 'None' }}</strong></div>
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

        <!-- Right: Create Category Form (4 cols) -->
        <div class="lg:col-span-4 kt-card bg-white border border-gray-200/90 rounded-xl p-6 shadow-xs space-y-4">
            
            <div class="pb-3 border-b border-gray-100 flex items-center justify-between">
                <div>
                    <h3 class="text-base font-bold text-gray-900">Add New Category</h3>
                    <p class="text-[11px] text-gray-500">Choose level &amp; fill details</p>
                </div>
                <div class="w-8 h-8 rounded-lg bg-blue-50 text-[#1b84ff] flex items-center justify-center text-sm font-black">
                    <i class="fa-solid fa-folder-plus"></i>
                </div>
            </div>

            <form action="{{ route('admin.categories.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4 text-xs">
                @csrf
                
                <!-- 1. EXPLICIT CATEGORY TYPE SWITCHER BUTTONS -->
                <div class="space-y-1.5">
                    <label class="block font-bold text-gray-800 uppercase text-[10px] tracking-wider">Select Category Type *</label>
                    <div class="grid grid-cols-3 gap-1.5 p-1 bg-gray-100 rounded-xl border border-gray-200">
                        <button 
                            type="button" 
                            @click="setType('main')"
                            :class="formType === 'main' ? 'bg-white text-black font-black shadow-xs border border-gray-200' : 'text-gray-600 hover:text-black font-bold'"
                            class="py-2 px-1 rounded-lg text-[11px] text-center transition cursor-pointer flex flex-col items-center gap-0.5"
                        >
                            <span>👑 Main</span>
                            <span class="text-[9px] text-gray-400 font-normal">(Level 1)</span>
                        </button>

                        <button 
                            type="button" 
                            @click="setType('sub')"
                            :class="formType === 'sub' ? 'bg-amber-500 text-white font-black shadow-xs' : 'text-gray-600 hover:text-black font-bold'"
                            class="py-2 px-1 rounded-lg text-[11px] text-center transition cursor-pointer flex flex-col items-center gap-0.5"
                        >
                            <span>📂 Sub</span>
                            <span class="text-[9px] opacity-80 font-normal">(Level 2)</span>
                        </button>

                        <button 
                            type="button" 
                            @click="setType('child')"
                            :class="formType === 'child' ? 'bg-purple-600 text-white font-black shadow-xs' : 'text-gray-600 hover:text-black font-bold'"
                            class="py-2 px-1 rounded-lg text-[11px] text-center transition cursor-pointer flex flex-col items-center gap-0.5"
                        >
                            <span>📄 Child</span>
                            <span class="text-[9px] opacity-80 font-normal">(Level 3)</span>
                        </button>
                    </div>
                </div>

                <!-- DYNAMIC PARENT SELECTOR -->
                <!-- Level 1: Main Category Info -->
                <div x-show="formType === 'main'" class="p-3 bg-blue-50/70 rounded-xl border border-blue-100 text-[11px] text-blue-900 font-medium">
                    <i class="fa-solid fa-crown text-blue-600 mr-1"></i>
                    <strong>Main Top-Level Category:</strong> Appears directly on main navbar (e.g. <em>Women, Men, Accessories</em>).
                    <input type="hidden" name="parent_id" value="" :disabled="formType !== 'main'">
                </div>

                <!-- Level 2: Subcategory Parent Selector -->
                <div x-show="formType === 'sub'" class="space-y-1.5 p-3.5 bg-amber-50/60 rounded-xl border border-amber-200">
                    <label class="block font-bold text-amber-900 uppercase text-[10px]">Select Main Category Parent *</label>
                    <select name="parent_id" :disabled="formType !== 'sub'" class="w-full px-3.5 py-2.5 rounded-lg bg-white border border-amber-300 text-gray-900 font-bold focus:outline-none focus:border-amber-500 transition" required>
                        <option value="">-- Choose Main Category --</option>
                        @foreach($mainCategories as $mCat)
                            <option value="{{ $mCat->id }}">👑 {{ $mCat->name }}</option>
                        @endforeach
                    </select>
                    <p class="text-[10px] text-amber-800">e.g. <em>Leggings</em> under <em>Women's Activewear</em></p>
                </div>

                <!-- Level 3: Child Category Parent Selector -->
                <div x-show="formType === 'child'" class="space-y-1.5 p-3.5 bg-purple-50/60 rounded-xl border border-purple-200">
                    <label class="block font-bold text-purple-900 uppercase text-[10px]">Select Parent Subcategory *</label>
                    <select name="parent_id" :disabled="formType !== 'child'" class="w-full px-3.5 py-2.5 rounded-lg bg-white border border-purple-300 text-gray-900 font-bold focus:outline-none focus:border-purple-500 transition" required>
                        <option value="">-- Choose Parent Subcategory --</option>
                        @foreach($subCategories as $sCat)
                            <option value="{{ $sCat->id }}">
                                📂 {{ $sCat->name }} (Under {{ $sCat->parent->name ?? 'Main' }})
                            </option>
                        @endforeach
                    </select>
                    <p class="text-[10px] text-purple-800">e.g. <em>High Waisted Flare</em> under <em>Leggings</em></p>
                </div>

                <!-- Category Name -->
                <div class="space-y-1">
                    <label class="block font-bold text-gray-700 uppercase text-[10px]">Category Name *</label>
                    <input 
                        type="text" 
                        name="name" 
                        :placeholder="formType === 'main' ? 'e.g. Women, Men, Accessories' : (formType === 'sub' ? 'e.g. Leggings, Sports Bras, T-Shirts' : 'e.g. High Waisted, Flare, Oversized Pump Covers')" 
                        class="w-full px-4 py-2.5 rounded-lg bg-gray-50 border border-gray-200 text-gray-900 font-semibold focus:outline-none focus:border-primary focus:bg-white transition" 
                        required
                    >
                </div>

                <!-- Image Upload (File or URL) -->
                <div class="space-y-2 pt-1 border-t border-gray-100">
                    <label class="block font-bold text-gray-700 uppercase text-[10px]">Category Image / Icon</label>
                    
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

                    <div class="space-y-1 pt-1">
                        <label class="block font-semibold text-gray-500 text-[10px]">Or Direct Image URL:</label>
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
                    <span x-text="formType === 'main' ? 'Save Main Category' : (formType === 'sub' ? 'Save Subcategory' : 'Save Child Category')">Save Category</span>
                </button>
            </form>
        </div>

    </div>

</div>
@endsection