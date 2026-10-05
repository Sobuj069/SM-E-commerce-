@extends('layouts.app')

@section('title', 'Checkout - SM Shop')

@section('content')
<!-- Checkout Breadcrumbs -->
<div class="bg-white border-b border-slate-200 py-3">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <nav class="flex text-xs font-medium text-slate-500 gap-2 items-center">
            <a href="{{ route('home') }}" class="hover:text-starOrange"><i class="fa-solid fa-house text-slate-400"></i></a>
            <span>/</span>
            <a href="{{ route('cart.index') }}" class="hover:text-starOrange">Shopping Cart</a>
            <span>/</span>
            <span class="text-slate-800 font-semibold">Checkout</span>
        </nav>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8" x-data="{ step: 1, paymentMethod: 'cod' }">
    
    <div class="mb-8">
        <h1 class="text-xl sm:text-2xl font-bold text-slate-900">Checkout</h1>
        <p class="text-xs text-slate-500 mt-0.5">Complete your order with SM Shop Bangladesh</p>
    </div>

    <form action="{{ route('checkout.store') }}" method="POST" id="checkout-form">
        @csrf

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
            
            <!-- Left Form Area -->
            <div class="lg:col-span-7 space-y-6">
                
                <!-- STEP 1: Customer & Delivery Address -->
                <div class="bg-white rounded-lg border border-slate-200 p-6 shadow-xs space-y-5">
                    <h2 class="text-sm font-bold text-slate-900 flex items-center gap-2 pb-3 border-b border-slate-100">
                        <i class="fa-solid fa-truck text-starOrange"></i> 1. Delivery Information
                    </h2>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div class="sm:col-span-2">
                            <label class="block text-xs font-semibold text-slate-700 mb-1">Full Name *</label>
                            <input 
                                type="text" 
                                name="customer_name" 
                                id="cust_name"
                                value="{{ old('customer_name', 'Tariqul Islam') }}" 
                                placeholder="Enter full name" 
                                class="w-full px-3 py-2 bg-white border border-slate-300 rounded text-xs font-medium text-slate-900 focus:outline-none focus:border-starBlue"
                                required
                            >
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1">Mobile Phone *</label>
                            <input 
                                type="text" 
                                name="customer_phone" 
                                id="cust_phone"
                                value="{{ old('customer_phone', '01700-000000') }}" 
                                placeholder="017XXXXXXXX" 
                                class="w-full px-3 py-2 bg-white border border-slate-300 rounded text-xs font-medium text-slate-900 focus:outline-none focus:border-starBlue"
                                required
                            >
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1">Email Address *</label>
                            <input 
                                type="email" 
                                name="customer_email" 
                                id="cust_email"
                                value="{{ old('customer_email', 'customer@example.com') }}" 
                                placeholder="email@example.com" 
                                class="w-full px-3 py-2 bg-white border border-slate-300 rounded text-xs font-medium text-slate-900 focus:outline-none focus:border-starBlue"
                                required
                            >
                        </div>

                        <div class="sm:col-span-2">
                            <label class="block text-xs font-semibold text-slate-700 mb-1">Delivery Address *</label>
                            <textarea 
                                name="shipping_address" 
                                id="cust_addr"
                                rows="3" 
                                placeholder="House / Road / Area details..." 
                                class="w-full px-3 py-2 bg-white border border-slate-300 rounded text-xs font-medium text-slate-900 focus:outline-none focus:border-starBlue"
                                required
                            >{{ old('shipping_address', 'House # 12, Road # 5, Dhanmondi, Dhaka') }}</textarea>
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1">City / District *</label>
                            <input 
                                type="text" 
                                name="city" 
                                id="cust_city"
                                value="{{ old('city', 'Dhaka') }}" 
                                class="w-full px-3 py-2 bg-white border border-slate-300 rounded text-xs font-medium text-slate-900 focus:outline-none focus:border-starBlue"
                                required
                            >
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1">Postal Code</label>
                            <input 
                                type="text" 
                                name="postal_code" 
                                value="{{ old('postal_code', '1205') }}" 
                                placeholder="1205" 
                                class="w-full px-3 py-2 bg-white border border-slate-300 rounded text-xs font-medium text-slate-900 focus:outline-none focus:border-starBlue"
                            >
                        </div>
                    </div>
                </div>

                <!-- STEP 2: Payment Method -->
                <div class="bg-white rounded-lg border border-slate-200 p-6 shadow-xs space-y-4">
                    <h2 class="text-sm font-bold text-slate-900 flex items-center gap-2 pb-3 border-b border-slate-100">
                        <i class="fa-solid fa-credit-card text-starBlue"></i> 2. Payment Method
                    </h2>

                    <div class="space-y-3">
                        <label class="p-3.5 rounded border-2 flex items-center justify-between cursor-pointer transition" :class="paymentMethod === 'cod' ? 'border-starBlue bg-blue-50/30' : 'border-slate-200 hover:border-slate-300'">
                            <div class="flex items-center gap-3">
                                <input type="radio" name="payment_method" value="cod" x-model="paymentMethod" class="text-starBlue focus:ring-starBlue">
                                <div>
                                    <div class="font-bold text-xs text-slate-900">Cash on Delivery (COD)</div>
                                    <div class="text-[11px] text-slate-500">Pay cash upon receiving products at your doorstep</div>
                                </div>
                            </div>
                            <div class="flex items-center gap-1.5">
                                <img src="{{ asset('images/payments/cod.svg') }}" alt="COD" class="h-6 w-auto object-contain rounded">
                            </div>
                        </label>

                        <label class="p-3.5 rounded border-2 flex items-center justify-between cursor-pointer transition" :class="paymentMethod === 'bkash' ? 'border-starBlue bg-blue-50/30' : 'border-slate-200 hover:border-slate-300'">
                            <div class="flex items-center gap-3">
                                <input type="radio" name="payment_method" value="bkash" x-model="paymentMethod" class="text-starBlue focus:ring-starBlue">
                                <div>
                                    <div class="font-bold text-xs text-slate-900">bKash / Nagad / Rocket / Upay (MFS)</div>
                                    <div class="text-[11px] text-slate-500">Pay instant &amp; secured via Mobile Financial Services</div>
                                </div>
                            </div>
                            <div class="flex items-center gap-1.5">
                                <img src="{{ asset('images/payments/bkash_card.svg') }}" alt="bKash" class="h-6 w-auto object-contain rounded">
                                <img src="{{ asset('images/payments/nagad.svg') }}" alt="Nagad" class="h-6 w-auto object-contain rounded">
                                <img src="{{ asset('images/payments/rocket.svg') }}" alt="Rocket" class="h-6 w-auto object-contain rounded">
                            </div>
                        </label>

                        <label class="p-3.5 rounded border-2 flex items-center justify-between cursor-pointer transition" :class="paymentMethod === 'card' ? 'border-starBlue bg-blue-50/30' : 'border-slate-200 hover:border-slate-300'">
                            <div class="flex items-center gap-3">
                                <input type="radio" name="payment_method" value="card" x-model="paymentMethod" class="text-starBlue focus:ring-starBlue">
                                <div>
                                    <div class="font-bold text-xs text-slate-900">Credit / Debit Card &amp; Net Banking (Visa, Mastercard, Amex, Nexus)</div>
                                    <div class="text-[11px] text-slate-500">256-Bit SSL Secured Payment Gateway</div>
                                </div>
                            </div>
                            <div class="flex items-center gap-1.5">
                                <img src="{{ asset('images/payments/visa_card.svg') }}" alt="Visa" class="h-6 w-auto object-contain rounded">
                                <img src="{{ asset('images/payments/mastercard_card.svg') }}" alt="Mastercard" class="h-6 w-auto object-contain rounded">
                                <img src="{{ asset('images/payments/amex_card.svg') }}" alt="Amex" class="h-6 w-auto object-contain rounded">
                                <img src="{{ asset('images/payments/nexus.svg') }}" alt="Nexus" class="h-6 w-auto object-contain rounded">
                            </div>
                        </label>
                    </div>

                    <div class="pt-4 border-t border-slate-100 flex items-center justify-between">
                        <div class="text-xs text-slate-500">
                            By placing this order, you agree to SM Shop terms and return policy.
                        </div>
                        <button type="submit" class="bg-starOrange hover:bg-starOrangeHover text-white text-xs font-bold uppercase tracking-wider py-3 px-8 rounded transition shadow-md cursor-pointer flex items-center gap-2">
                            <i class="fa-solid fa-lock"></i> Confirm Order
                        </button>
                    </div>
                </div>

            </div>

            <!-- Right: Order Summary Sidebar -->
            <div class="lg:col-span-5 space-y-6">
                <div class="bg-white rounded-lg border border-slate-200 p-5 shadow-xs space-y-4">
                    <h3 class="font-bold text-slate-900 text-sm border-b border-slate-100 pb-2">Order Overview ({{ count($cart) }} Items)</h3>

                    <div class="divide-y divide-slate-100 max-h-80 overflow-y-auto pr-1 space-y-3">
                        @foreach($cart as $item)
                            <div class="pt-3 first:pt-0 flex items-center justify-between gap-3 text-xs">
                                <div class="flex items-center gap-2.5 min-w-0">
                                    <img src="{{ $item['image'] }}" alt="{{ $item['name'] }}" class="w-12 h-12 rounded object-contain bg-white border border-slate-200 p-1 shrink-0">
                                    <div class="min-w-0">
                                        <div class="font-semibold text-slate-800 line-clamp-1">{{ $item['name'] }}</div>
                                        <div class="text-slate-400 text-[11px]">Qty: {{ $item['quantity'] }} &times; {{ number_format($item['price']) }}৳</div>
                                    </div>
                                </div>
                                <span class="font-bold text-slate-900 whitespace-nowrap">{{ number_format($item['price'] * $item['quantity']) }}৳</span>
                            </div>
                        @endforeach
                    </div>

                    <div class="border-t border-slate-200 pt-3 space-y-2 text-xs text-slate-700">
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
                            <span>Delivery:</span>
                            <span class="text-emerald-600 font-semibold">{{ ($shipping ?? 0) == 0 ? 'FREE' : number_format($shipping) . '৳' }}</span>
                        </div>
                        <div class="border-t border-slate-200 pt-3 flex items-center justify-between text-base font-bold text-slate-900">
                            <span>Total Payable:</span>
                            <span class="text-starOrange font-bold">{{ number_format($total ?? 0) }}৳</span>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </form>
</div>
@endsection