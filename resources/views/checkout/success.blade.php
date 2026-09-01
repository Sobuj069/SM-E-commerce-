@extends('layouts.app')

@section('title', 'Order Confirmed #' . $order->order_number . ' - SM E-Commerce')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
    <div class="bg-white rounded-3xl border border-slate-200 p-8 sm:p-12 shadow-xs space-y-8">
        
        <!-- Header Success Message -->
        <div class="text-center space-y-3">
            <div class="w-16 h-16 bg-emerald-100 text-emerald-600 rounded-full flex items-center justify-center text-3xl mx-auto shadow-xs">
                <i class="fa-solid fa-check"></i>
            </div>
            <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900">Thank You for Your Order!</h1>
            <p class="text-xs sm:text-sm text-slate-500 max-w-md mx-auto">
                We've received your order and will start processing it right away. A confirmation email has been sent to <strong>{{ $order->customer_email }}</strong>.
            </p>
        </div>

        <!-- Order Metadata Strip -->
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 p-5 rounded-2xl bg-slate-50 border border-slate-100 text-center">
            <div>
                <span class="text-[11px] font-semibold text-slate-400 block uppercase">Order Number</span>
                <span class="font-extrabold text-indigo-700 text-sm font-mono">{{ $order->order_number }}</span>
            </div>
            <div>
                <span class="text-[11px] font-semibold text-slate-400 block uppercase">Date</span>
                <span class="font-bold text-slate-800 text-sm">{{ $order->created_at->format('M d, Y') }}</span>
            </div>
            <div>
                <span class="text-[11px] font-semibold text-slate-400 block uppercase">Payment Method</span>
                <span class="font-bold text-slate-800 text-sm uppercase">{{ $order->payment_method }}</span>
            </div>
            <div>
                <span class="text-[11px] font-semibold text-slate-400 block uppercase">Order Status</span>
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-amber-100 text-amber-800 capitalize">
                    {{ $order->order_status }}
                </span>
            </div>
        </div>

        <!-- Items Ordered -->
        <div class="space-y-4">
            <h3 class="font-bold text-slate-900 text-base border-b border-slate-100 pb-2">Ordered Items</h3>
            <div class="divide-y divide-slate-100">
                @foreach($order->items as $item)
                    <div class="py-4 flex items-center justify-between gap-4">
                        <div class="flex items-center gap-4">
                            @if($item->product && $item->product->image)
                                <img src="{{ $item->product->image }}" alt="{{ $item->product_name }}" class="w-14 h-14 rounded-xl object-cover border border-slate-200 shrink-0">
                            @else
                                <div class="w-14 h-14 bg-slate-100 rounded-xl flex items-center justify-center text-slate-400">
                                    <i class="fa-solid fa-box"></i>
                                </div>
                            @endif
                            <div>
                                <h4 class="font-bold text-sm text-slate-900">{{ $item->product_name }}</h4>
                                <span class="text-xs text-slate-500">Qty: {{ $item->quantity }} &times; ${{ number_format($item->price, 2) }}</span>
                            </div>
                        </div>
                        <span class="font-extrabold text-sm text-slate-900">${{ number_format($item->subtotal, 2) }}</span>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Order Summary & Shipping Address Breakdown -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 pt-6 border-t border-slate-100">
            <div>
                <h4 class="font-bold text-xs uppercase tracking-wider text-slate-500 mb-2">Shipping Information</h4>
                <div class="text-sm text-slate-700 space-y-1">
                    <p class="font-bold text-slate-900">{{ $order->customer_name }}</p>
                    <p>{{ $order->shipping_address }}</p>
                    <p>{{ $order->city }} {{ $order->postal_code ? '- ' . $order->postal_code : '' }}</p>
                    <p class="text-slate-500">{{ $order->customer_phone }}</p>
                </div>
            </div>

            <div class="space-y-2 text-sm sm:text-right">
                <div class="flex justify-between sm:justify-end gap-6 text-slate-600">
                    <span>Total Amount Paid/Due:</span>
                    <span class="text-xl font-black text-indigo-600">${{ number_format($order->total_amount, 2) }}</span>
                </div>
            </div>
        </div>

        <!-- CTA Back to Shop -->
        <div class="pt-6 border-t border-slate-100 text-center">
            <a href="{{ route('shop.index') }}" class="inline-flex items-center gap-2 px-8 py-3.5 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-xl shadow-md shadow-indigo-200 transition">
                <i class="fa-solid fa-bag-shopping"></i> Continue Shopping
            </a>
        </div>

    </div>
</div>
@endsection
