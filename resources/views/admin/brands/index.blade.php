@extends('layouts.admin')

@section('title', 'Brand Management')
@section('breadcrumb', 'Catalog / Brands')

@section('content')
<div class="flex flex-col gap-6 lg:gap-8" x-data="{
    logoPreview: '',
    onLogoChange(e) {
        const file = e.target.files[0];
        if (file) {
            this.logoPreview = URL.createObjectURL(file);
        }
    }
}">
    
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-xl lg:text-2xl font-bold text-gray-900 tracking-tight">Activewear Brands</h1>
            <p class="text-xs text-gray-500 mt-0.5">Manage apparel partner brands, official suppliers, and in-house labels with logo image upload</p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">
        
        <!-- Left: Brands Table (8 cols) -->
        <div class="lg:col-span-8 kt-card bg-white border border-gray-200/90 rounded-xl shadow-xs overflow-hidden">
            <div class="p-5 sm:p-6 border-b border-gray-100 flex justify-between items-center bg-gray-50/50">
                <h3 class="text-base font-bold text-gray-900">Partner Brands ({{ $brands->count() }})</h3>
                <span class="px-2.5 py-1 rounded-full bg-purple-50 text-purple-700 text-xs font-bold border border-purple-200">
                    Official Labels
                </span>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs">
                    <thead>
                        <tr class="text-gray-500 border-b border-gray-100 font-bold uppercase text-[10px] tracking-wider bg-gray-50/70">
                            <th class="py-3.5 px-6">Brand Details</th>
                            <th class="py-3.5 px-6">Slug</th>
                            <th class="py-3.5 px-6">Total Drops</th>
                            <th class="py-3.5 px-6 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 font-medium text-gray-700">
                        @forelse($brands as $brand)
                            <tr class="hover:bg-gray-50/60 transition">
                                <td class="py-3.5 px-6">
                                    <div class="flex items-center gap-3">
                                        @if($brand->logo)
                                            <img src="{{ $brand->logo }}" alt="{{ $brand->name }}" class="w-10 h-10 rounded-lg object-contain bg-gray-50 p-1 border border-gray-200 shrink-0">
                                        @else
                                            <div class="w-10 h-10 rounded-lg bg-purple-50 text-purple-600 flex items-center justify-center font-bold text-xs shrink-0">
                                                <i class="fa-solid fa-tag"></i>
                                            </div>
                                        @endif
                                        <div>
                                            <div class="font-bold text-gray-900 text-xs">{{ $brand->name }}</div>
                                            <div class="text-[10px] text-gray-400 line-clamp-1">{{ $brand->description ?? 'Official activewear label' }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-3.5 px-6 font-mono text-gray-500 text-xs">
                                    {{ $brand->slug }}
                                </td>
                                <td class="py-3.5 px-6">
                                    <span class="kt-badge kt-badge-sm kt-badge-outline kt-badge-info font-bold">
                                        {{ $brand->products_count }} Products
                                    </span>
                                </td>
                                <td class="py-3.5 px-6 text-right">
                                    <form action="{{ route('admin.brands.delete', $brand->id) }}" method="POST" onsubmit="return confirm('Delete this brand?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-2 rounded-lg bg-rose-50 hover:bg-rose-600 text-rose-600 hover:text-white transition cursor-pointer" title="Delete Brand">
                                            <i class="fa-solid fa-trash text-xs"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="py-12 text-center text-gray-400 italic">No brands added yet.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Right: Add Brand Form (4 cols) -->
        <div class="lg:col-span-4 kt-card bg-white border border-gray-200/90 rounded-xl p-6 shadow-xs space-y-4">
            <h3 class="text-base font-bold text-gray-900 pb-3 border-b border-gray-100 flex items-center justify-between">
                <span>Register New Brand</span>
                <i class="fa-solid fa-award text-purple-600"></i>
            </h3>

            <form action="{{ route('admin.brands.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4 text-xs">
                @csrf
                
                <div class="space-y-1">
                    <label class="block font-bold text-gray-700 uppercase text-[10px]">Brand Name *</label>
                    <input type="text" name="name" placeholder="e.g. Gymshark, SM Pro Active" class="w-full px-4 py-2.5 rounded-lg bg-gray-50 border border-gray-200 text-gray-900 font-semibold focus:outline-none focus:border-primary focus:bg-white transition" required>
                </div>

                <!-- Brand Logo (File Upload or URL) -->
                <div class="space-y-2 pt-1 border-t border-gray-100">
                    <label class="block font-bold text-gray-700 uppercase text-[10px]">Brand Logo Image</label>
                    
                    <div class="flex items-center gap-3">
                        <div class="w-14 h-14 rounded-xl bg-gray-100 border border-gray-200 overflow-hidden flex items-center justify-center p-1 shrink-0">
                            <template x-if="logoPreview">
                                <img :src="logoPreview" class="w-full h-full object-contain">
                            </template>
                            <template x-if="!logoPreview">
                                <i class="fa-solid fa-award text-gray-400 text-base"></i>
                            </template>
                        </div>
                        
                        <div class="flex-1 space-y-1.5">
                            <label class="px-3 py-2 bg-gray-100 hover:bg-gray-200 rounded-lg text-[11px] font-bold text-gray-800 flex items-center justify-center gap-1.5 cursor-pointer transition">
                                <i class="fa-solid fa-cloud-arrow-up text-xs"></i>
                                <span>Upload Logo File</span>
                                <input type="file" name="logo_file" accept="image/*" @change="onLogoChange($event)" class="hidden">
                            </label>
                        </div>
                    </div>

                    <div class="space-y-1 pt-1">
                        <label class="block font-semibold text-gray-500 text-[10px]">Or Logo URL (Web Link):</label>
                        <input type="url" name="logo" x-on:input="logoPreview = $event.target.value" placeholder="https://..." class="w-full px-3.5 py-2 rounded-lg bg-gray-50 border border-gray-200 text-gray-900 text-xs font-semibold focus:outline-none focus:border-primary focus:bg-white transition">
                    </div>
                </div>

                <div class="space-y-1">
                    <label class="block font-bold text-gray-700 uppercase text-[10px]">Description (Optional)</label>
                    <textarea name="description" rows="2" placeholder="Brand story, official warranty..." class="w-full px-4 py-2.5 rounded-lg bg-gray-50 border border-gray-200 text-gray-900 font-semibold focus:outline-none focus:border-primary focus:bg-white transition"></textarea>
                </div>

                <button type="submit" class="w-full kt-btn kt-btn-primary text-xs font-semibold flex items-center justify-center gap-1.5 shadow-xs cursor-pointer py-3">
                    <i class="fa-solid fa-plus text-xs"></i>
                    <span>Register Brand</span>
                </button>
            </form>
        </div>

    </div>

</div>
@endsection