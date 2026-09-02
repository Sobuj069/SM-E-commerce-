@extends('layouts.admin')

@section('title', 'Discount & Coupon Engine')
@section('breadcrumb', 'Marketing / Coupons')

@section('content')
<div class="space-y-8">
    
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-xl font-black text-white">Promo Codes & Coupon Engine</h1>
            <p class="text-xs text-gray-400 mt-0.5">Configure automated discount vouchers, athlete VIP drops, and seasonal flash sales</p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
        
        <!-- Left: Active Coupons Table -->
        <div class="lg:col-span-8 bg-[#1e1e2d] rounded-2xl border border-[#2b2b40] shadow-xl overflow-hidden">
            <div class="p-5 border-b border-[#2b2b40] flex justify-between items-center">
                <h3 class="text-sm font-black text-white">Active Promotion Vouchers</h3>
                <span class="text-xs font-bold text-gray-400">{{ $coupons->count() }} active codes</span>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs">
                    <thead>
                        <tr class="text-gray-400 border-b border-[#2b2b40] font-black uppercase text-[10px] tracking-wider bg-[#151521]/60">
                            <th class="py-3.5 px-4">Coupon Code</th>
                            <th class="py-3.5 px-4">Discount</th>
                            <th class="py-3.5 px-4">Min Spend</th>
                            <th class="py-3.5 px-4">Usage Count</th>
                            <th class="py-3.5 px-4 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[#2b2b40] font-medium">
                        @forelse($coupons as $coup)
                            <tr class="hover:bg-[#151521]/40 transition">
                                <td class="py-3 px-4">
                                    <span class="px-3 py-1 rounded-xl bg-indigo-500/15 text-indigo-300 font-mono font-black border border-indigo-500/30">
                                        {{ $coup->code }}
                                    </span>
                                </td>
                                <td class="py-3 px-4 text-emerald-400 font-bold">
                                    {{ $coup->type === 'percentage' ? $coup->value . '% OFF' : '$' . number_format($coup->value, 2) . ' FIXED' }}
                                </td>
                                <td class="py-3 px-4 text-gray-300">
                                    {{ $coup->min_spend ? '$' . number_format($coup->min_spend, 2) : 'No Min' }}
                                </td>
                                <td class="py-3 px-4 text-gray-400 text-[11px]">
                                    {{ $coup->used_count }} / {{ $coup->usage_limit ?? '∞' }}
                                </td>
                                <td class="py-3 px-4 text-right">
                                    <form action="{{ route('admin.coupons.delete', $coup->id) }}" method="POST" onsubmit="return confirm('Delete this coupon?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-2 rounded-xl bg-rose-500/10 hover:bg-rose-500 text-rose-400 hover:text-white transition border border-rose-500/20 cursor-pointer" title="Delete Coupon">
                                            <i class="fa-solid fa-trash text-xs"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="py-8 text-center text-gray-500 italic">No coupons created yet.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Right: Create Coupon Form -->
        <div class="lg:col-span-4 bg-[#1e1e2d] rounded-2xl border border-[#2b2b40] p-6 shadow-xl space-y-4">
            <h3 class="text-sm font-black text-white pb-3 border-b border-[#2b2b40]">
                Create Promotion Voucher
            </h3>

            <form action="{{ route('admin.coupons.store') }}" method="POST" class="space-y-4 text-xs">
                @csrf
                <div class="space-y-1">
                    <label class="block font-bold text-gray-300 uppercase text-[10px]">Coupon Code</label>
                    <input type="text" name="code" placeholder="e.g. GYM20" class="w-full px-4 py-2.5 rounded-xl bg-[#151521] border border-[#2b2b40] text-white font-mono font-bold uppercase focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition" required>
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div class="space-y-1">
                        <label class="block font-bold text-gray-300 uppercase text-[10px]">Type</label>
                        <select name="type" class="w-full px-3 py-2.5 rounded-xl bg-[#151521] border border-[#2b2b40] text-white font-bold focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition">
                            <option value="percentage">% Percent</option>
                            <option value="fixed">$ Fixed</option>
                        </select>
                    </div>

                    <div class="space-y-1">
                        <label class="block font-bold text-gray-300 uppercase text-[10px]">Discount Value</label>
                        <input type="number" step="0.01" name="value" placeholder="20" class="w-full px-3 py-2.5 rounded-xl bg-[#151521] border border-[#2b2b40] text-white font-bold focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition" required>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div class="space-y-1">
                        <label class="block font-bold text-gray-300 uppercase text-[10px]">Min Spend ($)</label>
                        <input type="number" step="0.01" name="min_spend" placeholder="50.00" class="w-full px-3 py-2.5 rounded-xl bg-[#151521] border border-[#2b2b40] text-white font-bold focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition">
                    </div>

                    <div class="space-y-1">
                        <label class="block font-bold text-gray-300 uppercase text-[10px]">Usage Limit</label>
                        <input type="number" name="usage_limit" placeholder="100" class="w-full px-3 py-2.5 rounded-xl bg-[#151521] border border-[#2b2b40] text-white font-bold focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition">
                    </div>
                </div>

                <button type="submit" class="w-full py-3 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white font-black uppercase text-xs tracking-wider transition shadow-md shadow-indigo-600/30 flex items-center justify-center gap-1.5 cursor-pointer">
                    <i class="fa-solid fa-plus text-xs"></i>
                    <span>Activate Coupon</span>
                </button>
            </form>
        </div>

    </div>

</div>
@endsection