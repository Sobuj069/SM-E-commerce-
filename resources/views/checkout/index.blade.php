@extends('layouts.app')

@section('title', 'Checkout - SM E-Commerce')

@section('content')
<div class="bg-white border-b border-slate-200 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900">Checkout</h1>
        <p class="text-xs sm:text-sm text-slate-500 mt-1">Please enter your shipping and payment information</p>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <form action="{{ route('checkout.store') }}" method="POST">
        @csrf

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-10">
            
            <!-- Checkout Form Fields -->
            <div class="lg:col-span-7 space-y-8">
                
                <!-- Contact & Shipping Details -->
                <div class="bg-white rounded-3xl border border-slate-200 p-6 sm:p-8 shadow-xs space-y-6">
                    <h2 class="text-lg font-bold text-slate-900 flex items-center gap-2.5 pb-4 border-b border-slate-100">
                        <span class="w-7 h-7 rounded-full bg-indigo-600 text-white flex items-center justify-center text-xs font-bold">1</span>
                        Customer & Shipping Information
                    </h2>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div class="sm:col-span-2">
                            <label class="block text-xs font-bold text-slate-700 mb-1.5">Full Name *</label>
                            <input 
                                type="text" 
                                name="customer_name" 
                                value="{{ old('customer_name') }}" 
                                placeholder="e.g. John Doe" 
                                class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 @error('customer_name') border-rose-500 @enderror"
                                required
                            >
                            @error('customer_name') <p class="text-xs text-rose-500 mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1.5">Email Address *</label>
                            <input 
                                type="email" 
                                name="customer_email" 
                                value="{{ old('customer_email') }}" 
                                placeholder="john@example.com" 
                                class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 @error('customer_email') border-rose-500 @enderror"
                                required
                            >
                            @error('customer_email') <p class="text-xs text-rose-500 mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1.5">Phone Number *</label>
                            <input 
                                type="text" 
                                name="customer_phone" 
                                value="{{ old('customer_phone') }}" 
                                placeholder="+880 1700-000000" 
                                class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 @error('customer_phone') border-rose-500 @enderror"
                                required
                            >
                            @error('customer_phone') <p class="text-xs text-rose-500 mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div class="sm:col-span-2">
                            <label class="block text-xs font-bold text-slate-700 mb-1.5">Delivery Address *</label>
                            <textarea 
                                name="shipping_address" 
                                rows="3" 
                                placeholder="House / Flat / Road / Area..." 
                                class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 @error('shipping_address') border-rose-500 @enderror"
                                required
                            >{{ old('shipping_address') }}</textarea>
                            @error('shipping_address') <p class="text-xs text-rose-500 mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1.5">City / District *</label>
                            <input 
                                type="text" 
                                name="city" 
                                value="{{ old('city', 'Dhaka') }}" 
                                class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 @error('city') border-rose-500 @enderror"
                                required
                            >
                            @error('city') <p class="text-xs text-rose-500 mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1.5">Postal Code</label>
                            <input 
                                type="text" 
                                name="postal_code" 
                                value="{{ old('postal_code') }}" 
                                placeholder="1200" 
                                class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500"
                            >
                        </div>
                    </div>
                </div>

                <!-- Payment Method Section -->
                <div class="bg-white rounded-3xl border border-slate-200 p-6 sm:p-8 shadow-xs space-y-6">
                    <h2 class="text-lg font-bold text-slate-900 flex items-center gap-2.5 pb-4 border-b border-slate-100">
                        <span class="w-7 h-7 rounded-full bg-indigo-600 text-white flex items-center justify-center text-xs font-bold">2</span>
                        Payment Method
                    </h2>

                    <div class="space-y-3">
                        <label class="flex items-center justify-between p-4 border border-indigo-500 bg-indigo-50/40 rounded-2xl cursor-pointer">
                            <div class="flex items-center gap-3">
                                <input type="radio" name="payment_method" value="cod" checked class="text-indigo-600 focus:ring-indigo-500">
                                <div>
                                    <span class="font-bold text-slate-900 text-sm block">Cash on Delivery (COD)</span>
                                    <span class="text-xs text-slate-500">Pay cash upon receiving products at your doorstep</span>
                                </div>
                            </div>
                            <i class="fa-solid fa-hand-holding-dollar text-indigo-600 text-xl"></i>
                        </label>

                        <label class="flex items-center justify-between p-4 border border-slate-200 hover:border-slate-300 rounded-2xl cursor-pointer">
                            <div class="flex items-center gap-3">
                                <input type="radio" name="payment_method" value="bkash" class="text-indigo-600 focus:ring-indigo-500">
                                <div>
                                    <span class="font-bold text-slate-900 text-sm block">bKash / Mobile Wallet</span>
                                    <span class="text-xs text-slate-500">Fast online checkout via bKash / Nagad</span>
                                </div>
                            </div>
                            <i class="fa-solid fa-mobile-screen-button text-pink-600 text-xl"></i>
                        </label>

                        <label class="flex items-center justify-between p-4 border border-slate-200 hover:border-slate-300 rounded-2xl cursor-pointer">
                            <div class="flex items-center gap-3">
                                <input type="radio" name="payment_method" value="card" class="text-indigo-600 focus:ring-indigo-500">
                                <div>
                                    <span class="font-bold text-slate-900 text-sm block">Credit / Debit Card</span>
                                    <span class="text-xs text-slate-500">Visa, Mastercard, American Express</span>
                                </div>
                            </div>
                            <i class="fa-regular fa-credit-card text-indigo-600 text-xl"></i>
                        </label>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">Order Notes (Optional)</label>
                        <textarea 
                            name="notes" 
                            rows="2" 
                            placeholder="Special instructions for delivery (e.g. deliver in the evening)" 
                            class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500"
                        >{{ old('notes') }}</textarea>
                    </div>
                </div>

            </div>

            <!-- Sticky Order Summary Panel -->
            <div class="lg:col-span-5 space-y-6">
                <div class="bg-white rounded-3xl border border-slate-200 p-6 sm:p-8 shadow-xs space-y-6 sticky top-24">
                    <h3 class="font-extrabold text-slate-900 text-lg border-b border-slate-100 pb-3">Your Order</h3>

                    <!-- Order Items Breakdown -->
                    <div class="space-y-4 max-h-72 overflow-y-auto pr-2 divide-y divide-slate-100">
                        @foreach($cart as $item)
                            <div class="flex items-center justify-between gap-3 pt-3 first:pt-0">
                                <div class="flex items-center gap-3">
                                    <img src="{{ $item['image'] }}" alt="{{ $item['name'] }}" class="w-12 h-12 rounded-lg object-cover border border-slate-200">
                                    <div>
                                        <h4 class="text-xs font-bold text-slate-900 line-clamp-1">{{ $item['name'] }}</h4>
                                        <span class="text-xs text-slate-500">Qty: {{ $item['quantity'] }} &times; ${{ number_format($item['price'], 2) }}</span>
                                    </div>
                                </div>
                                <span class="text-xs font-bold text-slate-900 whitespace-nowrap">
                                    ${{ number_format($item['price'] * $item['quantity'], 2) }}
                                </span>
                            </div>
                        @endforeach
                    </div>

                    <!-- Totals -->
                    <div class="space-y-3 text-sm pt-4 border-t border-slate-100">
                        <div class="flex items-center justify-between text-slate-600">
                            <span>Subtotal</span>
                            <span class="font-bold text-slate-800">${{ number_format($subtotal, 2) }}</span>
                        </div>
                        <div class="flex items-center justify-between text-slate-600">
                            <span>Shipping</span>
                            @if($shipping == 0)
                                <span class="font-bold text-emerald-600">FREE</span>
                            @else
                                <span class="font-bold text-slate-800">${{ number_format($shipping, 2) }}</span>
                            @endif
                        </div>
                    </div>

                    <div class="pt-4 border-t border-slate-100 flex items-center justify-between">
                        <span class="font-bold text-slate-900 text-base">Total Amount</span>
                        <span class="text-2xl font-black text-indigo-600">${{ number_format($total, 2) }}</span>
                    </div>

                    <button type="submit" class="w-full py-4 px-6 bg-emerald-600 hover:bg-emerald-700 text-white font-bold rounded-xl transition flex items-center justify-center gap-2 shadow-lg shadow-emerald-200 text-base active:scale-98">
                        <i class="fa-solid fa-lock text-sm"></i> Place Order Now
                    </button>

                    <p class="text-[11px] text-center text-slate-400">
                        By placing your order, you agree to our Terms of Service & Privacy Policy.
                    </p>
                </div>
            </div>

        </div>
    </form>
</div>
@endsection
