@extends('layouts.admin')

@section('title', 'Order ' . $order->order_number)
@section('breadcrumb', 'Orders / #' . $order->order_number)

@section('content')
<div class="space-y-6 max-w-5xl mx-auto">
    
    <!-- Top Action Bar -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <div class="flex items-center gap-3">
                <h1 class="text-xl font-black text-white font-mono">{{ $order->order_number }}</h1>
                <span class="px-2.5 py-1 rounded-full text-[10px] font-black uppercase tracking-wider
                    @if($order->order_status === 'delivered') bg-emerald-500/15 text-emerald-400 border border-emerald-500/30
                    @elseif($order->order_status === 'shipped') bg-cyan-500/15 text-cyan-400 border border-cyan-500/30
                    @elseif($order->order_status === 'processing') bg-indigo-500/15 text-indigo-400 border border-indigo-500/30
                    @else bg-amber-500/15 text-amber-400 border border-amber-500/30
                    @endif
                ">
                    {{ $order->order_status }}
                </span>
            </div>
            <p class="text-xs text-gray-400 mt-0.5">Placed on {{ $order->created_at->format('M d, Y \a\t H:i A') }}</p>
        </div>

        <div class="flex items-center gap-3">
            <button onclick="window.print()" class="px-4 py-2.5 rounded-xl bg-[#1e1e2d] hover:bg-[#2b2b40] border border-[#2b2b40] text-white text-xs font-bold transition flex items-center gap-2 cursor-pointer shadow-md">
                <i class="fa-solid fa-print text-xs"></i> Print Invoice
            </button>
            <a href="{{ route('admin.orders.index') }}" class="px-4 py-2.5 rounded-xl bg-[#1e1e2d] hover:bg-[#2b2b40] border border-[#2b2b40] text-gray-400 hover:text-white text-xs font-bold transition">
                Back to Orders
            </a>
        </div>
    </div>

    <!-- Status Updater Control Card -->
    <div class="p-6 rounded-2xl bg-[#1e1e2d] border border-[#2b2b40] shadow-xl">
        <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-3">Update Order & Payment Status</h3>
        <form action="{{ route('admin.orders.status', $order->id) }}" method="POST" class="flex flex-col sm:flex-row items-center gap-4">
            @csrf
            <div class="flex-1 w-full space-y-1">
                <label class="text-[10px] font-bold text-gray-400 uppercase tracking-wider block">Fulfillment Stage</label>
                <select name="order_status" class="w-full px-4 py-2.5 rounded-xl bg-[#151521] border border-[#2b2b40] text-white text-xs font-bold focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition">
                    <option value="pending" {{ $order->order_status == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="processing" {{ $order->order_status == 'processing' ? 'selected' : '' }}>Processing</option>
                    <option value="shipped" {{ $order->order_status == 'shipped' ? 'selected' : '' }}>Shipped</option>
                    <option value="delivered" {{ $order->order_status == 'delivered' ? 'selected' : '' }}>Delivered</option>
                    <option value="cancelled" {{ $order->order_status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                </select>
            </div>

            <div class="flex-1 w-full space-y-1">
                <label class="text-[10px] font-bold text-gray-400 uppercase tracking-wider block">Payment Verification</label>
                <select name="payment_status" class="w-full px-4 py-2.5 rounded-xl bg-[#151521] border border-[#2b2b40] text-white text-xs font-bold focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition">
                    <option value="pending" {{ $order->payment_status == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="paid" {{ $order->payment_status == 'paid' ? 'selected' : '' }}>Paid</option>
                    <option value="failed" {{ $order->payment_status == 'failed' ? 'selected' : '' }}>Failed</option>
                </select>
            </div>

            <div class="sm:self-end w-full sm:w-auto">
                <button type="submit" class="w-full sm:w-auto px-6 py-2.5 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-black uppercase tracking-wider transition shadow-lg shadow-indigo-600/30 cursor-pointer">
                    Save Status
                </button>
            </div>
        </form>
    </div>

    <!-- Printable Invoice & Order Details -->
    <div class="p-8 rounded-2xl bg-[#1e1e2d] border border-[#2b2b40] shadow-2xl space-y-8 print:bg-white print:text-black print:p-0">
        
        <!-- Header -->
        <div class="flex justify-between items-start pb-6 border-b border-[#2b2b40]">
            <div class="flex items-center gap-3">
                <img src="{{ asset('images/logo.png') }}" alt="SM Shop" class="h-10 w-auto object-contain">
                <div>
                    <div class="text-base font-black text-white uppercase">SM SHOP</div>
                    <div class="text-xs text-gray-400">Fashion & Apparel Ltd.</div>
                </div>
            </div>
            <div class="text-right">
                <div class="text-sm font-mono font-bold text-indigo-400">{{ $order->order_number }}</div>
                <div class="text-xs text-gray-400">{{ $order->created_at->format('d M Y') }}</div>
            </div>
        </div>

        <!-- Customer & Shipping Addresses -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-xs">
            <div class="space-y-1.5 p-4 rounded-xl bg-[#151521] border border-[#2b2b40]">
                <span class="font-bold text-indigo-400 uppercase tracking-wider block text-[10px]">Customer Details</span>
                <div class="font-bold text-white text-sm">{{ $order->shipping_name ?? $order->customer_name }}</div>
                <div class="text-gray-300">{{ $order->shipping_email ?? $order->customer_email }}</div>
                <div class="text-gray-300">{{ $order->shipping_phone ?? $order->customer_phone }}</div>
            </div>

            <div class="space-y-1.5 p-4 rounded-xl bg-[#151521] border border-[#2b2b40]">
                <span class="font-bold text-emerald-400 uppercase tracking-wider block text-[10px]">Shipping Destination</span>
                <div class="text-gray-300">{{ $order->shipping_address }}</div>
                <div class="text-gray-300">{{ $order->city }} {{ $order->postal_code ? '(' . $order->postal_code . ')' : '' }}</div>
                <div class="text-gray-400 text-[11px] pt-1">Payment Method: <strong class="uppercase text-white">{{ $order->payment_method }}</strong></div>
            </div>
        </div>

        <!-- Line Items -->
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead>
                    <tr class="text-gray-400 border-b border-[#2b2b40] font-bold uppercase text-[10px] bg-[#151521]/60">
                        <th class="py-3 px-4">Activewear Item</th>
                        <th class="py-3 px-4 text-center">Qty</th>
                        <th class="py-3 px-4 text-right">Unit Price</th>
                        <th class="py-3 px-4 text-right">Line Total</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#2b2b40] font-medium">
                    @foreach($order->items as $item)
                        <tr>
                            <td class="py-3.5 px-4">
                                <div class="font-bold text-white text-xs">{{ $item->product_name ?? ($item->product->name ?? 'Product') }}</div>
                                @if($item->variant_info)
                                    <div class="text-[10px] text-gray-400">{{ $item->variant_info }}</div>
                                @endif
                            </td>
                            <td class="py-3.5 px-4 text-center font-bold text-white">{{ $item->quantity }}</td>
                            <td class="py-3.5 px-4 text-right text-gray-300">${{ number_format($item->price, 2) }}</td>
                            <td class="py-3.5 px-4 text-right font-black text-white">${{ number_format($item->total_price, 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr class="border-t border-[#2b2b40]">
                        <td colspan="3" class="py-4 px-4 text-right font-bold text-gray-400 uppercase text-[10px]">Grand Total:</td>
                        <td class="py-4 px-4 text-right font-black text-base text-emerald-400">${{ number_format($order->total_amount, 2) }}</td>
                    </tr>
                </tfoot>
            </table>
        </div>

    </div>

</div>
@endsection