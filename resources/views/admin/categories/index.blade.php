@extends('layouts.admin')

@section('title', 'Category Management')
@section('breadcrumb', 'Catalog / Categories')

@section('content')
<div class="flex flex-col gap-6 lg:gap-8">
    
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-xl lg:text-2xl font-bold text-gray-900 tracking-tight">Apparel Categories</h1>
            <p class="text-xs text-gray-500 mt-0.5">Organize gymwear items into collections, drops, and sportswear types</p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">
        
        <!-- Left: Categories Table (8 cols) -->
        <div class="lg:col-span-8 kt-card bg-white border border-gray-200/90 rounded-xl shadow-xs overflow-hidden">
            <div class="p-6 border-b border-gray-100 flex justify-between items-center">
                <h3 class="text-base font-bold text-gray-900">Active Categories ({{ $categories->count() }})</h3>
                <span class="text-xs text-gray-500">Live on Storefront</span>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs">
                    <thead>
                        <tr class="text-gray-500 border-b border-gray-100 font-bold uppercase text-[10px] tracking-wider bg-gray-50/70">
                            <th class="py-3.5 px-6">Category Details</th>
                            <th class="py-3.5 px-6">Slug URL</th>
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
                                            <img src="{{ $cat->image }}" alt="{{ $cat->name }}" class="w-10 h-10 rounded-lg object-cover bg-gray-100 border border-gray-200">
                                        @else
                                            <div class="w-10 h-10 rounded-lg bg-blue-50 text-[#1b84ff] flex items-center justify-center font-bold text-xs">
                                                <i class="fa-solid fa-shapes"></i>
                                            </div>
                                        @endif
                                        <div>
                                            <div class="font-bold text-gray-900 text-xs">{{ $cat->name }}</div>
                                            <div class="text-[10px] text-gray-400 line-clamp-1">{{ $cat->description ?? 'Gym & Activewear apparel' }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-3.5 px-6 font-mono text-gray-500 text-xs">
                                    /category/{{ $cat->slug }}
                                </td>
                                <td class="py-3.5 px-6">
                                    <span class="kt-badge kt-badge-sm kt-badge-outline kt-badge-primary font-bold">
                                        {{ $cat->products_count }} Items
                                    </span>
                                </td>
                                <td class="py-3.5 px-6 text-right">
                                    <form action="{{ route('admin.categories.delete', $cat->id) }}" method="POST" onsubmit="return confirm('Delete this category? Associated products will be unassigned.');">
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
                                <td colspan="4" class="py-8 text-center text-gray-400 italic">No categories created yet.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Right: Add Category Form (4 cols) -->
        <div class="lg:col-span-4 kt-card bg-white border border-gray-200/90 rounded-xl p-6 shadow-xs space-y-4">
            <h3 class="text-base font-bold text-gray-900 pb-3 border-b border-gray-100">
                Add New Category
            </h3>

            <form action="{{ route('admin.categories.store') }}" method="POST" class="space-y-4 text-xs">
                @csrf
                <div class="space-y-1">
                    <label class="block font-bold text-gray-700 uppercase text-[10px]">Category Name</label>
                    <input type="text" name="name" placeholder="e.g. Seamless Sets" class="w-full px-4 py-2.5 rounded-lg bg-gray-50 border border-gray-200 text-gray-900 font-semibold focus:outline-none focus:border-primary focus:bg-white transition" required>
                </div>

                <div class="space-y-1">
                    <label class="block font-bold text-gray-700 uppercase text-[10px]">Cover Image URL</label>
                    <input type="url" name="image" placeholder="https://images.unsplash.com/..." class="w-full px-4 py-2.5 rounded-lg bg-gray-50 border border-gray-200 text-gray-900 font-semibold focus:outline-none focus:border-primary focus:bg-white transition">
                </div>

                <div class="space-y-1">
                    <label class="block font-bold text-gray-700 uppercase text-[10px]">Description</label>
                    <textarea name="description" rows="3" placeholder="Category highlights, fit characteristics..." class="w-full px-4 py-2.5 rounded-lg bg-gray-50 border border-gray-200 text-gray-900 font-semibold focus:outline-none focus:border-primary focus:bg-white transition"></textarea>
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