@extends('layouts.app')

@section('title', 'Shopping Cart - SM E-Commerce')

@section('content')
<div class="bg-white border-b border-slate-200 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900">Your Shopping Cart</h1>
        <p class="text-xs sm:text-sm text-slate-500 mt-1">Review your items before proceeding to secure checkout</p>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    @if(!empty($cart) && count($cart) > 0)
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
            
            <!-- Cart Items List -->
            <div class="lg:col-span-8 space-y-4">
                <div class="bg-white rounded-3xl border border-slate-200 shadow-xs overflow-hidden">
                    <div class="p-6 border-b border-slate-100 flex items-center justify-between">
                        <span class="font-bold text-slate-800 text-sm">
                            {{ count($cart) }} {{ Str::plural('Item', count($cart)) }} in Cart
                        </span>
                        <form action="{{ route('cart.clear') }}" method="POST" onsubmit="return confirm('Are you sure you want to clear your cart?');">
                            @csrf
                            <button type="submit" class="text-xs font-semibold text-rose-600 hover:text-rose-800 transition">
                                <i class="fa-solid fa-trash-can mr-1"></i> Clear Cart
                            </button>
                        </form>
                    </div>

                    <div class="divide-y divide-slate-100">
                        @foreach($cart as $id => $item)
                            <div class="p-6 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 hover:bg-slate-50/50 transition">
                                
                                <div class="flex items-center gap-4 flex-1">
                                    <img 
                                        src="{{ $item['image'] }}" 
                                        alt="{{ $item['name'] }}" 
                                        class="w-20 h-20 rounded-xl object-cover border border-slate-200 shrink-0"
                                    >
                                    <div>
                                        <h3 class="font-bold text-slate-900 text-sm hover:text-indigo-600 transition">
                                            <a href="{{ route('product.show', $item['slug']) }}">{{ $item['name'] }}</a>
                                        </h3>
                                        <p class="text-xs text-slate-400 mt-0.5">Unit Price: ${{ number_format($item['price'], 2) }}</p>
                                    </div>
                                </div>

                                <div class="flex items-center justify-between sm:justify-end gap-6 w-full sm:w-auto">
                                    
                                    <!-- Quantity Update Form -->
                                    <form action="{{ route('cart.update', $id) }}" method="POST" class="flex items-center border border-slate-200 rounded-xl bg-slate-50 p-1">
                                        @csrf
                                        <button type="submit" name="quantity" value="{{ $item['quantity'] - 1 }}" class="w-8 h-8 flex items-center justify-center text-slate-600 hover:bg-white rounded-lg transition font-bold text-sm">-</button>
                                        <span class="w-10 text-center font-bold text-xs text-slate-800">{{ $item['quantity'] }}</span>
                                        <button type="submit" name="quantity" value="{{ $item['quantity'] + 1 }}" class="w-8 h-8 flex items-center justify-center text-slate-600 hover:bg-white rounded-lg transition font-bold text-sm">+</button>
                                    </form>

                                    <!-- Item Subtotal -->
                                    <div class="text-right min-w-[80px]">
                                        <span class="font-black text-slate-900 text-base block">
                                            ${{ number_format($item['price'] * $item['quantity'], 2) }}
                                        </span>
                                    </div>

                                    <!-- Remove Button -->
                                    <form action="{{ route('cart.remove', $id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="w-8 h-8 rounded-full hover:bg-rose-50 text-slate-400 hover:text-rose-600 flex items-center justify-center transition" title="Remove Item">
                                            <i class="fa-solid fa-xmark text-sm"></i>
                                        </button>
                                    </form>

                                </div>

                            </div>
                        @endforeach
                    </div>

                    <div class="p-6 bg-slate-50 border-t border-slate-100 flex items-center justify-between">
                        <a href="{{ route('shop.index') }}" class="text-xs font-bold text-indigo-600 hover:text-indigo-800 flex items-center gap-1.5">
                            <i class="fa-solid fa-arrow-left"></i> Continue Shopping
                        </a>
                    </div>
                </div>
            </div>

            <!-- Order Summary Card -->
            <div class="lg:col-span-4 space-y-6">
                <div class="bg-white rounded-3xl border border-slate-200 p-6 shadow-xs space-y-5">
                    <h3 class="font-extrabold text-slate-900 text-lg border-b border-slate-100 pb-3">Order Summary</h3>

                    <div class="space-y-3 text-sm">
                        <div class="flex items-center justify-between text-slate-600">
                            <span>Subtotal</span>
                            <span class="font-bold text-slate-800">${{ number_format($subtotal, 2) }}</span>
                        </div>
                        <div class="flex items-center justify-between text-slate-600">
                            <span>Estimated Shipping</span>
                            @if($shipping == 0)
                                <span class="font-bold text-emerald-600">FREE</span>
                            @else
                                <span class="font-bold text-slate-800">${{ number_format($shipping, 2) }}</span>
                            @endif
                        </div>
                        @if($subtotal < 100)
                            <div class="p-3 bg-amber-50 rounded-xl border border-amber-100 text-xs text-amber-800">
                                <i class="fa-solid fa-circle-info mr-1"></i> Add <strong>${{ number_format(100 - $subtotal, 2) }}</strong> more to unlock <strong>Free Shipping</strong>!
                            </div>
                        @endif
                    </div>

                    <div class="pt-4 border-t border-slate-100 flex items-center justify-between">
                        <span class="font-bold text-slate-900 text-base">Total</span>
                        <span class="text-2xl font-black text-indigo-600">${{ number_format($total, 2) }}</span>
                    </div>

                    <a href="{{ route('checkout.index') }}" class="w-full py-3.5 px-6 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-xl transition flex items-center justify-center gap-2 shadow-md shadow-indigo-200 active:scale-98">
                        Proceed to Checkout <i class="fa-solid fa-arrow-right text-xs"></i>
                    </a>

                    <div class="text-center">
                        <span class="text-[11px] text-slate-400 flex items-center justify-center gap-1.5">
                            <i class="fa-solid fa-lock text-emerald-500"></i> Guaranteed Safe & Secure Checkout
                        </span>
                    </div>
                </div>
            </div>

        </div>
    @else
        <!-- Empty Cart State -->
        <div class="bg-white rounded-3xl border border-slate-200 p-16 text-center max-w-xl mx-auto shadow-xs">
            <div class="w-20 h-20 bg-indigo-50 text-indigo-500 rounded-full flex items-center justify-center text-3xl mx-auto mb-5 shadow-xs">
                <i class="fa-solid fa-cart-shopping"></i>
            </div>
            <h2 class="text-2xl font-extrabold text-slate-900">Your Cart is Currently Empty</h2>
            <p class="text-sm text-slate-500 mt-2 leading-relaxed">
                Looks like you haven't added any products to your shopping cart yet. Discover trending deals in our catalog!
            </p>
            <a href="{{ route('shop.index') }}" class="inline-flex items-center gap-2 mt-6 px-8 py-3.5 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-xl shadow-md shadow-indigo-200 transition">
                Start Shopping <i class="fa-solid fa-arrow-right text-xs"></i>
            </a>
        </div>
    @endif
</div>
@endsection
