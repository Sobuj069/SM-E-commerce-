@extends('layouts.admin')

@section('title', 'Customer Orders & Invoices')
@section('breadcrumb', 'Orders')

@section('content')
<div class="space-y-6">
    
    <!-- Top Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-xl font-black text-white">Order Pipeline & Invoices</h1>
            <p class="text-xs text-gray-400 mt-0.5">Track apparel purchases, update dispatch stages, and manage customer fulfillment</p>
        </div>
        <div class="inline-flex items-center gap-2">
            <span class="px-3 py-1.5 rounded-xl bg-[#1e1e2d] border border-[#2b2b40] text-xs font-bold text-gray-300">
                Total Orders: <span class="text-white font-black">{{ $orders->total() }}</span>
            </span>
        </div>
    </div>

    <!-- Metronic Orders Data Table -->
    <div class="bg-[#1e1e2d] rounded-2xl border border-[#2b2b40] shadow-xl overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead>
                    <tr class="text-gray-400 border-b border-[#2b2b40] font-black uppercase text-[10px] tracking-wider bg-[#151521]/60">
                        <th class="py-4 px-5">Order #</th>
                        <th class="py-4 px-5">Customer Profile</th>
                        <th class="py-4 px-5">Payment Method</th>
                        <th class="py-4 px-5">Total Amount</th>
                        <th class="py-4 px-5">Fulfillment Status</th>
                        <th class="py-4 px-5">Placed At</th>
                        <th class="py-4 px-5 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#2b2b40] font-medium">
                    @forelse($orders as $ord)
                        <tr class="hover:bg-[#151521]/40 transition">
                            <td class="py-3.5 px-5 font-mono font-bold text-indigo-400">
                                {{ $ord->order_number }}
                            </td>
                            <td class="py-3.5 px-5">
                                <div class="font-bold text-white text-xs">{{ $ord->shipping_name ?? $ord->customer_name }}</div>
                                <div class="text-[10px] text-gray-400 font-mono mt-0.5">{{ $ord->shipping_email ?? $ord->customer_email }}</div>
                            </td>
                            <td class="py-3.5 px-5">
                                <div class="flex items-center gap-1.5">
                                    <span class="uppercase font-bold text-[11px] text-gray-300">{{ $ord->payment_method }}</span>
                                    <span class="px-2 py-0.5 rounded-full text-[9px] font-black uppercase {{ $ord->payment_status === 'paid' ? 'bg-emerald-500/15 text-emerald-400 border border-emerald-500/30' : 'bg-amber-500/15 text-amber-400 border border-amber-500/30' }}">
                                        {{ $ord->payment_status }}
                                    </span>
                                </div>
                            </td>
                            <td class="py-3.5 px-5 font-black text-white text-sm">
                                ${{ number_format($ord->total_amount, 2) }}
                            </td>
                            <td class="py-3.5 px-5">
                                <span class="px-2.5 py-1 rounded-full text-[10px] font-black uppercase tracking-wider
                                    @if($ord->order_status === 'delivered') bg-emerald-500/15 text-emerald-400 border border-emerald-500/30
                                    @elseif($ord->order_status === 'shipped') bg-cyan-500/15 text-cyan-400 border border-cyan-500/30
                                    @elseif($ord->order_status === 'processing') bg-indigo-500/15 text-indigo-400 border border-indigo-500/30
                                    @else bg-amber-500/15 text-amber-400 border border-amber-500/30
                                    @endif
                                ">
                                    {{ $ord->order_status }}
                                </span>
                            </td>
                            <td class="py-3.5 px-5 text-gray-400 text-[11px]">
                                {{ $ord->created_at->format('M d, Y H:i') }}
                            </td>
                            <td class="py-3.5 px-5 text-right">
                                <a href="{{ route('admin.orders.show', $ord->id) }}" class="px-3 py-1.5 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-xs transition inline-flex items-center gap-1.5 shadow-md shadow-indigo-600/20">
                                    <i class="fa-solid fa-file-invoice text-[10px]"></i>
                                    <span>Manage</span>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-12 text-center text-gray-500 italic">No customer orders recorded yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($orders->hasPages())
            <div class="p-4 border-t border-[#2b2b40] bg-[#1a1a27]">
                {{ $orders->links() }}
            </div>
        @endif
    </div>

</div>
@endsection