@extends('layouts.app')

@section('title', 'Secure Checkout - SM Shop 3D')

@section('content')
<div class="bg-surface border-b border-line-subtle py-8 transition-colors duration-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-2xl sm:text-3xl font-black text-content-primary">Express Multi-Step Checkout</h1>
        <p class="text-xs sm:text-sm text-content-muted mt-1">Encrypted 256-Bit SSL connection • Guest checkout enabled</p>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10" x-data="{ step: 1, paymentMethod: 'cod' }">
    
    <!-- Multi-Step Progress Header -->
    <div class="max-w-3xl mx-auto mb-10">
        <div class="flex items-center justify-between relative">
            <div class="absolute left-0 top-1/2 -translate-y-1/2 h-1 bg-line-subtle w-full -z-0"></div>
            <div class="absolute left-0 top-1/2 -translate-y-1/2 h-1 bg-brand-primary -z-0 transition-all duration-500" :style="'width: ' + ((step - 1) * 50) + '%'"></div>

            <!-- Step 1 Indicator -->
            <button type="button" x-on:click="step = 1" class="relative z-10 flex flex-col items-center gap-2 cursor-pointer">
                <div class="w-10 h-10 rounded-full flex items-center justify-center text-xs font-black transition-all" :class="step >= 1 ? 'bg-brand-primary text-white shadow-lg shadow-indigo-500/25 ring-4 ring-brand-primary/20' : 'bg-surface-elevated text-content-muted border border-line-subtle'">
                    1
                </div>
                <span class="text-xs font-bold" :class="step >= 1 ? 'text-content-primary' : 'text-content-muted'">Shipping</span>
            </button>

            <!-- Step 2 Indicator -->
            <button type="button" x-on:click="step = 2" class="relative z-10 flex flex-col items-center gap-2 cursor-pointer">
                <div class="w-10 h-10 rounded-full flex items-center justify-center text-xs font-black transition-all" :class="step >= 2 ? 'bg-brand-primary text-white shadow-lg shadow-indigo-500/25 ring-4 ring-brand-primary/20' : 'bg-surface-elevated text-content-muted border border-line-subtle'">
                    2
                </div>
                <span class="text-xs font-bold" :class="step >= 2 ? 'text-content-primary' : 'text-content-muted'">Payment</span>
            </button>

            <!-- Step 3 Indicator -->
            <button type="button" x-on:click="step = 3" class="relative z-10 flex flex-col items-center gap-2 cursor-pointer">
                <div class="w-10 h-10 rounded-full flex items-center justify-center text-xs font-black transition-all" :class="step >= 3 ? 'bg-brand-primary text-white shadow-lg shadow-indigo-500/25 ring-4 ring-brand-primary/20' : 'bg-surface-elevated text-content-muted border border-line-subtle'">
                    3
                </div>
                <span class="text-xs font-bold" :class="step >= 3 ? 'text-content-primary' : 'text-content-muted'">Review</span>
            </button>
        </div>
    </div>

    <form action="{{ route('checkout.store') }}" method="POST" id="checkout-form">
        @csrf

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-10">
            
            <!-- Left: Multi-Step Interactive Form -->
            <div class="lg:col-span-7 space-y-8">
                
                <!-- STEP 1: Shipping Details -->
                <div x-show="step === 1" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0" class="bg-surface rounded-3xl border border-line-subtle p-6 sm:p-8 shadow-xs space-y-6 transition-colors duration-200">
                    <h2 class="text-base font-black text-content-primary flex items-center gap-2.5 pb-4 border-b border-line-subtle">
                        <span class="w-7 h-7 rounded-full bg-brand-primary text-white flex items-center justify-center text-xs font-black">1</span>
                        Customer & Shipping Information (Guest Checkout)
                    </h2>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div class="sm:col-span-2">
                            <label class="block text-xs font-bold text-content-primary mb-1.5">Full Name *</label>
                            <input 
                                type="text" 
                                name="customer_name" 
                                id="cust_name"
                                value="{{ old('customer_name', 'Alex Johnson') }}" 
                                placeholder="e.g. John Doe" 
                                class="w-full px-4 py-3 bg-surface-elevated border border-line-subtle rounded-2xl text-xs font-bold text-content-primary focus:outline-none focus:ring-2 focus:ring-brand-primary"
                                required
                            >
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-content-primary mb-1.5">Email Address *</label>
                            <input 
                                type="email" 
                                name="customer_email" 
                                id="cust_email"
                                value="{{ old('customer_email', 'alex&#64;example.com') }}" 
                                placeholder="john&#64;example.com" 
                                class="w-full px-4 py-3 bg-surface-elevated border border-line-subtle rounded-2xl text-xs font-bold text-content-primary focus:outline-none focus:ring-2 focus:ring-brand-primary"
                                required
                            >
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-content-primary mb-1.5">Phone Number *</label>
                            <input 
                                type="text" 
                                name="customer_phone" 
                                id="cust_phone"
                                value="{{ old('customer_phone', '+880 1700-000000') }}" 
                                placeholder="+880 1700-000000" 
                                class="w-full px-4 py-3 bg-surface-elevated border border-line-subtle rounded-2xl text-xs font-bold text-content-primary focus:outline-none focus:ring-2 focus:ring-brand-primary"
                                required
                            >
                        </div>

                        <div class="sm:col-span-2">
                            <label class="block text-xs font-bold text-content-primary mb-1.5">Delivery Address *</label>
                            <textarea 
                                name="shipping_address" 
                                id="cust_addr"
                                rows="3" 
                                placeholder="House / Flat / Road / Area..." 
                                class="w-full px-4 py-3 bg-surface-elevated border border-line-subtle rounded-2xl text-xs font-bold text-content-primary focus:outline-none focus:ring-2 focus:ring-brand-primary"
                                required
                            >{{ old('shipping_address', 'House 42, Road 11, Banani, Dhaka') }}</textarea>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-content-primary mb-1.5">City / District *</label>
                            <input 
                                type="text" 
                                name="city" 
                                id="cust_city"
                                value="{{ old('city', 'Dhaka') }}" 
                                class="w-full px-4 py-3 bg-surface-elevated border border-line-subtle rounded-2xl text-xs font-bold text-content-primary focus:outline-none focus:ring-2 focus:ring-brand-primary"
                                required
                            >
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-content-primary mb-1.5">Postal Code</label>
                            <input 
                                type="text" 
                                name="postal_code" 
                                value="{{ old('postal_code', '1213') }}" 
                                placeholder="1213" 
                                class="w-full px-4 py-3 bg-surface-elevated border border-line-subtle rounded-2xl text-xs font-bold text-content-primary focus:outline-none focus:ring-2 focus:ring-brand-primary"
                            >
                        </div>
                    </div>

                    <div class="pt-4 flex justify-end">
                        <x-button variant="primary" size="md" type="button" x-on:click="step = 2" icon="fa-solid fa-arrow-right" iconPosition="right">
                            Proceed to Payment
                        </x-button>
                    </div>
                </div>

                <!-- STEP 2: Payment Method -->
                <div x-show="step === 2" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0" class="bg-surface rounded-3xl border border-line-subtle p-6 sm:p-8 shadow-xs space-y-6 transition-colors duration-200" style="display: none;">
                    <h2 class="text-base font-black text-content-primary flex items-center gap-2.5 pb-4 border-b border-line-subtle">
                        <span class="w-7 h-7 rounded-full bg-brand-primary text-white flex items-center justify-center text-xs font-black">2</span>
                        Select Payment Method
                    </h2>

                    <div class="space-y-3">
                        <label class="flex items-center justify-between p-4 rounded-2xl border transition cursor-pointer" :class="paymentMethod === 'cod' ? 'border-brand-primary bg-brand-primary/10 ring-2 ring-brand-primary/20' : 'border-line-subtle bg-surface-elevated hover:border-brand-primary'">
                            <div class="flex items-center gap-3">
                                <input type="radio" name="payment_method" value="cod" x-model="paymentMethod" class="text-brand-primary focus:ring-0">
                                <div>
                                    <div class="text-xs font-black text-content-primary">Cash on Delivery (COD)</div>
                                    <div class="text-[11px] text-content-muted">Pay with cash upon package receipt</div>
                                </div>
                            </div>
                            <i class="fa-solid fa-money-bill-wave text-status-success text-base"></i>
                        </label>

                        <label class="flex items-center justify-between p-4 rounded-2xl border transition cursor-pointer" :class="paymentMethod === 'card' ? 'border-brand-primary bg-brand-primary/10 ring-2 ring-brand-primary/20' : 'border-line-subtle bg-surface-elevated hover:border-brand-primary'">
                            <div class="flex items-center gap-3">
                                <input type="radio" name="payment_method" value="card" x-model="paymentMethod" class="text-brand-primary focus:ring-0">
                                <div>
                                    <div class="text-xs font-black text-content-primary">Credit / Debit Card</div>
                                    <div class="text-[11px] text-content-muted">Visa, Mastercard, American Express</div>
                                </div>
                            </div>
                            <div class="flex gap-1.5 text-content-muted text-sm">
                                <i class="fa-brands fa-cc-visa text-blue-500"></i>
                                <i class="fa-brands fa-cc-mastercard text-amber-500"></i>
                            </div>
                        </label>

                        <label class="flex items-center justify-between p-4 rounded-2xl border transition cursor-pointer" :class="paymentMethod === 'bkash' ? 'border-brand-primary bg-brand-primary/10 ring-2 ring-brand-primary/20' : 'border-line-subtle bg-surface-elevated hover:border-brand-primary'">
                            <div class="flex items-center gap-3">
                                <input type="radio" name="payment_method" value="bkash" x-model="paymentMethod" class="text-brand-primary focus:ring-0">
                                <div>
                                    <div class="text-xs font-black text-content-primary">bKash Mobile Payment</div>
                                    <div class="text-[11px] text-content-muted">Instant mobile wallet checkout</div>
                                </div>
                            </div>
                            <span class="text-xs font-black text-pink-500">bKash</span>
                        </label>

                        <label class="flex items-center justify-between p-4 rounded-2xl border transition cursor-pointer" :class="paymentMethod === 'nagad' ? 'border-brand-primary bg-brand-primary/10 ring-2 ring-brand-primary/20' : 'border-line-subtle bg-surface-elevated hover:border-brand-primary'">
                            <div class="flex items-center gap-3">
                                <input type="radio" name="payment_method" value="nagad" x-model="paymentMethod" class="text-brand-primary focus:ring-0">
                                <div>
                                    <div class="text-xs font-black text-content-primary">Nagad Mobile Wallet</div>
                                    <div class="text-[11px] text-content-muted">Post Office Digital Service</div>
                                </div>
                            </div>
                            <span class="text-xs font-black text-orange-500">Nagad</span>
                        </label>
                    </div>

                    <div class="pt-4 flex justify-between">
                        <x-button variant="outline" size="sm" type="button" x-on:click="step = 1">
                            Back
                        </x-button>
                        <x-button variant="primary" size="md" type="button" x-on:click="step = 3" icon="fa-solid fa-arrow-right" iconPosition="right">
                            Review Order
                        </x-button>
                    </div>
                </div>

                <!-- STEP 3: Review & Finalize -->
                <div x-show="step === 3" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0" class="bg-surface rounded-3xl border border-line-subtle p-6 sm:p-8 shadow-xs space-y-6 transition-colors duration-200" style="display: none;">
                    <h2 class="text-base font-black text-content-primary flex items-center gap-2.5 pb-4 border-b border-line-subtle">
                        <span class="w-7 h-7 rounded-full bg-brand-primary text-white flex items-center justify-center text-xs font-black">3</span>
                        Review & Complete Purchase
                    </h2>

                    <div>
                        <label class="block text-xs font-bold text-content-primary mb-1.5">Order Notes & Instructions (Optional)</label>
                        <textarea 
                            name="notes" 
                            rows="2" 
                            placeholder="Special delivery notes or gate codes..." 
                            class="w-full px-4 py-3 bg-surface-elevated border border-line-subtle rounded-2xl text-xs font-bold text-content-primary focus:outline-none focus:ring-2 focus:ring-brand-primary"
                        >{{ old('notes') }}</textarea>
                    </div>

                    <div class="p-4 rounded-2xl bg-surface-elevated border border-line-subtle text-xs space-y-2">
                        <div class="flex items-center gap-2 text-status-success font-bold">
                            <i class="fa-solid fa-shield-check text-sm"></i>
                            <span>All items covered under SM Shop 100% Satisfaction Guarantee</span>
                        </div>
                        <p class="text-[11px] text-content-muted">
                            By placing this order, you agree to our terms of service and express delivery dispatch policy.
                        </p>
                    </div>

                    <div class="pt-4 flex justify-between">
                        <x-button variant="outline" size="sm" type="button" x-on:click="step = 2">
                            Back
                        </x-button>
                        <x-button variant="primary" size="lg" type="submit" icon="fa-solid fa-shield-check">
                            Place Order (${{ number_format($total, 2) }})
                        </x-button>
                    </div>
                </div>

            </div>

            <!-- Right: Real-time Order Summary Sidebar -->
            <div class="lg:col-span-5 space-y-6">
                <div class="bg-surface rounded-3xl border border-line-subtle p-6 shadow-xs space-y-5 transition-colors duration-200">
                    <h3 class="font-black text-content-primary text-base border-b border-line-subtle pb-3">Order Summary</h3>

                    <!-- Mini items list -->
                    <div class="divide-y divide-line-subtle max-h-72 overflow-y-auto pr-1">
                        @foreach($cart as $item)
                            <div class="py-3 flex items-center gap-3">
                                <img src="{{ $item['image'] }}" alt="{{ $item['name'] }}" class="w-12 h-12 rounded-xl object-cover border border-line-subtle shrink-0">
                                <div class="flex-1 min-w-0">
                                    <h4 class="text-xs font-bold text-content-primary truncate">{{ $item['name'] }}</h4>
                                    <div class="text-[11px] text-content-muted">Qty: {{ $item['quantity'] }} × ${{ number_format($item['price'], 2) }}</div>
                                </div>
                                <span class="text-xs font-black text-content-primary">${{ number_format($item['price'] * $item['quantity'], 2) }}</span>
                            </div>
                        @endforeach
                    </div>

                    <div class="border-t border-line-subtle pt-3 space-y-2.5 text-xs">
                        <div class="flex justify-between text-content-secondary">
                            <span>Subtotal:</span>
                            <span class="font-bold text-content-primary">${{ number_format($subtotal, 2) }}</span>
                        </div>

                        @if($discount > 0)
                            <div class="flex justify-between text-emerald-400 font-bold">
                                <span>Coupon ({{ $couponData['code'] ?? '' }}):</span>
                                <span>-${{ number_format($discount, 2) }}</span>
                            </div>
                        @endif

                        <div class="flex justify-between text-content-secondary">
                            <span>Shipping:</span>
                            @if($shipping == 0)
                                <span class="font-bold text-status-success">FREE EXPRESS</span>
                            @else
                                <span class="font-bold text-content-primary">${{ number_format($shipping, 2) }}</span>
                            @endif
                        </div>

                        <div class="border-t border-line-subtle pt-3 flex justify-between text-base font-black text-content-primary">
                            <span>Grand Total:</span>
                            <span class="text-xl text-brand-primary">${{ number_format($total, 2) }}</span>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </form>
</div>
@endsection