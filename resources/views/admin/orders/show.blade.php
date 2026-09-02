@extends('layouts.admin')

@section('title', 'Order ' . $order->order_number)
@section('breadcrumb', 'Orders / #' . $order->order_number)

@section('content')
<div class="space-y-6 max-w-5xl mx-auto">
    
    <!-- Top Action Bar -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <div class="flex items-center gap-3">
                <h1 class="text-xl lg:text-2xl font-bold text-gray-900 font-mono">{{ $order->order_number }}</h1>
                <span class="kt-badge kt-badge-sm
                    @if($order->order_status === 'delivered') kt-badge-outline kt-badge-success
                    @elseif($order->order_status === 'shipped') kt-badge-outline kt-badge-info
                    @elseif($order->order_status === 'processing') kt-badge-outline kt-badge-primary
                    @else kt-badge-outline kt-badge-warning
                    @endif
                ">
                    {{ ucfirst($order->order_status) }}
                </span>
            </div>
            <p class="text-xs text-gray-500 mt-0.5">Placed on {{ $order->created_at->format('M d, Y \a\t H:i A') }}</p>
        </div>

        <div class="flex items-center gap-3">
            <button onclick="window.print()" class="kt-btn kt-btn-outline kt-btn-sm text-xs font-semibold text-gray-700 flex items-center gap-1.5 cursor-pointer">
                <i class="fa-solid fa-print text-xs"></i> Print Invoice
            </button>
            <a href="{{ route('admin.orders.index') }}" class="kt-btn kt-btn-outline kt-btn-sm text-xs font-semibold text-gray-700">
                Back to Orders
            </a>
        </div>
    </div>

    <!-- Status Updater Control Card -->
    <div class="kt-card p-6 bg-white border border-gray-200/90 rounded-xl shadow-xs">
        <h3 class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-3">Update Order & Payment Status</h3>
        <form action="{{ route('admin.orders.status', $order->id) }}" method="POST" class="flex flex-col sm:flex-row items-center gap-4">
            @csrf
            <div class="flex-1 w-full space-y-1">
                <label class="text-[10px] font-bold text-gray-600 uppercase tracking-wider block">Fulfillment Stage</label>
                <select name="order_status" class="w-full px-4 py-2.5 rounded-lg bg-gray-50 border border-gray-200 text-gray-900 text-xs font-semibold focus:outline-none focus:border-primary focus:bg-white transition">
                    <option value="pending" {{ $order->order_status == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="processing" {{ $order->order_status == 'processing' ? 'selected' : '' }}>Processing</option>
                    <option value="shipped" {{ $order->order_status == 'shipped' ? 'selected' : '' }}>Shipped</option>
                    <option value="delivered" {{ $order->order_status == 'delivered' ? 'selected' : '' }}>Delivered</option>
                    <option value="cancelled" {{ $order->order_status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                </select>
            </div>

            <div class="flex-1 w-full space-y-1">
                <label class="text-[10px] font-bold text-gray-600 uppercase tracking-wider block">Payment Verification</label>
                <select name="payment_status" class="w-full px-4 py-2.5 rounded-lg bg-gray-50 border border-gray-200 text-gray-900 text-xs font-semibold focus:outline-none focus:border-primary focus:bg-white transition">
                    <option value="pending" {{ $order->payment_status == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="paid" {{ $order->payment_status == 'paid' ? 'selected' : '' }}>Paid</option>
                    <option value="failed" {{ $order->payment_status == 'failed' ? 'selected' : '' }}>Failed</option>
                </select>
            </div>

            <div class="sm:self-end w-full sm:w-auto">
                <button type="submit" class="w-full sm:w-auto kt-btn kt-btn-primary kt-btn-sm text-xs font-semibold shadow-xs cursor-pointer">
                    Save Changes
                </button>
            </div>
        </form>
    </div>

    <!-- Printable Invoice & Order Details -->
    <div class="kt-card p-8 bg-white border border-gray-200/90 rounded-xl shadow-xs space-y-8 print:bg-white print:p-0 print:border-none">
        
        <!-- Header -->
        <div class="flex justify-between items-start pb-6 border-b border-gray-100">
            <div class="flex items-center gap-3">
                <img src="{{ asset('images/logo.png') }}" alt="SM Shop" class="h-10 w-auto object-contain">
                <div>
                    <div class="text-base font-black text-gray-900 uppercase">SM SHOP</div>
                    <div class="text-xs text-gray-500">Fashion & Activewear Ltd.</div>
                </div>
            </div>
            <div class="text-right">
                <div class="text-sm font-mono font-bold text-primary">{{ $order->order_number }}</div>
                <div class="text-xs text-gray-500">{{ $order->created_at->format('d M Y') }}</div>
            </div>
        </div>

        <!-- Customer & Shipping Addresses -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-xs">
            <div class="space-y-1.5 p-4 rounded-lg bg-gray-50 border border-gray-100">
                <span class="font-bold text-primary uppercase tracking-wider block text-[10px]">Customer Details</span>
                <div class="font-bold text-gray-900 text-sm">{{ $order->shipping_name ?? $order->customer_name }}</div>
                <div class="text-gray-600">{{ $order->shipping_email ?? $order->customer_email }}</div>
                <div class="text-gray-600">{{ $order->shipping_phone ?? $order->customer_phone }}</div>
            </div>

            <div class="space-y-1.5 p-4 rounded-lg bg-gray-50 border border-gray-100">
                <span class="font-bold text-emerald-600 uppercase tracking-wider block text-[10px]">Shipping Destination</span>
                <div class="text-gray-600">{{ $order->shipping_address }}</div>
                <div class="text-gray-600">{{ $order->city }} {{ $order->postal_code ? '(' . $order->postal_code . ')' : '' }}</div>
                <div class="text-gray-500 text-[11px] pt-1">Payment Method: <strong class="uppercase text-gray-900">{{ $order->payment_method }}</strong></div>
            </div>
        </div>

        <!-- Line Items -->
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead>
                    <tr class="text-gray-500 border-b border-gray-100 font-bold uppercase text-[10px] bg-gray-50/70">
                        <th class="py-3 px-4">Activewear Item</th>
                        <th class="py-3 px-4 text-center">Qty</th>
                        <th class="py-3 px-4 text-right">Unit Price</th>
                        <th class="py-3 px-4 text-right">Line Total</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 font-medium text-gray-700">
                    @foreach($order->items as $item)
                        <tr>
                            <td class="py-3.5 px-4">
                                <div class="font-bold text-gray-900 text-xs">{{ $item->product_name ?? ($item->product->name ?? 'Product') }}</div>
                                @if($item->variant_info)
                                    <div class="text-[10px] text-gray-400">{{ $item->variant_info }}</div>
                                @endif
                            </td>
                            <td class="py-3.5 px-4 text-center font-bold text-gray-900">{{ $item->quantity }}</td>
                            <td class="py-3.5 px-4 text-right text-gray-600">${{ number_format($item->price, 2) }}</td>
                            <td class="py-3.5 px-4 text-right font-black text-gray-900">${{ number_format($item->total_price, 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr class="border-t border-gray-100">
                        <td colspan="3" class="py-4 px-4 text-right font-bold text-gray-500 uppercase text-[10px]">Grand Total:</td>
                        <td class="py-4 px-4 text-right font-black text-base text-emerald-600">${{ number_format($order->total_amount, 2) }}</td>
                    </tr>
                </tfoot>
            </table>
        </div>

    </div>

</div>
@endsection