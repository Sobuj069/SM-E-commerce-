@extends('layouts.admin')

@section('title', 'Discount & Coupon Engine')

@section('content')
<div class="space-y-8">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-xl font-black text-white">Promo Codes & Coupons</h1>
            <p class="text-xs text-slate-400 mt-1">Configure automated discount vouchers and flash sale promos</p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
        
        <!-- Left: Active Coupons Table -->
        <div class="lg:col-span-8 bg-slate-900/80 rounded-3xl border border-slate-800 shadow-xl overflow-hidden">
            <div class="p-5 border-b border-slate-800 flex justify-between items-center">
                <h3 class="text-sm font-black text-white">Active Promotion Codes</h3>
                <span class="text-xs text-slate-400">{{ $coupons->count() }} vouchers configured</span>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs">
                    <thead>
                        <tr class="text-slate-400 border-b border-slate-800 font-black uppercase text-[10px] tracking-wider bg-slate-950/40">
                            <th class="py-3 px-4">Coupon Code</th>
                            <th class="py-3 px-4">Discount</th>
                            <th class="py-3 px-4">Min Spend</th>
                            <th class="py-3 px-4">Usage</th>
                            <th class="py-3 px-4 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-800/60 font-medium">
                        @forelse($coupons as $coup)
                            <tr class="hover:bg-slate-800/30 transition">
                                <td class="py-3 px-4">
                                    <span class="px-3 py-1 rounded-xl bg-indigo-500/20 text-indigo-300 font-mono font-black border border-indigo-500/30">
                                        {{ $coup->code }}
                                    </span>
                                </td>
                                <td class="py-3 px-4 text-emerald-400 font-bold">
                                    {{ $coup->type === 'percentage' ? $coup->value . '% OFF' : '$' . number_format($coup->value, 2) . ' FIXED' }}
                                </td>
                                <td class="py-3 px-4 text-slate-300">
                                    {{ $coup->min_spend ? '$' . number_format($coup->min_spend, 2) : 'No Min' }}
                                </td>
                                <td class="py-3 px-4 text-slate-400 text-[11px]">
                                    {{ $coup->used_count }} / {{ $coup->usage_limit ?? '∞' }}
                                </td>
                                <td class="py-3 px-4 text-right">
                                    <form action="{{ route('admin.coupons.delete', $coup->id) }}" method="POST" onsubmit="return confirm('Delete this coupon?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-2 rounded-xl bg-rose-500/10 hover:bg-rose-500 text-rose-400 hover:text-white transition" title="Delete">
                                            <i class="fa-solid fa-trash text-xs"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="py-8 text-center text-slate-500 italic">No coupons created yet.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Right: Create Coupon Form -->
        <div class="lg:col-span-4 bg-slate-900/80 rounded-3xl border border-slate-800 p-6 shadow-xl space-y-4">
            <h3 class="text-sm font-black text-white pb-3 border-b border-slate-800">
                Create New Coupon
            </h3>

            <form action="{{ route('admin.coupons.store') }}" method="POST" class="space-y-4 text-xs">
                @csrf
                <div>
                    <label class="block font-bold text-slate-300 uppercase text-[10px] mb-1">Coupon Code</label>
                    <input type="text" name="code" placeholder="e.g. VIP2026" class="w-full px-4 py-2.5 rounded-xl bg-slate-800 border border-slate-700 text-white font-mono font-bold uppercase focus:outline-none focus:ring-2 focus:ring-indigo-500" required>
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block font-bold text-slate-300 uppercase text-[10px] mb-1">Type</label>
                        <select name="type" class="w-full px-3 py-2.5 rounded-xl bg-slate-800 border border-slate-700 text-white font-bold focus:outline-none focus:ring-2 focus:ring-indigo-500">
                            <option value="percentage">% Percentage</option>
                            <option value="fixed">$ Fixed Amount</option>
                        </select>
                    </div>

                    <div>
                        <label class="block font-bold text-slate-300 uppercase text-[10px] mb-1">Value</label>
                        <input type="number" step="0.01" name="value" placeholder="20" class="w-full px-3 py-2.5 rounded-xl bg-slate-800 border border-slate-700 text-white font-bold focus:outline-none focus:ring-2 focus:ring-indigo-500" required>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block font-bold text-slate-300 uppercase text-[10px] mb-1">Min Spend ($)</label>
                        <input type="number" step="0.01" name="min_spend" placeholder="50" class="w-full px-3 py-2.5 rounded-xl bg-slate-800 border border-slate-700 text-white font-bold focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    </div>

                    <div>
                        <label class="block font-bold text-slate-300 uppercase text-[10px] mb-1">Usage Limit</label>
                        <input type="number" name="usage_limit" placeholder="500" class="w-full px-3 py-2.5 rounded-xl bg-slate-800 border border-slate-700 text-white font-bold focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    </div>
                </div>

                <button type="submit" class="w-full py-3 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white font-black transition shadow-lg shadow-indigo-600/25 mt-2">
                    Create Coupon Code
                </button>
            </form>
        </div>

    </div>
</div>
@endsection