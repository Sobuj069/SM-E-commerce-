@extends('layouts.app')

@section('title', 'Secure Checkout - SM Shop')

@section('content')
<div class="bg-zinc-100 border-b border-zinc-200 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-2xl sm:text-4xl font-black text-black uppercase tracking-tight">EXPRESS CHECKOUT</h1>
        <p class="text-xs text-zinc-500 uppercase tracking-wider font-semibold mt-1">ENCRYPTED 256-BIT SSL CONNECTION • GUEST CHECKOUT</p>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10" x-data="{ step: 1, paymentMethod: 'cod' }">
    
    <!-- Multi-Step Progress Header -->
    <div class="max-w-3xl mx-auto mb-10">
        <div class="flex items-center justify-between relative">
            <div class="absolute left-0 top-1/2 -translate-y-1/2 h-1 bg-zinc-200 w-full -z-0"></div>
            <div class="absolute left-0 top-1/2 -translate-y-1/2 h-1 bg-black -z-0 transition-all duration-500" :style="'width: ' + ((step - 1) * 50) + '%'"></div>

            <!-- Step 1 -->
            <button type="button" x-on:click="step = 1" class="relative z-10 flex flex-col items-center gap-2 cursor-pointer">
                <div class="w-10 h-10 rounded-full flex items-center justify-center text-xs font-black transition-all" :class="step >= 1 ? 'bg-black text-white ring-4 ring-zinc-300' : 'bg-zinc-100 text-zinc-400 border border-zinc-300'">
                    1
                </div>
                <span class="text-xs font-black uppercase tracking-wider" :class="step >= 1 ? 'text-black' : 'text-zinc-400'">SHIPPING</span>
            </button>

            <!-- Step 2 -->
            <button type="button" x-on:click="step = 2" class="relative z-10 flex flex-col items-center gap-2 cursor-pointer">
                <div class="w-10 h-10 rounded-full flex items-center justify-center text-xs font-black transition-all" :class="step >= 2 ? 'bg-black text-white ring-4 ring-zinc-300' : 'bg-zinc-100 text-zinc-400 border border-zinc-300'">
                    2
                </div>
                <span class="text-xs font-black uppercase tracking-wider" :class="step >= 2 ? 'text-black' : 'text-zinc-400'">PAYMENT</span>
            </button>

            <!-- Step 3 -->
            <button type="button" x-on:click="step = 3" class="relative z-10 flex flex-col items-center gap-2 cursor-pointer">
                <div class="w-10 h-10 rounded-full flex items-center justify-center text-xs font-black transition-all" :class="step >= 3 ? 'bg-black text-white ring-4 ring-zinc-300' : 'bg-zinc-100 text-zinc-400 border border-zinc-300'">
                    3
                </div>
                <span class="text-xs font-black uppercase tracking-wider" :class="step >= 3 ? 'text-black' : 'text-zinc-400'">REVIEW</span>
            </button>
        </div>
    </div>

    <form action="{{ route('checkout.store') }}" method="POST" id="checkout-form">
        @csrf

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-10">
            
            <!-- Left Form Area -->
            <div class="lg:col-span-7 space-y-8">
                
                <!-- STEP 1: Shipping Details -->
                <div x-show="step === 1" class="bg-white rounded-2xl border border-zinc-200 p-6 sm:p-8 shadow-xs space-y-6">
                    <h2 class="text-sm font-black uppercase tracking-widest text-black flex items-center gap-2.5 pb-4 border-b border-zinc-200">
                        <span class="w-6 h-6 rounded-full bg-black text-white flex items-center justify-center text-xs">1</span>
                        SHIPPING ADDRESS (GUEST CHECKOUT)
                    </h2>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div class="sm:col-span-2">
                            <label class="block text-xs font-black uppercase tracking-wider text-black mb-1.5">FULL NAME *</label>
                            <input 
                                type="text" 
                                name="customer_name" 
                                id="cust_name"
                                value="{{ old('customer_name', 'Alex Johnson') }}" 
                                placeholder="John Doe" 
                                class="w-full px-4 py-3 bg-white border border-zinc-300 rounded-full text-xs font-bold text-black focus:outline-none focus:border-black uppercase"
                                required
                            >
                        </div>

                        <div>
                            <label class="block text-xs font-black uppercase tracking-wider text-black mb-1.5">EMAIL ADDRESS *</label>
                            <input 
                                type="email" 
                                name="customer_email" 
                                id="cust_email"
                                value="{{ old('customer_email', 'alex&#64;example.com') }}" 
                                placeholder="john&#64;example.com" 
                                class="w-full px-4 py-3 bg-white border border-zinc-300 rounded-full text-xs font-bold text-black focus:outline-none focus:border-black"
                                required
                            >
                        </div>

                        <div>
                            <label class="block text-xs font-black uppercase tracking-wider text-black mb-1.5">PHONE NUMBER *</label>
                            <input 
                                type="text" 
                                name="customer_phone" 
                                id="cust_phone"
                                value="{{ old('customer_phone', '+880 1700-000000') }}" 
                                placeholder="+880 1700-000000" 
                                class="w-full px-4 py-3 bg-white border border-zinc-300 rounded-full text-xs font-bold text-black focus:outline-none focus:border-black"
                                required
                            >
                        </div>

                        <div class="sm:col-span-2">
                            <label class="block text-xs font-black uppercase tracking-wider text-black mb-1.5">DELIVERY ADDRESS *</label>
                            <textarea 
                                name="shipping_address" 
                                id="cust_addr"
                                rows="3" 
                                placeholder="House / Flat / Road / Area..." 
                                class="w-full px-4 py-3 bg-white border border-zinc-300 rounded-2xl text-xs font-bold text-black focus:outline-none focus:border-black"
                                required
                            >{{ old('shipping_address', 'House 42, Road 11, Banani, Dhaka') }}</textarea>
                        </div>

                        <div>
                            <label class="block text-xs font-black uppercase tracking-wider text-black mb-1.5">CITY / DISTRICT *</label>
                            <input 
                                type="text" 
                                name="city" 
                                id="cust_city"
                                value="{{ old('city', 'Dhaka') }}" 
                                class="w-full px-4 py-3 bg-white border border-zinc-300 rounded-full text-xs font-bold text-black focus:outline-none focus:border-black uppercase"
                                required
                            >
                        </div>

                        <div>
                            <label class="block text-xs font-black uppercase tracking-wider text-black mb-1.5">POSTAL CODE</label>
                            <input 
                                type="text" 
                                name="postal_code" 
                                value="{{ old('postal_code', '1213') }}" 
                                placeholder="1213" 
                                class="w-full px-4 py-3 bg-white border border-zinc-300 rounded-full text-xs font-bold text-black focus:outline-none focus:border-black uppercase"
                            >
                        </div>
                    </div>

                    <div class="pt-4 flex justify-end">
                        <button type="button" x-on:click="step = 2" class="bg-black hover:bg-zinc-800 text-white text-xs font-black uppercase tracking-widest py-3.5 px-8 rounded-full transition cursor-pointer">
                            CONTINUE TO PAYMENT <i class="fa-solid fa-arrow-right ml-1"></i>
                        </button>
                    </div>
                </div>

                <!-- STEP 2: Payment Method -->
                <div x-show="step === 2" class="bg-white rounded-2xl border border-zinc-200 p-6 sm:p-8 shadow-xs space-y-6" style="display: none;">
                    <h2 class="text-sm font-black uppercase tracking-widest text-black flex items-center gap-2.5 pb-4 border-b border-zinc-200">
                        <span class="w-6 h-6 rounded-full bg-black text-white flex items-center justify-center text-xs">2</span>
                        PAYMENT METHOD
                    </h2>

                    <div class="space-y-3">
                        <label class="p-4 rounded-xl border-2 flex items-center justify-between cursor-pointer transition" :class="paymentMethod === 'cod' ? 'border-black bg-zinc-50' : 'border-zinc-200 hover:border-zinc-400'">
                            <div class="flex items-center gap-3">
                                <input type="radio" name="payment_method" value="cod" x-model="paymentMethod" class="text-black focus:ring-black">
                                <div>
                                    <div class="font-black text-xs uppercase text-black">CASH ON DELIVERY (COD)</div>
                                    <div class="text-[11px] text-zinc-500 font-semibold">Pay upon receiving your items</div>
                                </div>
                            </div>
                            <i class="fa-solid fa-hand-holding-dollar text-xl text-black"></i>
                        </label>

                        <label class="p-4 rounded-xl border-2 flex items-center justify-between cursor-pointer transition" :class="paymentMethod === 'bkash' ? 'border-black bg-zinc-50' : 'border-zinc-200 hover:border-zinc-400'">
                            <div class="flex items-center gap-3">
                                <input type="radio" name="payment_method" value="bkash" x-model="paymentMethod" class="text-black focus:ring-black">
                                <div>
                                    <div class="font-black text-xs uppercase text-black">BKASH / NAGAD (MOBILE BANKING)</div>
                                    <div class="text-[11px] text-zinc-500 font-semibold">Instant merchant checkout</div>
                                </div>
                            </div>
                            <span class="font-black text-xs text-pink-600">bKash</span>
                        </label>

                        <label class="p-4 rounded-xl border-2 flex items-center justify-between cursor-pointer transition" :class="paymentMethod === 'card' ? 'border-black bg-zinc-50' : 'border-zinc-200 hover:border-zinc-400'">
                            <div class="flex items-center gap-3">
                                <input type="radio" name="payment_method" value="card" x-model="paymentMethod" class="text-black focus:ring-black">
                                <div>
                                    <div class="font-black text-xs uppercase text-black">CREDIT / DEBIT CARD (VISA, MASTERCARD)</div>
                                    <div class="text-[11px] text-zinc-500 font-semibold">256-Bit SSL Encrypted</div>
                                </div>
                            </div>
                            <div class="flex gap-1.5 text-lg text-zinc-700">
                                <i class="fa-brands fa-cc-visa"></i>
                                <i class="fa-brands fa-cc-mastercard"></i>
                            </div>
                        </label>
                    </div>

                    <div class="pt-4 flex justify-between">
                        <button type="button" x-on:click="step = 1" class="border border-zinc-300 text-black text-xs font-black uppercase tracking-widest py-3.5 px-6 rounded-full transition cursor-pointer">
                            <i class="fa-solid fa-arrow-left mr-1"></i> BACK
                        </button>
                        <button type="button" x-on:click="step = 3" class="bg-black hover:bg-zinc-800 text-white text-xs font-black uppercase tracking-widest py-3.5 px-8 rounded-full transition cursor-pointer">
                            REVIEW ORDER <i class="fa-solid fa-arrow-right ml-1"></i>
                        </button>
                    </div>
                </div>

                <!-- STEP 3: Review & Finalize -->
                <div x-show="step === 3" class="bg-white rounded-2xl border border-zinc-200 p-6 sm:p-8 shadow-xs space-y-6" style="display: none;">
                    <h2 class="text-sm font-black uppercase tracking-widest text-black flex items-center gap-2.5 pb-4 border-b border-zinc-200">
                        <span class="w-6 h-6 rounded-full bg-black text-white flex items-center justify-center text-xs">3</span>
                        REVIEW & CONFIRM ORDER
                    </h2>

                    <div class="p-4 bg-zinc-50 rounded-xl space-y-2 text-xs font-bold text-zinc-700">
                        <div><strong class="text-black uppercase">PAYMENT:</strong> <span x-text="paymentMethod.toUpperCase()"></span></div>
                        <p class="text-[11px] text-zinc-500 font-semibold">By placing this order, you agree to our 30-Day Easy Returns policy and standard terms of service.</p>
                    </div>

                    <div class="pt-4 flex justify-between">
                        <button type="button" x-on:click="step = 2" class="border border-zinc-300 text-black text-xs font-black uppercase tracking-widest py-3.5 px-6 rounded-full transition cursor-pointer">
                            <i class="fa-solid fa-arrow-left mr-1"></i> BACK
                        </button>
                        <button type="submit" class="bg-black hover:bg-zinc-800 text-white text-xs font-black uppercase tracking-widest py-4 px-10 rounded-full transition shadow-xl cursor-pointer">
                            <i class="fa-solid fa-lock mr-1.5"></i> PLACE ORDER NOW
                        </button>
                    </div>
                </div>

            </div>

            <!-- Right: Order Summary Sidebar -->
            <div class="lg:col-span-5 space-y-6">
                <div class="bg-white rounded-2xl border border-zinc-200 p-6 shadow-xs space-y-4">
                    <h3 class="font-black text-black text-sm uppercase tracking-widest border-b border-zinc-200 pb-3">BAG SUMMARY ({{ count($cart) }})</h3>

                    <div class="divide-y divide-zinc-200 max-h-72 overflow-y-auto pr-2 space-y-3">
                        @foreach($cart as $item)
                            <div class="pt-3 flex items-center justify-between gap-3 text-xs">
                                <div class="flex items-center gap-3">
                                    <img src="{{ $item['image'] }}" alt="{{ $item['name'] }}" class="w-12 h-14 rounded-lg object-cover bg-[#f4f4f5] border border-zinc-200">
                                    <div>
                                        <div class="font-bold text-black uppercase line-clamp-1">{{ $item['name'] }}</div>
                                        <div class="text-zinc-500 text-[11px]">Qty: {{ $item['quantity'] }}</div>
                                    </div>
                                </div>
                                <span class="font-black text-black">${{ number_format($item['price'] * $item['quantity'], 2) }}</span>
                            </div>
                        @endforeach
                    </div>

                    <div class="border-t border-zinc-200 pt-4 space-y-2 text-xs font-bold uppercase">
                        <div class="flex items-center justify-between text-zinc-600">
                            <span>SUBTOTAL</span>
                            <span class="text-black">${{ number_format($subtotal, 2) }}</span>
                        </div>
                        @if($discount > 0)
                            <div class="flex items-center justify-between text-red-600">
                                <span>DISCOUNT</span>
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
                </div>
            </div>

        </div>
    </form>
</div>
@endsection