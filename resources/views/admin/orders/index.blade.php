@extends('layouts.admin')

@section('title', 'Customer Orders & Invoices')

@section('content')
<div class="space-y-6">
    <div>
        <h1 class="text-xl font-black text-white">Order Pipeline Management</h1>
        <p class="text-xs text-slate-400 mt-1">Track orders, manage fulfillment status, and generate printable invoices</p>
    </div>

    <div class="bg-slate-900/80 rounded-3xl border border-slate-800 shadow-xl overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead>
                    <tr class="text-slate-400 border-b border-slate-800 font-black uppercase text-[10px] tracking-wider bg-slate-950/40">
                        <th class="py-4 px-4">Order #</th>
                        <th class="py-4 px-4">Customer Details</th>
                        <th class="py-4 px-4">Payment</th>
                        <th class="py-4 px-4">Total</th>
                        <th class="py-4 px-4">Order Status</th>
                        <th class="py-4 px-4">Date</th>
                        <th class="py-4 px-4 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-800/60 font-medium">
                    @forelse($orders as $ord)
                        <tr class="hover:bg-slate-800/30 transition">
                            <td class="py-3 px-4 font-mono font-bold text-indigo-300">{{ $ord->order_number }}</td>
                            <td class="py-3 px-4">
                                <div class="font-bold text-white">{{ $ord->customer_name }}</div>
                                <div class="text-[10px] text-slate-400">{{ $ord->customer_email }} • {{ $ord->customer_phone }}</div>
                            </td>
                            <td class="py-3 px-4">
                                <span class="uppercase font-bold text-[10px] text-slate-300">{{ $ord->payment_method }}</span>
                                <span class="px-2 py-0.5 rounded-full text-[9px] font-black uppercase ml-1 {{ $ord->payment_status === 'paid' ? 'bg-emerald-500/20 text-emerald-400' : 'bg-amber-500/20 text-amber-300' }}">
                                    {{ $ord->payment_status }}
                                </span>
                            </td>
                            <td class="py-3 px-4 font-black text-white">${{ number_format($ord->total_amount, 2) }}</td>
                            <td class="py-3 px-4">
                                <span class="px-2.5 py-1 rounded-full text-[10px] font-black uppercase {{ $ord->order_status === 'delivered' ? 'bg-emerald-500/20 text-emerald-400 border border-emerald-500/30' : ($ord->order_status === 'processing' ? 'bg-indigo-500/20 text-indigo-400 border border-indigo-500/30' : ($ord->order_status === 'shipped' ? 'bg-blue-500/20 text-blue-400 border border-blue-500/30' : 'bg-amber-500/20 text-amber-300 border border-amber-500/30')) }}">
                                    {{ $ord->order_status }}
                                </span>
                            </td>
                            <td class="py-3 px-4 text-slate-400 text-[11px]">{{ $ord->created_at->format('M d, Y H:i') }}</td>
                            <td class="py-3 px-4 text-right">
                                <a href="{{ route('admin.orders.show', $ord->id) }}" class="px-3 py-1.5 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-[11px] transition inline-flex items-center gap-1.5">
                                    <i class="fa-solid fa-file-invoice"></i> Manage
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-8 text-center text-slate-500 italic">No customer orders recorded yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="p-4 border-t border-slate-800">
            {{ $orders->links() }}
        </div>
    </div>
</div>
@endsection