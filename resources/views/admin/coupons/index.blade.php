@extends('layouts.admin')

@section('title', 'Promo Codes & Coupon Engine')
@section('breadcrumb', 'Marketing / Coupons')

@section('content')
<div class="flex flex-col gap-6 lg:gap-8">
    
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-xl lg:text-2xl font-bold text-gray-900 tracking-tight">Promo Codes & Coupon Engine</h1>
            <p class="text-xs text-gray-500 mt-0.5">Configure automated discount vouchers, athlete VIP drops, and seasonal sales</p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">
        
        <!-- Left: Active Coupons Table (8 cols) -->
        <div class="lg:col-span-8 kt-card bg-white border border-gray-200/90 rounded-xl shadow-xs overflow-hidden">
            <div class="p-6 border-b border-gray-100 flex justify-between items-center">
                <h3 class="text-base font-bold text-gray-900">Active Promotion Vouchers</h3>
                <span class="text-xs font-semibold text-gray-500">{{ $coupons->count() }} active codes</span>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs">
                    <thead>
                        <tr class="text-gray-500 border-b border-gray-100 font-bold uppercase text-[10px] tracking-wider bg-gray-50/70">
                            <th class="py-3.5 px-6">Coupon Code</th>
                            <th class="py-3.5 px-6">Discount</th>
                            <th class="py-3.5 px-6">Min Spend</th>
                            <th class="py-3.5 px-6">Usage Count</th>
                            <th class="py-3.5 px-6 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 font-medium text-gray-700">
                        @forelse($coupons as $coup)
                            <tr class="hover:bg-gray-50/60 transition">
                                <td class="py-3.5 px-6">
                                    <span class="px-3 py-1 rounded-lg bg-blue-50 text-primary font-mono font-bold border border-blue-100">
                                        {{ $coup->code }}
                                    </span>
                                </td>
                                <td class="py-3.5 px-6 text-emerald-600 font-bold">
                                    {{ $coup->type === 'percentage' ? $coup->value . '% OFF' : '$' . number_format($coup->value, 2) . ' FIXED' }}
                                </td>
                                <td class="py-3.5 px-6 text-gray-600">
                                    {{ $coup->min_spend ? '$' . number_format($coup->min_spend, 2) : 'No Min' }}
                                </td>
                                <td class="py-3.5 px-6 text-gray-500 text-[11px]">
                                    {{ $coup->used_count }} / {{ $coup->usage_limit ?? '∞' }}
                                </td>
                                <td class="py-3.5 px-6 text-right">
                                    <form action="{{ route('admin.coupons.delete', $coup->id) }}" method="POST" onsubmit="return confirm('Delete this coupon?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-2 rounded-lg bg-rose-50 hover:bg-rose-600 text-rose-600 hover:text-white transition cursor-pointer" title="Delete Coupon">
                                            <i class="fa-solid fa-trash text-xs"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="py-8 text-center text-gray-400 italic">No coupons created yet.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Right: Create Coupon Form (4 cols) -->
        <div class="lg:col-span-4 kt-card bg-white border border-gray-200/90 rounded-xl p-6 shadow-xs space-y-4">
            <h3 class="text-base font-bold text-gray-900 pb-3 border-b border-gray-100">
                Create Promotion Voucher
            </h3>

            <form action="{{ route('admin.coupons.store') }}" method="POST" class="space-y-4 text-xs">
                @csrf
                <div class="space-y-1">
                    <label class="block font-bold text-gray-700 uppercase text-[10px]">Coupon Code</label>
                    <input type="text" name="code" placeholder="e.g. GYM20" class="w-full px-4 py-2.5 rounded-lg bg-gray-50 border border-gray-200 text-gray-900 font-mono font-bold uppercase focus:outline-none focus:border-primary focus:bg-white transition" required>
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div class="space-y-1">
                        <label class="block font-bold text-gray-700 uppercase text-[10px]">Type</label>
                        <select name="type" class="w-full px-3 py-2.5 rounded-lg bg-gray-50 border border-gray-200 text-gray-900 font-semibold focus:outline-none focus:border-primary focus:bg-white transition">
                            <option value="percentage">% Percent</option>
                            <option value="fixed">$ Fixed</option>
                        </select>
                    </div>

                    <div class="space-y-1">
                        <label class="block font-bold text-gray-700 uppercase text-[10px]">Discount Value</label>
                        <input type="number" step="0.01" name="value" placeholder="20" class="w-full px-3 py-2.5 rounded-lg bg-gray-50 border border-gray-200 text-gray-900 font-semibold focus:outline-none focus:border-primary focus:bg-white transition" required>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div class="space-y-1">
                        <label class="block font-bold text-gray-700 uppercase text-[10px]">Min Spend ($)</label>
                        <input type="number" step="0.01" name="min_spend" placeholder="50.00" class="w-full px-3 py-2.5 rounded-lg bg-gray-50 border border-gray-200 text-gray-900 font-semibold focus:outline-none focus:border-primary focus:bg-white transition">
                    </div>

                    <div class="space-y-1">
                        <label class="block font-bold text-gray-700 uppercase text-[10px]">Usage Limit</label>
                        <input type="number" name="usage_limit" placeholder="100" class="w-full px-3 py-2.5 rounded-lg bg-gray-50 border border-gray-200 text-gray-900 font-semibold focus:outline-none focus:border-primary focus:bg-white transition">
                    </div>
                </div>

                <button type="submit" class="w-full kt-btn kt-btn-primary text-xs font-semibold flex items-center justify-center gap-1.5 shadow-xs cursor-pointer py-3">
                    <i class="fa-solid fa-plus text-xs"></i>
                    <span>Activate Coupon</span>
                </button>
            </form>
        </div>

    </div>

</div>
@endsection