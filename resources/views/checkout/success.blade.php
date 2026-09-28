@extends('layouts.app')

@section('title', 'Order Placed Successfully #' . $order->order_number . ' - Star Tech')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="bg-white rounded-lg border border-slate-200 p-6 sm:p-10 shadow-xs space-y-6">
        
        <!-- Header Success Message -->
        <div class="text-center space-y-2">
            <div class="w-16 h-16 bg-emerald-50 text-emerald-600 rounded-full flex items-center justify-center text-3xl mx-auto border border-emerald-100">
                <i class="fa-solid fa-check"></i>
            </div>
            <h1 class="text-xl sm:text-2xl font-bold text-slate-900">Thank You! Your Order has been Placed</h1>
            <p class="text-xs text-slate-500 max-w-md mx-auto">
                We have received your order. Our team will verify and process your delivery shortly. Confirmation sent to <strong>{{ $order->customer_email }}</strong>.
            </p>
        </div>

        <!-- Order Metadata Strip -->
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 p-4 rounded bg-slate-50 border border-slate-100 text-center text-xs">
            <div>
                <span class="text-slate-400 block text-[11px]">Order Number</span>
                <span class="font-bold text-starBlue font-mono text-sm">{{ $order->order_number }}</span>
            </div>
            <div>
                <span class="text-slate-400 block text-[11px]">Order Date</span>
                <span class="font-semibold text-slate-800">{{ $order->created_at->format('d M, Y') }}</span>
            </div>
            <div>
                <span class="text-slate-400 block text-[11px]">Payment Method</span>
                <span class="font-semibold text-slate-800 uppercase">{{ $order->payment_method }}</span>
            </div>
            <div>
                <span class="text-slate-400 block text-[11px]">Order Status</span>
                <span class="inline-flex items-center px-2 py-0.5 rounded text-[11px] font-bold bg-amber-50 text-amber-700 capitalize">
                    {{ $order->order_status }}
                </span>
            </div>
        </div>

        <!-- Items Ordered -->
        <div class="space-y-3">
            <h3 class="font-bold text-slate-900 text-sm border-b border-slate-100 pb-2">Ordered Products</h3>
            <div class="divide-y divide-slate-100">
                @foreach($order->items as $item)
                    <div class="py-3 flex items-center justify-between gap-4">
                        <div class="flex items-center gap-3">
                            @if($item->product && $item->product->image)
                                <img src="{{ $item->product->image }}" alt="{{ $item->product_name }}" class="w-12 h-12 rounded object-contain border border-slate-100 p-1 shrink-0">
                            @else
                                <div class="w-12 h-12 bg-slate-100 rounded flex items-center justify-center text-slate-400">
                                    <i class="fa-solid fa-laptop"></i>
                                </div>
                            @endif
                            <div>
                                <h4 class="font-semibold text-xs text-slate-800">{{ $item->product_name }}</h4>
                                <span class="text-[11px] text-slate-400">Qty: {{ $item->quantity }} &times; {{ number_format($item->price) }}৳</span>
                            </div>
                        </div>
                        <span class="font-bold text-xs text-slate-900">{{ number_format($item->subtotal) }}৳</span>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Order Summary & Shipping Address Breakdown -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 pt-4 border-t border-slate-100">
            <div>
                <h4 class="font-bold text-xs text-slate-900 mb-1.5">Delivery Address</h4>
                <div class="text-xs text-slate-600 space-y-0.5">
                    <p class="font-semibold text-slate-800">{{ $order->customer_name }}</p>
                    <p>{{ $order->shipping_address }}</p>
                    <p>{{ $order->city }} {{ $order->postal_code ? '- ' . $order->postal_code : '' }}</p>
                    <p class="text-slate-500">Phone: {{ $order->customer_phone }}</p>
                </div>
            </div>

            <div class="space-y-1 text-xs text-slate-700 sm:text-right">
                @if($order->coupon_code)
                    <div class="flex justify-between sm:justify-end gap-4 text-emerald-600 font-semibold">
                        <span>Coupon Discount ({{ $order->coupon_code }}):</span>
                        <span>-{{ number_format($order->discount_amount) }}৳</span>
                    </div>
                @endif
                <div class="flex justify-between sm:justify-end gap-4 text-base font-bold text-slate-900 pt-2 border-t sm:border-0 border-slate-100">
                    <span>Total Amount:</span>
                    <span class="text-starOrange">{{ number_format($order->total_amount) }}৳</span>
                </div>
            </div>
        </div>

        <!-- CTA Back to Shop -->
        <div class="pt-6 border-t border-slate-100 text-center">
            <a href="{{ route('shop.index') }}" class="inline-block bg-starBlue hover:bg-starBlueDark text-white text-xs font-bold py-3 px-8 rounded transition">
                Continue Shopping Tech Products
            </a>
        </div>

    </div>
</div>
@endsection