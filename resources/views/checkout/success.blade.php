@extends('layouts.app')

@section('title', 'Order Confirmed #' . $order->order_number . ' - SM Shop 3D')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
    <div class="bg-surface rounded-3xl border border-line-subtle p-8 sm:p-12 shadow-xl space-y-8 transition-colors duration-200">
        
        <!-- Header Success Message -->
        <div class="text-center space-y-3">
            <div class="w-16 h-16 bg-emerald-500/10 text-status-success rounded-full flex items-center justify-center text-3xl mx-auto shadow-inner">
                <i class="fa-solid fa-check"></i>
            </div>
            <h1 class="text-2xl sm:text-3xl font-black text-content-primary">Thank You for Your Order!</h1>
            <p class="text-xs sm:text-sm text-content-secondary max-w-md mx-auto">
                We've received your order and will begin packaging immediately. A confirmation receipt has been logged for <strong>{{ $order->customer_email }}</strong>.
            </p>
        </div>

        <!-- Order Metadata Strip -->
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 p-5 rounded-2xl bg-surface-elevated border border-line-subtle text-center">
            <div>
                <span class="text-[10px] font-black text-content-muted block uppercase tracking-wider">Order Number</span>
                <span class="font-black text-brand-primary text-sm font-mono">{{ $order->order_number }}</span>
            </div>
            <div>
                <span class="text-[10px] font-black text-content-muted block uppercase tracking-wider">Date</span>
                <span class="font-bold text-content-primary text-sm">{{ $order->created_at->format('M d, Y') }}</span>
            </div>
            <div>
                <span class="text-[10px] font-black text-content-muted block uppercase tracking-wider">Payment Method</span>
                <span class="font-bold text-content-primary text-sm uppercase">{{ $order->payment_method }}</span>
            </div>
            <div>
                <span class="text-[10px] font-black text-content-muted block uppercase tracking-wider">Order Status</span>
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-black bg-amber-500/10 text-amber-500 capitalize">
                    {{ $order->order_status }}
                </span>
            </div>
        </div>

        <!-- Items Ordered -->
        <div class="space-y-4">
            <h3 class="font-black text-content-primary text-base border-b border-line-subtle pb-2">Purchased Items</h3>
            <div class="divide-y divide-line-subtle">
                @foreach($order->items as $item)
                    <div class="py-4 flex items-center justify-between gap-4">
                        <div class="flex items-center gap-4">
                            @if($item->product && $item->product->image)
                                <img src="{{ $item->product->image }}" alt="{{ $item->product_name }}" class="w-14 h-14 rounded-2xl object-cover border border-line-subtle shrink-0">
                            @else
                                <div class="w-14 h-14 bg-surface-elevated rounded-2xl flex items-center justify-center text-content-muted">
                                    <i class="fa-solid fa-box"></i>
                                </div>
                            @endif
                            <div>
                                <h4 class="font-bold text-sm text-content-primary">{{ $item->product_name }}</h4>
                                <span class="text-xs text-content-muted">Qty: {{ $item->quantity }} &times; ${{ number_format($item->price, 2) }}</span>
                            </div>
                        </div>
                        <span class="font-black text-sm text-content-primary">${{ number_format($item->subtotal, 2) }}</span>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Order Summary & Shipping Address Breakdown -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 pt-6 border-t border-line-subtle">
            <div>
                <h4 class="font-black text-xs uppercase tracking-wider text-content-muted mb-2">Shipping Information</h4>
                <div class="text-sm text-content-secondary space-y-1">
                    <p class="font-bold text-content-primary">{{ $order->customer_name }}</p>
                    <p>{{ $order->shipping_address }}</p>
                    <p>{{ $order->city }} {{ $order->postal_code ? '- ' . $order->postal_code : '' }}</p>
                    <p class="text-content-muted">{{ $order->customer_phone }}</p>
                </div>
            </div>

            <div class="space-y-2 text-sm sm:text-right">
                @if($order->coupon_code)
                    <div class="flex justify-between sm:justify-end gap-6 text-emerald-400 font-bold">
                        <span>Coupon Discount ({{ $order->coupon_code }}):</span>
                        <span>-${{ number_format($order->discount_amount, 2) }}</span>
                    </div>
                @endif
                <div class="flex justify-between sm:justify-end gap-6 text-content-secondary">
                    <span>Total Amount:</span>
                    <span class="text-xl font-black text-brand-primary">${{ number_format($order->total_amount, 2) }}</span>
                </div>
            </div>
        </div>

        <!-- CTA Back to Shop -->
        <div class="pt-6 border-t border-line-subtle text-center">
            <x-button variant="primary" size="lg" href="{{ route('shop.index') }}" icon="fa-solid fa-cube">
                Continue Exploring 3D Catalog
            </x-button>
        </div>

    </div>
</div>
@endsection