@extends('layouts.app')

@section('title', 'Shopping Cart - SM Shop 3D')

@section('content')
<div class="bg-surface border-b border-line-subtle py-8 transition-colors duration-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-2xl sm:text-3xl font-black text-content-primary">Your Shopping Cart</h1>
        <p class="text-xs sm:text-sm text-content-muted mt-1">Review your 3D selected gear before proceeding to secure checkout</p>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    @if(!empty($cart) && count($cart) > 0)
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
            
            <!-- Cart Items List -->
            <div class="lg:col-span-8 space-y-4">
                <div class="bg-surface rounded-3xl border border-line-subtle shadow-xs overflow-hidden transition-colors duration-200">
                    <div class="p-6 border-b border-line-subtle flex items-center justify-between">
                        <span class="font-black text-content-primary text-sm">
                            {{ count($cart) }} {{ Str::plural('Item', count($cart)) }} in Cart
                        </span>
                        <form action="{{ route('cart.clear') }}" method="POST" onsubmit="return confirm('Are you sure you want to clear your entire cart?');">
                            @csrf
                            <button type="submit" class="text-xs font-bold text-status-danger hover:underline transition cursor-pointer">
                                <i class="fa-solid fa-trash-can mr-1"></i> Clear Cart
                            </button>
                        </form>
                    </div>

                    <div class="divide-y divide-line-subtle">
                        @foreach($cart as $id => $item)
                            <div class="p-6 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 hover:bg-surface-elevated/50 transition">
                                
                                <div class="flex items-center gap-4 flex-1">
                                    <img 
                                        src="{{ $item['image'] }}" 
                                        alt="{{ $item['name'] }}" 
                                        class="w-20 h-20 rounded-2xl object-cover border border-line-subtle shrink-0"
                                    >
                                    <div>
                                        <h3 class="font-bold text-content-primary text-sm hover:text-brand-primary transition">
                                            <a href="{{ route('product.show', $item['slug']) }}">{{ $item['name'] }}</a>
                                        </h3>
                                        <p class="text-xs text-content-muted mt-0.5 font-mono">Unit: ${{ number_format($item['price'], 2) }}</p>
                                    </div>
                                </div>

                                <div class="flex items-center justify-between sm:justify-end gap-6 w-full sm:w-auto">
                                    
                                    <!-- Quantity Update Form -->
                                    <form action="{{ route('cart.update', $id) }}" method="POST" class="flex items-center border border-line-subtle rounded-2xl bg-surface-elevated p-1">
                                        @csrf
                                        <button type="submit" name="quantity" value="{{ $item['quantity'] - 1 }}" class="w-8 h-8 flex items-center justify-center text-content-primary hover:bg-surface rounded-xl transition font-black text-sm cursor-pointer">-</button>
                                        <span class="w-10 text-center font-black text-xs text-content-primary">{{ $item['quantity'] }}</span>
                                        <button type="submit" name="quantity" value="{{ $item['quantity'] + 1 }}" class="w-8 h-8 flex items-center justify-center text-content-primary hover:bg-surface rounded-xl transition font-black text-sm cursor-pointer">+</button>
                                    </form>

                                    <!-- Item Subtotal -->
                                    <div class="text-right min-w-[80px]">
                                        <span class="font-black text-content-primary text-base block">
                                            ${{ number_format($item['price'] * $item['quantity'], 2) }}
                                        </span>
                                    </div>

                                    <!-- Remove Button -->
                                    <form action="{{ route('cart.remove', $id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="w-8 h-8 rounded-full hover:bg-rose-500/10 text-content-muted hover:text-status-danger flex items-center justify-center transition cursor-pointer" title="Remove Item">
                                            <i class="fa-solid fa-xmark text-sm"></i>
                                        </button>
                                    </form>

                                </div>

                            </div>
                        @endforeach
                    </div>

                    <div class="p-6 bg-surface-elevated border-t border-line-subtle flex items-center justify-between">
                        <a href="{{ route('shop.index') }}" class="text-xs font-bold text-brand-primary hover:underline flex items-center gap-1.5">
                            <i class="fa-solid fa-arrow-left"></i> Continue Shopping
                        </a>
                    </div>
                </div>
            </div>

            <!-- Order Summary Card & Promo Code Voucher Engine -->
            <div class="lg:col-span-4 space-y-6">
                
                <!-- Promo Coupon Form Box -->
                <div class="bg-surface rounded-3xl border border-line-subtle p-6 shadow-xs space-y-4 transition-colors duration-200">
                    <h3 class="font-black text-content-primary text-xs uppercase tracking-wider flex items-center gap-2">
                        <i class="fa-solid fa-ticket text-brand-primary"></i> Have a Promo Voucher?
                    </h3>

                    @if($couponData)
                        <div class="p-3.5 rounded-2xl bg-emerald-500/10 border border-emerald-500/30 flex items-center justify-between text-xs">
                            <div>
                                <span class="font-black text-emerald-400 font-mono">{{ $couponData['code'] }}</span>
                                <span class="text-emerald-500 text-[11px] block">Coupon Active</span>
                            </div>
                            <form action="{{ route('cart.coupon.remove') }}" method="POST">
                                @csrf
                                <button type="submit" class="text-xs text-status-danger hover:underline font-bold cursor-pointer">
                                    Remove
                                </button>
                            </form>
                        </div>
                    @else
                        <form action="{{ route('cart.coupon.apply') }}" method="POST" class="flex gap-2">
                            @csrf
                            <input 
                                type="text" 
                                name="code" 
                                placeholder="e.g. SM20" 
                                class="flex-1 px-4 py-2.5 rounded-xl border border-line-subtle bg-surface-elevated text-content-primary text-xs font-mono font-bold uppercase focus:outline-none focus:ring-2 focus:ring-brand-primary" 
                                required
                            >
                            <x-button variant="secondary" size="sm" type="submit">
                                Apply
                            </x-button>
                        </form>
                        <span class="text-[10px] text-content-muted font-bold">Use code <strong>SM20</strong> for 20% off</span>
                    @endif
                </div>

                <!-- Order Totals Box -->
                <div class="bg-surface rounded-3xl border border-line-subtle p-6 shadow-xs space-y-5 transition-colors duration-200">
                    <h3 class="font-black text-content-primary text-base border-b border-line-subtle pb-3">Order Summary</h3>

                    <div class="space-y-3 text-xs">
                        <div class="flex items-center justify-between text-content-secondary">
                            <span>Subtotal</span>
                            <span class="font-bold text-content-primary">${{ number_format($subtotal, 2) }}</span>
                        </div>

                        @if($discount > 0)
                            <div class="flex items-center justify-between text-emerald-400 font-bold">
                                <span>Promo Discount ({{ $couponData['code'] ?? '' }})</span>
                                <span>-${{ number_format($discount, 2) }}</span>
                            </div>
                        @endif

                        <div class="flex items-center justify-between text-content-secondary">
                            <span>Estimated Shipping</span>
                            @if($shipping == 0)
                                <span class="font-bold text-status-success">FREE EXPRESS</span>
                            @else
                                <span class="font-bold text-content-primary">${{ number_format($shipping, 2) }}</span>
                            @endif
                        </div>

                        <!-- Free Shipping Progress -->
                        @if($subtotal < 100)
                            <div class="p-3 bg-surface-elevated rounded-2xl border border-line-subtle space-y-1 text-[11px]">
                                <span class="text-content-muted">Add <strong>${{ number_format(100 - $subtotal, 2) }}</strong> more to unlock <strong>Free Express Shipping</strong></span>
                                <div class="w-full h-1.5 bg-slate-200 dark:bg-slate-800 rounded-full overflow-hidden">
                                    <div class="h-full bg-brand-primary rounded-full" style="width: {{ ($subtotal / 100) * 100 }}%;"></div>
                                </div>
                            </div>
                        @endif

                        <div class="border-t border-line-subtle pt-3 flex items-center justify-between text-base font-black text-content-primary">
                            <span>Estimated Total</span>
                            <span class="text-xl text-brand-primary">${{ number_format($total, 2) }}</span>
                        </div>
                    </div>

                    <div class="pt-2">
                        <x-button variant="primary" size="lg" :fullWidth="true" href="{{ route('checkout.index') }}" icon="fa-solid fa-lock">
                            Proceed to Checkout
                        </x-button>
                    </div>
                </div>

            </div>

        </div>
    @else
        <div class="text-center py-20 bg-surface rounded-3xl border border-line-subtle p-8 space-y-4 max-w-lg mx-auto">
            <div class="w-20 h-20 rounded-3xl bg-surface-elevated text-content-muted flex items-center justify-center text-3xl mx-auto shadow-inner">
                <i class="fa-solid fa-bag-shopping"></i>
            </div>
            <h2 class="text-2xl font-black text-content-primary">Your Cart is Empty</h2>
            <p class="text-xs text-content-secondary max-w-sm mx-auto">Looks like you haven't added any products to your cart yet. Explore our 3D interactive catalog to discover top gear.</p>
            <div class="pt-4">
                <x-button variant="primary" size="md" href="{{ route('shop.index') }}" icon="fa-solid fa-cube">
                    Explore 3D Catalog
                </x-button>
            </div>
        </div>
    @endif
</div>
@endsection