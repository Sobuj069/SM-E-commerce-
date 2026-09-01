@extends('layouts.admin')

@section('title', 'Order ' . $order->order_number)

@section('content')
<div class="space-y-6 max-w-5xl mx-auto">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <div class="flex items-center gap-3">
                <h1 class="text-xl font-black text-white font-mono">{{ $order->order_number }}</h1>
                <span class="px-2.5 py-1 rounded-full text-[10px] font-black uppercase {{ $order->order_status === 'delivered' ? 'bg-emerald-500/20 text-emerald-400 border border-emerald-500/30' : ($order->order_status === 'processing' ? 'bg-indigo-500/20 text-indigo-400 border border-indigo-500/30' : 'bg-amber-500/20 text-amber-300 border border-amber-500/30') }}">
                    {{ $order->order_status }}
                </span>
            </div>
            <p class="text-xs text-slate-400 mt-1">Placed on {{ $order->created_at->format('M d, Y \a\t H:i A') }}</p>
        </div>

        <div class="flex items-center gap-3">
            <button onclick="window.print()" class="px-4 py-2.5 rounded-2xl bg-slate-800 hover:bg-slate-700 text-white text-xs font-bold transition flex items-center gap-2">
                <i class="fa-solid fa-print"></i> Print Invoice
            </button>
            <a href="{{ route('admin.orders.index') }}" class="px-4 py-2.5 rounded-2xl bg-slate-800 hover:bg-slate-700 text-slate-400 hover:text-white text-xs font-bold transition">
                Back to Orders
            </a>
        </div>
    </div>

    <!-- Status Updater Control -->
    <div class="p-6 rounded-3xl bg-slate-900/80 border border-slate-800 shadow-xl">
        <h3 class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-3">Update Order & Payment Status</h3>
        <form action="{{ route('admin.orders.status', $order->id) }}" method="POST" class="flex flex-col sm:flex-row items-center gap-4">
            @csrf
            <div class="flex-1 w-full">
                <label class="text-[10px] font-bold text-slate-400 block mb-1">Fulfillment Status</label>
                <select name="order_status" class="w-full px-4 py-2.5 rounded-xl bg-slate-800 border border-slate-700 text-white text-xs font-bold focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    <option value="pending" {{ $order->order_status == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="processing" {{ $order->order_status == 'processing' ? 'selected' : '' }}>Processing</option>
                    <option value="shipped" {{ $order->order_status == 'shipped' ? 'selected' : '' }}>Shipped</option>
                    <option value="delivered" {{ $order->order_status == 'delivered' ? 'selected' : '' }}>Delivered</option>
                    <option value="cancelled" {{ $order->order_status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                </select>
            </div>

            <div class="flex-1 w-full">
                <label class="text-[10px] font-bold text-slate-400 block mb-1">Payment Status</label>
                <select name="payment_status" class="w-full px-4 py-2.5 rounded-xl bg-slate-800 border border-slate-700 text-white text-xs font-bold focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    <option value="pending" {{ $order->payment_status == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="paid" {{ $order->payment_status == 'paid' ? 'selected' : '' }}>Paid</option>
                    <option value="failed" {{ $order->payment_status == 'failed' ? 'selected' : '' }}>Failed</option>
                </select>
            </div>

            <div class="sm:self-end w-full sm:w-auto">
                <button type="submit" class="w-full sm:w-auto px-6 py-2.5 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-black transition">
                    Save Changes
                </button>
            </div>
        </form>
    </div>

    <!-- Printable Invoice & Order Details -->
    <div class="p-8 rounded-3xl bg-slate-900 border border-slate-800 shadow-2xl space-y-8 print:bg-white print:text-black print:p-0">
        
        <!-- Header -->
        <div class="flex justify-between items-start pb-6 border-b border-slate-800">
            <div>
                <div class="text-xl font-black text-white">SM SHOP 3D</div>
                <div class="text-xs text-slate-400">Next-Gen E-Commerce Experience</div>
            </div>
            <div class="text-right">
                <div class="text-sm font-mono font-bold text-indigo-400">{{ $order->order_number }}</div>
                <div class="text-xs text-slate-400">{{ $order->created_at->format('d M Y') }}</div>
            </div>
        </div>

        <!-- Customer & Shipping Addresses -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-xs">
            <div class="space-y-1">
                <span class="font-bold text-slate-400 uppercase tracking-wider block text-[10px]">Customer Details</span>
                <div class="font-bold text-white text-sm">{{ $order->customer_name }}</div>
                <div class="text-slate-300">{{ $order->customer_email }}</div>
                <div class="text-slate-300">{{ $order->customer_phone }}</div>
            </div>

            <div class="space-y-1 md:text-right">
                <span class="font-bold text-slate-400 uppercase tracking-wider block text-[10px]">Shipping Destination</span>
                <div class="text-slate-300">{{ $order->shipping_address }}</div>
                <div class="text-slate-300">{{ $order->city }} {{ $order->postal_code ? '(' . $order->postal_code . ')' : '' }}</div>
                <div class="text-slate-400 text-[11px] pt-1">Payment: <strong class="uppercase text-white">{{ $order->payment_method }}</strong></div>
            </div>
        </div>

        <!-- Line Items -->
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead>
                    <tr class="text-slate-400 border-b border-slate-800 font-bold uppercase text-[10px]">
                        <th class="py-3">Product</th>
                        <th class="py-3 text-center">Qty</th>
                        <th class="py-3 text-right">Price</th>
                        <th class="py-3 text-right">Subtotal</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-800/60 font-medium">
                    @foreach($order->items as $item)
                        <tr>
                            <td class="py-3 text-white font-bold">{{ $item->product_name }}</td>
                            <td class="py-3 text-center text-slate-300">{{ $item->quantity }}</td>
                            <td class="py-3 text-right text-slate-300">${{ number_format($item->price, 2) }}</td>
                            <td class="py-3 text-right text-white font-black">${{ number_format($item->subtotal, 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Totals Summary -->
        <div class="border-t border-slate-800 pt-4 flex justify-end">
            <div class="w-64 space-y-2 text-xs">
                @if($order->coupon_code)
                    <div class="flex justify-between text-emerald-400">
                        <span>Coupon Discount ({{ $order->coupon_code }}):</span>
                        <span class="font-bold">-${{ number_format($order->discount_amount, 2) }}</span>
                    </div>
                @endif
                <div class="flex justify-between text-base font-black text-white pt-2 border-t border-slate-800">
                    <span>Total Amount:</span>
                    <span class="text-amber-300">${{ number_format($order->total_amount, 2) }}</span>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection