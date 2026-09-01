@extends('layouts.app')

@section('title', 'Your Bag - SM Shop')

@section('content')
<div class="bg-zinc-100 border-b border-zinc-200 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-2xl sm:text-4xl font-black text-black uppercase tracking-tight">YOUR SHOPPING BAG</h1>
        <p class="text-xs text-zinc-500 uppercase tracking-wider font-semibold mt-1">REVIEW ITEMS BEFORE PROCEEDING TO CHECKOUT</p>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    @if(!empty($cart) && count($cart) > 0)
        @php
            $freeThreshold = 75;
            $diff = max(0, $freeThreshold - $subtotal);
            $progress = min(100, round(($subtotal / $freeThreshold) * 100));
        @endphp

        <!-- Gymshark Free Shipping Progress Bar -->
        <div class="mb-8 p-4 bg-white rounded-2xl border border-zinc-200 max-w-7xl mx-auto space-y-2">
            <div class="flex items-center justify-between text-xs font-black uppercase tracking-wider text-black">
                @if($diff == 0)
                    <span class="text-emerald-600 flex items-center gap-1.5"><i class="fa-solid fa-circle-check"></i> YOU UNLOCKED FREE STANDARD SHIPPING!</span>
                @else
                    <span>ADD ${{ number_format($diff, 2) }} MORE TO GET <strong>FREE STANDARD SHIPPING</strong></span>
                @endif
                <span>{{ $progress }}%</span>
            </div>
            <div class="w-full h-2 bg-zinc-100 rounded-full overflow-hidden">
                <div class="h-full bg-black rounded-full transition-all duration-500" style="width: {{ $progress }}%;"></div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
            
            <!-- Cart Items List -->
            <div class="lg:col-span-8 space-y-4">
                <div class="bg-white rounded-2xl border border-zinc-200 shadow-xs overflow-hidden">
                    <div class="p-5 border-b border-zinc-200 flex items-center justify-between">
                        <span class="font-black text-black text-xs uppercase tracking-widest">
                            {{ count($cart) }} {{ Str::plural('ITEM', count($cart)) }} IN BAG
                        </span>
                        <form action="{{ route('cart.clear') }}" method="POST" onsubmit="return confirm('Clear your entire cart?');">
                            @csrf
                            <button type="submit" class="text-xs font-black text-red-600 uppercase tracking-wider hover:underline cursor-pointer">
                                CLEAR BAG
                            </button>
                        </form>
                    </div>

                    <div class="divide-y divide-zinc-200">
                        @foreach($cart as $id => $item)
                            <div class="p-6 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 hover:bg-zinc-50 transition">
                                
                                <div class="flex items-center gap-4 flex-1">
                                    <img 
                                        src="{{ $item['image'] }}" 
                                        alt="{{ $item['name'] }}" 
                                        class="w-20 h-24 rounded-xl object-cover bg-[#f4f4f5] border border-zinc-200 shrink-0"
                                    >
                                    <div>
                                        <h3 class="font-bold text-black text-sm uppercase tracking-tight hover:underline">
                                            <a href="{{ route('product.show', $item['slug']) }}">{{ $item['name'] }}</a>
                                        </h3>
                                        <p class="text-xs text-zinc-500 mt-0.5 font-bold">${{ number_format($item['price'], 2) }} EACH</p>
                                    </div>
                                </div>

                                <div class="flex items-center justify-between sm:justify-end gap-6 w-full sm:w-auto">
                                    
                                    <!-- Quantity Picker -->
                                    <form action="{{ route('cart.update', $id) }}" method="POST" class="flex items-center border border-zinc-300 rounded-full bg-white p-1">
                                        @csrf
                                        <button type="submit" name="quantity" value="{{ $item['quantity'] - 1 }}" class="w-8 h-8 flex items-center justify-center text-black hover:bg-zinc-100 rounded-full transition font-black text-xs cursor-pointer">-</button>
                                        <span class="w-8 text-center font-black text-xs text-black">{{ $item['quantity'] }}</span>
                                        <button type="submit" name="quantity" value="{{ $item['quantity'] + 1 }}" class="w-8 h-8 flex items-center justify-center text-black hover:bg-zinc-100 rounded-full transition font-black text-xs cursor-pointer">+</button>
                                    </form>

                                    <!-- Item Subtotal -->
                                    <div class="text-right min-w-[80px]">
                                        <span class="font-black text-black text-sm block">
                                            ${{ number_format($item['price'] * $item['quantity'], 2) }}
                                        </span>
                                    </div>

                                    <!-- Remove Button -->
                                    <form action="{{ route('cart.remove', $id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="w-8 h-8 rounded-full hover:bg-zinc-100 text-zinc-400 hover:text-black flex items-center justify-center transition cursor-pointer" title="Remove Item">
                                            <i class="fa-solid fa-xmark text-xs"></i>
                                        </button>
                                    </form>

                                </div>

                            </div>
                        @endforeach
                    </div>

                    <div class="p-5 bg-zinc-50 border-t border-zinc-200 flex items-center justify-between">
                        <a href="{{ route('shop.index') }}" class="text-xs font-black uppercase tracking-wider text-black hover:underline flex items-center gap-1.5">
                            <i class="fa-solid fa-arrow-left"></i> CONTINUE SHOPPING
                        </a>
                    </div>
                </div>
            </div>

            <!-- Order Summary Card -->
            <div class="lg:col-span-4 space-y-6">
                
                <!-- Promo Coupon Form Box -->
                <div class="bg-white rounded-2xl border border-zinc-200 p-6 shadow-xs space-y-3">
                    <h3 class="font-black text-black text-xs uppercase tracking-widest flex items-center gap-2">
                        <i class="fa-solid fa-ticket"></i> PROMO VOUCHER
                    </h3>

                    @if($couponData)
                        <div class="p-3.5 rounded-xl bg-zinc-100 border border-zinc-200 flex items-center justify-between text-xs">
                            <div>
                                <span class="font-black text-black font-mono uppercase">{{ $couponData['code'] }}</span>
                                <span class="text-emerald-600 text-[10px] font-bold block uppercase">20% VOUCHER APPLIED</span>
                            </div>
                            <form action="{{ route('cart.coupon.remove') }}" method="POST">
                                @csrf
                                <button type="submit" class="text-xs text-red-600 hover:underline font-black uppercase cursor-pointer">
                                    REMOVE
                                </button>
                            </form>
                        </div>
                    @else
                        <form action="{{ route('cart.coupon.apply') }}" method="POST" class="flex gap-2">
                            @csrf
                            <input 
                                type="text" 
                                name="code" 
                                placeholder="ENTER CODE (e.g. SM20)" 
                                class="flex-1 px-4 py-2.5 rounded-full border border-zinc-300 bg-white text-black text-xs font-mono font-bold uppercase focus:outline-none focus:border-black" 
                                required
                            >
                            <button type="submit" class="bg-black hover:bg-zinc-800 text-white text-xs font-black uppercase tracking-widest px-5 py-2.5 rounded-full transition cursor-pointer">
                                APPLY
                            </button>
                        </form>
                        <span class="text-[10px] text-zinc-500 font-bold uppercase">USE CODE: <strong class="text-black">SM20</strong> FOR 20% OFF</span>
                    @endif
                </div>

                <!-- Order Totals Box -->
                <div class="bg-white rounded-2xl border border-zinc-200 p-6 shadow-xs space-y-4">
                    <h3 class="font-black text-black text-sm uppercase tracking-widest border-b border-zinc-200 pb-3">ORDER SUMMARY</h3>

                    <div class="space-y-2.5 text-xs font-bold uppercase">
                        <div class="flex items-center justify-between text-zinc-600">
                            <span>SUBTOTAL</span>
                            <span class="text-black">${{ number_format($subtotal, 2) }}</span>
                        </div>

                        @if($discount > 0)
                            <div class="flex items-center justify-between text-red-600">
                                <span>PROMO DISCOUNT</span>
                                <span>-${{ number_format($discount, 2) }}</span>
                            </div>
                        @endif

                        <div class="flex items-center justify-between text-zinc-600">
                            <span>DELIVERY</span>
                            <span>{{ $shipping == 0 ? 'FREE' : '$' . number_format($shipping, 2) }}</span>
                        </div>

                        <div class="flex items-center justify-between text-zinc-600">
                            <span>ESTIMATED TAX</span>
                            <span class="text-black">${{ number_format($tax, 2) }}</span>
                        </div>

                        <div class="border-t border-zinc-200 pt-3 flex items-center justify-between text-base font-black text-black">
                            <span>TOTAL</span>
                            <span>${{ number_format($total, 2) }}</span>
                        </div>
                    </div>

                    <div class="pt-2">
                        <a 
                            href="{{ route('checkout.index') }}" 
                            class="w-full bg-black hover:bg-zinc-800 text-white text-xs font-black uppercase tracking-widest py-4 px-8 rounded-full transition flex items-center justify-center gap-2 shadow-lg cursor-pointer"
                        >
                            PROCEED TO CHECKOUT <i class="fa-solid fa-arrow-right"></i>
                        </a>
                    </div>
                </div>

            </div>

        </div>
    @else
        <div class="text-center py-20 bg-white rounded-2xl border border-zinc-200 p-8 space-y-4 max-w-xl mx-auto">
            <div class="w-16 h-16 rounded-full bg-zinc-100 text-black flex items-center justify-center text-2xl mx-auto">
                <i class="fa-solid fa-bag-shopping"></i>
            </div>
            <h2 class="text-2xl font-black text-black uppercase tracking-tight">YOUR BAG IS EMPTY</h2>
            <p class="text-xs text-zinc-500 uppercase font-semibold">Explore our latest 3D drops and active essentials.</p>
            <div class="pt-2">
                <a href="{{ route('shop.index') }}" class="inline-block bg-black hover:bg-zinc-800 text-white text-xs font-black uppercase tracking-widest py-3.5 px-8 rounded-full transition">
                    START SHOPPING
                </a>
            </div>
        </div>
    @endif
</div>
@endsection