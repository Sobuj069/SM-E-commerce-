@extends('layouts.app')

@section('title', 'Shopping Cart - Star Tech')

@section('content')
<!-- Cart Breadcrumb Strip -->
<div class="bg-white border-b border-slate-200 py-3">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <nav class="flex text-xs font-medium text-slate-500 gap-2 items-center">
            <a href="{{ route('home') }}" class="hover:text-starOrange"><i class="fa-solid fa-house text-slate-400"></i></a>
            <span>/</span>
            <a href="{{ route('shop.index') }}" class="hover:text-starOrange">Shop</a>
            <span>/</span>
            <span class="text-slate-800 font-semibold">Shopping Cart</span>
        </nav>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="mb-6 flex items-center justify-between">
        <div>
            <h1 class="text-xl sm:text-2xl font-bold text-slate-900">Shopping Cart</h1>
            <p class="text-xs text-slate-500 mt-0.5">Review items in your cart before checkout</p>
        </div>
        @if(!empty($cart) && count($cart) > 0)
            <form action="{{ route('cart.clear') }}" method="POST" onsubmit="return confirm('Clear your entire cart?');">
                @csrf
                <button type="submit" class="text-xs text-red-600 hover:text-red-700 font-semibold cursor-pointer flex items-center gap-1">
                    <i class="fa-solid fa-trash-can"></i> Clear Cart
                </button>
            </form>
        @endif
    </div>

    @if(!empty($cart) && count($cart) > 0)
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
            
            <!-- Cart Items List -->
            <div class="lg:col-span-8 space-y-4">
                <div class="bg-white rounded-lg border border-slate-200 shadow-xs overflow-hidden">
                    <div class="p-4 bg-slate-50 border-b border-slate-200 hidden sm:grid sm:grid-cols-12 text-xs font-bold text-slate-700">
                        <div class="sm:col-span-6">Product Details</div>
                        <div class="sm:col-span-2 text-center">Unit Price</div>
                        <div class="sm:col-span-2 text-center">Quantity</div>
                        <div class="sm:col-span-2 text-right">Total</div>
                    </div>

                    <div class="divide-y divide-slate-100">
                        @foreach($cart as $id => $item)
                            <div class="p-4 flex flex-col sm:grid sm:grid-cols-12 items-start sm:items-center gap-4 hover:bg-slate-50/50 transition">
                                
                                <!-- Product Details -->
                                <div class="sm:col-span-6 flex items-center gap-3 w-full">
                                    <img 
                                        src="{{ $item['image'] }}" 
                                        alt="{{ $item['name'] }}" 
                                        class="w-16 h-16 rounded object-contain bg-white border border-slate-200 p-1 shrink-0"
                                    >
                                    <div class="min-w-0 flex-1">
                                        <h3 class="font-semibold text-slate-800 text-xs sm:text-sm hover:text-starOrange line-clamp-2 leading-snug">
                                            <a href="{{ route('product.show', $item['slug']) }}">{{ $item['name'] }}</a>
                                        </h3>
                                        <div class="text-[11px] text-emerald-600 font-medium mt-0.5">
                                            <i class="fa-solid fa-circle-check text-[10px]"></i> In Stock
                                        </div>
                                    </div>
                                </div>

                                <!-- Unit Price -->
                                <div class="sm:col-span-2 text-left sm:text-center text-xs font-semibold text-slate-700">
                                    <span class="sm:hidden text-slate-400 font-normal">Price: </span>
                                    {{ number_format($item['price']) }}৳
                                </div>

                                <!-- Quantity Form -->
                                <div class="sm:col-span-2 flex items-center justify-start sm:justify-center">
                                    <form action="{{ route('cart.update', $id) }}" method="POST" class="flex items-center border border-slate-300 rounded bg-white">
                                        @csrf
                                        <button type="submit" name="quantity" value="{{ $item['quantity'] - 1 }}" class="w-7 h-7 flex items-center justify-center text-slate-700 hover:bg-slate-100 transition font-bold text-xs cursor-pointer">-</button>
                                        <span class="w-8 text-center font-bold text-xs text-slate-900">{{ $item['quantity'] }}</span>
                                        <button type="submit" name="quantity" value="{{ $item['quantity'] + 1 }}" class="w-7 h-7 flex items-center justify-center text-slate-700 hover:bg-slate-100 transition font-bold text-xs cursor-pointer">+</button>
                                    </form>
                                </div>

                                <!-- Subtotal & Remove -->
                                <div class="sm:col-span-2 flex items-center justify-between sm:justify-end gap-3 w-full sm:w-auto">
                                    <span class="font-bold text-starOrange text-sm">
                                        {{ number_format($item['price'] * $item['quantity']) }}৳
                                    </span>
                                    <form action="{{ route('cart.remove', $id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="text-slate-400 hover:text-red-600 transition p-1 cursor-pointer" title="Remove Item">
                                            <i class="fa-solid fa-xmark text-sm"></i>
                                        </button>
                                    </form>
                                </div>

                            </div>
                        @endforeach
                    </div>

                    <div class="p-4 bg-slate-50 border-t border-slate-200 flex items-center justify-between">
                        <a href="{{ route('shop.index') }}" class="text-xs font-semibold text-starBlue hover:underline flex items-center gap-1.5">
                            <i class="fa-solid fa-arrow-left"></i> Continue Shopping
                        </a>
                    </div>
                </div>
            </div>

            <!-- Order Summary Card -->
            <div class="lg:col-span-4 space-y-6">
                
                <!-- Promo Coupon Form Box -->
                <div class="bg-white rounded-lg border border-slate-200 p-5 shadow-xs space-y-3">
                    <h3 class="font-bold text-slate-900 text-xs uppercase tracking-wider flex items-center gap-2">
                        <i class="fa-solid fa-ticket text-starOrange"></i> Promo Code / Voucher
                    </h3>

                    @if($couponData)
                        <div class="p-3 rounded bg-emerald-50 border border-emerald-200 flex items-center justify-between text-xs">
                            <div>
                                <span class="font-bold text-emerald-800 font-mono">{{ $couponData['code'] }}</span>
                                <span class="text-emerald-600 text-[11px] block">Promo code applied</span>
                            </div>
                            <form action="{{ route('cart.coupon.remove') }}" method="POST">
                                @csrf
                                <button type="submit" class="text-xs text-red-600 hover:underline font-bold cursor-pointer">
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
                                placeholder="Promo Code (e.g. STAR1000)" 
                                class="flex-1 px-3 py-2 rounded border border-slate-300 bg-white text-slate-800 text-xs font-mono font-bold uppercase focus:outline-none focus:border-starBlue" 
                                required
                            >
                            <button type="submit" class="bg-starBlue hover:bg-starBlueDark text-white text-xs font-bold px-4 py-2 rounded transition cursor-pointer">
                                Apply
                            </button>
                        </form>
                        <span class="text-[11px] text-slate-500 block">Use <strong class="text-slate-800">STAR1000</strong> for 1,000৳ discount on 15,000৳+</span>
                    @endif
                </div>

                <!-- Order Totals Box -->
                <div class="bg-white rounded-lg border border-slate-200 p-5 shadow-xs space-y-4">
                    <h3 class="font-bold text-slate-900 text-sm border-b border-slate-100 pb-2">Order Summary</h3>

                    <div class="space-y-2.5 text-xs text-slate-700">
                        <div class="flex items-center justify-between">
                            <span>Subtotal:</span>
                            <span class="font-semibold text-slate-900">{{ number_format($subtotal) }}৳</span>
                        </div>

                        @if($discount > 0)
                            <div class="flex items-center justify-between text-emerald-600 font-semibold">
                                <span>Discount:</span>
                                <span>-{{ number_format($discount) }}৳</span>
                            </div>
                        @endif

                        <div class="flex items-center justify-between">
                            <span>Estimated Delivery:</span>
                            <span class="text-emerald-600 font-semibold">{{ ($shipping ?? 0) == 0 ? 'FREE' : number_format($shipping) . '৳' }}</span>
                        </div>

                        <div class="border-t border-slate-200 pt-3 flex items-center justify-between text-base font-bold text-slate-900">
                            <span>Total Amount:</span>
                            <span class="text-starOrange font-bold">{{ number_format($total ?? 0) }}৳</span>
                        </div>
                    </div>

                    <div class="pt-2">
                        <a 
                            href="{{ route('checkout.index') }}" 
                            class="w-full bg-starOrange hover:bg-starOrangeHover text-white text-xs font-bold uppercase tracking-wider py-3.5 px-6 rounded transition flex items-center justify-center gap-2 shadow-md cursor-pointer"
                        >
                            Proceed to Checkout <i class="fa-solid fa-arrow-right"></i>
                        </a>
                    </div>
                </div>

            </div>

        </div>
    @else
        <div class="text-center py-16 bg-white rounded-lg border border-slate-200 p-8 space-y-4 max-w-lg mx-auto">
            <div class="w-16 h-16 rounded-full bg-slate-100 text-slate-400 flex items-center justify-center text-2xl mx-auto">
                <i class="fa-solid fa-cart-arrow-down"></i>
            </div>
            <h2 class="text-xl font-bold text-slate-800">Your Cart is Empty!</h2>
            <p class="text-xs text-slate-500">Looks like you haven't added any tech products to your cart yet.</p>
            <div class="pt-2">
                <a href="{{ route('shop.index') }}" class="inline-block bg-starBlue hover:bg-starBlueDark text-white text-xs font-bold py-2.5 px-8 rounded transition">
                    Start Shopping
                </a>
            </div>
        </div>
    @endif
</div>
@endsection