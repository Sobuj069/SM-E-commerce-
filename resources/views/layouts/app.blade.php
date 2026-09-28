<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'SM Shop - Leading Computer, Laptop & Gadget Shop in Bangladesh')</title>
    <meta name="description" content="SM Shop - Leading Computer, Laptop, Desktop PC, Component, Gaming PC, Monitor, Camera, TV & Gadget Shop in Bangladesh.">
    <meta name="keywords" content="SM Shop, Computer Shop BD, Laptop Price in BD, Gaming PC, Desktop PC, Gadget Shop Bangladesh">

    <!-- Tailwind CSS with Star Tech Custom Theme -->
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet"/>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        starNavy: '#081621',
                        starNavyDark: '#040d14',
                        starBlue: '#3749bb',
                        starBlueDark: '#082b49',
                        starOrange: '#ef4a23',
                        starOrangeHover: '#d43b16',
                        starYellow: '#fd7e14',
                        starBg: '#f2f4f8'
                    }
                }
            }
        }
    </script>

    <style data-purpose="custom-styling">
        [x-cloak] { display: none !important; }
        body {
            background-color: #f2f4f8;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
        }
        .custom-scroll::-webkit-scrollbar {
            display: none;
        }
        .custom-scroll {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
    </style>

    <!-- Global App State -->
    <script>
        function storefrontApp() {
            return {
                drawerOpen: false,
                mobileMenuOpen: false,
                searchOpen: false,
                cartCount: {{ array_sum(array_column(session()->get('cart', []), 'quantity')) }},
                
                // Live Chatbot State
                chatOpen: false,
                chatMessages: [
                    { sender: 'bot', text: '👋 আসসালামু আলাইকুম! SM Shop অনলাইন শপে স্বাগতম। আপনি অর্ডার ট্র্যাক করতে, ল্যাপটপ বা পিসি কম্পোনেন্ট দেখতে বা প্রোমো কোড জানতে পারেন।' }
                ],
                chatInput: '',
                isTyping: false,

                toggleChat() {
                    this.chatOpen = !this.chatOpen;
                    if (this.chatOpen) {
                        this.$nextTick(() => {
                            const el = document.getElementById('chat-messages-container');
                            if (el) el.scrollTop = el.scrollHeight;
                        });
                    }
                },

                sendQuickPrompt(prompt) {
                    this.chatInput = prompt;
                    this.handleChatSubmit();
                },

                async handleChatSubmit() {
                    const text = this.chatInput.trim();
                    if (!text) return;

                    this.chatMessages.push({ sender: 'user', text: text });
                    this.chatInput = '';
                    this.isTyping = true;
                    
                    this.$nextTick(() => {
                        const el = document.getElementById('chat-messages-container');
                        if (el) el.scrollTop = el.scrollHeight;
                    });

                    const lower = text.toLowerCase();

                    // Order tracking logic
                    if (lower.includes('track') || lower.includes('sm-') || lower.includes('st-') || lower.includes('order')) {
                        const match = text.match(/(SM|ST)-\d+/i);
                        if (match) {
                            const orderNum = match[0].toUpperCase();
                            try {
                                const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
                                const res = await fetch('/api/track-order', {
                                    method: 'POST',
                                    headers: {
                                        'Content-Type': 'application/json',
                                        'X-CSRF-TOKEN': token || ''
                                    },
                                    body: JSON.stringify({ order_number: orderNum })
                                });
                                const result = await res.json();
                                this.isTyping = false;
                                if (result.found) {
                                    this.chatMessages.push({
                                        sender: 'bot',
                                        text: `📦 <strong>Order Found:</strong> ${result.order_number}<br>
                                               <strong>Status:</strong> <span class="text-emerald-600 font-bold">${result.status}</span><br>
                                               <strong>Courier:</strong> ${result.courier}<br>
                                               <strong>Consignment ID:</strong> ${result.consignment}<br>
                                               <strong>Total Amount:</strong> ${result.amount}<br>
                                               <strong>Date:</strong> ${result.date}`
                                    });
                                } else {
                                    this.chatMessages.push({
                                        sender: 'bot',
                                        text: `⚠️ Order <strong>${orderNum}</strong> পাওয়া যায়নি। দয়া করে আপনার কনফার্মেশন রসিদ চেক করুন।`
                                    });
                                }
                            } catch (e) {
                                this.isTyping = false;
                                this.chatMessages.push({
                                    sender: 'bot',
                                    text: `আপনার অর্ডার <strong>${orderNum}</strong> কনফার্ম করা হয়েছে এবং কুরিয়ার ডিসপ্যাচের জন্য প্রসেস হচ্ছে!`
                                });
                            }
                        } else {
                            setTimeout(() => {
                                this.isTyping = false;
                                this.chatMessages.push({
                                    sender: 'bot',
                                    text: 'দয়া করে আপনার অর্ডার নাম্বার লিখুন (যেমন: <strong>SM-1001</strong>), যাতে আমি লাইভ স্ট্যাটাস চেক করতে পারি।'
                                });
                            }, 400);
                        }
                    } else if (lower.includes('pc builder') || lower.includes('builder') || lower.includes('build')) {
                        setTimeout(() => {
                            this.isTyping = false;
                            this.chatMessages.push({
                                sender: 'bot',
                                text: '🖥️ আপনার পছন্দের ডেস্কটপ পিসি তৈরি করতে আমাদের <a href="/shop?category=desktop" class="text-starOrange font-bold underline">PC Builder & Component</a> সেকশন ভিজিট করুন!'
                            });
                        }, 400);
                    } else if (lower.includes('laptop') || lower.includes('ryzen') || lower.includes('core i5')) {
                        setTimeout(() => {
                            this.isTyping = false;
                            this.chatMessages.push({
                                sender: 'bot',
                                text: '💻 আমাদের কাছে রয়েছে Lenovo, MSI, Asus, Apple MacBook এবং HP এর লেটেস্ট ল্যাপটপ কালেকশন! <a href="/shop?category=laptop" class="text-starOrange font-bold underline">সব ল্যাপটপ দেখুন &rarr;</a>'
                            });
                        }, 400);
                    } else if (lower.includes('promo') || lower.includes('coupon') || lower.includes('offer')) {
                        setTimeout(() => {
                            this.isTyping = false;
                            this.chatMessages.push({
                                sender: 'bot',
                                text: '🎉 স্পেশাল ডিসকাউন্টের জন্য চেকআউট পেজে <strong class="text-starOrange font-black">STAR1000</strong> কুপন কোড ব্যবহার করুন!'
                            });
                        }, 400);
                    } else {
                        setTimeout(() => {
                            this.isTyping = false;
                            this.chatMessages.push({
                                sender: 'bot',
                                text: 'ধন্যবাদ! আপনি আমাদের <a href="/shop" class="text-starOrange font-bold underline">Shop Catalog</a> থেকে যেকোনো প্রোডাক্ট দেখতে পারেন অথবা সরাসরি হটলাইনে (16793) কল করতে পারেন।'
                            });
                        }, 400);
                    }

                    this.$nextTick(() => {
                        const el = document.getElementById('chat-messages-container');
                        if (el) el.scrollTop = el.scrollHeight;
                    });
                }
            };
        }
        window.storefrontApp = storefrontApp;
    </script>
</head>
<body 
    x-data="storefrontApp()"
    class="text-slate-800 antialiased selection:bg-starOrange selection:text-white bg-[#f2f4f8] min-h-screen flex flex-col"
>

    <!-- =========================================================================
         1. TOP BAR & STAR TECH OFFICIAL HEADER
         ========================================================================= -->
    <header class="bg-starNavy sticky top-0 z-50 shadow-md">
        <div class="max-w-[1320px] mx-auto px-4 py-3 flex items-center justify-between gap-4 lg:gap-6">
            
            <!-- Mobile Menu Trigger -->
            <button 
                type="button" 
                @click="mobileMenuOpen = true"
                class="lg:hidden text-white hover:text-starOrange p-1.5 focus:outline-none"
                aria-label="Open navigation menu"
            >
                <i class="fa-solid fa-bars text-xl"></i>
            </button>

            <!-- User Brand Logo (SM Shop) -->
            <a class="shrink-0 flex items-center" href="{{ route('home') }}" aria-label="SM Shop">
                <img 
                    alt="SM Shop Logo" 
                    class="h-10 sm:h-12 md:h-14 w-auto max-w-[240px] object-contain hover:scale-105 transition-transform" 
                    src="{{ asset('images/logo.png') }}"
                />
            </a>

            <!-- Central Search Box -->
            <div class="flex-1 max-w-2xl relative hidden sm:block">
                <form action="{{ route('shop.index') }}" method="GET" class="relative flex items-center">
                    <input 
                        name="q"
                        value="{{ request('q') }}"
                        class="w-full h-11 pl-4 pr-12 rounded-md bg-white text-gray-800 text-sm focus:outline-none focus:ring-2 focus:ring-starBlue border-none placeholder-gray-400 font-normal shadow-inner" 
                        placeholder="Search" 
                        type="text"
                    />
                    <button 
                        type="submit"
                        aria-label="Search Submit" 
                        class="absolute right-0 top-0 h-11 w-11 flex items-center justify-center text-slate-500 hover:text-starBlue transition-colors cursor-pointer"
                    >
                        <i class="fa-solid fa-magnifying-glass text-lg"></i>
                    </button>
                </form>
            </div>

            <!-- Quick Action Utilities -->
            <div class="flex items-center space-x-4 sm:space-x-6 text-white text-xs">
                
                <!-- Offers -->
                <a class="hidden md:flex items-center gap-2 group" href="{{ route('shop.index') }}">
                    <div class="text-starOrange text-xl transition-transform group-hover:scale-110">
                        <i class="fa-solid fa-gift"></i>
                    </div>
                    <div class="leading-tight text-left">
                        <p class="font-semibold text-white">Offers</p>
                        <p class="text-[11px] text-gray-400">Latest Offers</p>
                    </div>
                </a>

                <!-- Happy Hour -->
                <a class="hidden lg:flex items-center gap-2 group" href="{{ route('shop.index') }}">
                    <div class="text-starOrange text-xl transition-transform group-hover:scale-110">
                        <i class="fa-solid fa-bolt-lightning"></i>
                    </div>
                    <div class="leading-tight text-left">
                        <p class="font-semibold text-white">Happy Hour</p>
                        <p class="text-[11px] text-gray-400">Special Deals</p>
                    </div>
                </a>

                <!-- Account / Admin Link -->
                <a class="flex items-center gap-2 group" href="{{ route('admin.dashboard') }}">
                    <div class="text-starOrange text-xl transition-transform group-hover:scale-110">
                        <i class="fa-solid fa-user"></i>
                    </div>
                    <div class="leading-tight text-left hidden sm:block">
                        <p class="font-semibold text-white">Account</p>
                        <p class="text-[11px] text-gray-400">Register or Login</p>
                    </div>
                </a>

                <!-- PC Builder Button -->
                <a class="bg-[#082b49] hover:bg-starBlue text-white font-semibold px-3 sm:px-4 py-2 sm:py-2.5 rounded transition duration-200 shadow-sm flex items-center gap-2 border border-blue-900/50 text-xs whitespace-nowrap" href="{{ route('shop.index', ['category' => 'desktop']) }}">
                    <span>PC Builder</span>
                </a>

                <!-- Mobile Cart Bag Icon Trigger -->
                <button 
                    type="button" 
                    @click="drawerOpen = true" 
                    class="lg:hidden text-starOrange hover:text-white relative p-1 cursor-pointer"
                    aria-label="Shopping Cart"
                >
                    <i class="fa-solid fa-basket-shopping text-xl"></i>
                    @php
                        $cart = session()->get('cart', []);
                        $cartCount = array_sum(array_column($cart, 'quantity'));
                    @endphp
                    @if($cartCount > 0)
                        <span class="absolute -top-1.5 -right-1.5 bg-starOrange text-white text-[10px] w-4 h-4 rounded-full flex items-center justify-center font-bold">
                            {{ $cartCount }}
                        </span>
                    @endif
                </button>

            </div>
        </div>

        <!-- Mobile Search Bar (Only on small screens) -->
        <div class="sm:hidden px-4 pb-3">
            <form action="{{ route('shop.index') }}" method="GET" class="relative flex items-center">
                <input 
                    name="q"
                    value="{{ request('q') }}"
                    class="w-full h-10 pl-3 pr-10 rounded-md bg-white text-gray-800 text-xs focus:outline-none focus:ring-2 focus:ring-starBlue border-none placeholder-gray-400" 
                    placeholder="Search Products..." 
                    type="text"
                />
                <button type="submit" class="absolute right-0 top-0 h-10 w-10 flex items-center justify-center text-slate-500 hover:text-starBlue">
                    <i class="fa-solid fa-magnifying-glass text-sm"></i>
                </button>
            </form>
        </div>

        <!-- =====================================================================
             PRIMARY CATEGORY HORIZONTAL BAR (EXACT STAR TECH CATEGORY LIST)
             ===================================================================== -->
        <nav class="bg-white border-b border-gray-200 shadow-sm">
            <div class="max-w-[1320px] mx-auto px-4">
                <ul class="flex items-center justify-between overflow-x-auto text-[13px] font-semibold text-slate-800 whitespace-nowrap custom-scroll py-2.5 gap-4">
                    <li class="hover:text-starOrange transition-colors"><a href="{{ route('shop.index', ['category' => 'desktop']) }}">Desktop</a></li>
                    <li class="hover:text-starOrange transition-colors"><a href="{{ route('shop.index', ['category' => 'laptop']) }}">Laptop</a></li>
                    <li class="hover:text-starOrange transition-colors"><a href="{{ route('shop.index', ['category' => 'component']) }}">Component</a></li>
                    <li class="hover:text-starOrange transition-colors"><a href="{{ route('shop.index', ['category' => 'monitor']) }}">Monitor</a></li>
                    <li class="hover:text-starOrange transition-colors"><a href="{{ route('shop.index', ['category' => 'power']) }}">Power</a></li>
                    <li class="hover:text-starOrange transition-colors"><a href="{{ route('shop.index', ['category' => 'phone']) }}">Phone</a></li>
                    <li class="hover:text-starOrange transition-colors"><a href="{{ route('shop.index', ['category' => 'tablet']) }}">Tablet</a></li>
                    <li class="hover:text-starOrange transition-colors"><a href="{{ route('shop.index', ['category' => 'office-equipment']) }}">Office Equipment</a></li>
                    <li class="hover:text-starOrange transition-colors"><a href="{{ route('shop.index', ['category' => 'camera']) }}">Camera</a></li>
                    <li class="hover:text-starOrange transition-colors"><a href="{{ route('shop.index', ['category' => 'security']) }}">Security</a></li>
                    <li class="hover:text-starOrange transition-colors"><a href="{{ route('shop.index', ['category' => 'networking']) }}">Networking</a></li>
                    <li class="hover:text-starOrange transition-colors"><a href="{{ route('shop.index', ['category' => 'software']) }}">Software</a></li>
                    <li class="hover:text-starOrange transition-colors"><a href="{{ route('shop.index', ['category' => 'server-storage']) }}">Server &amp; Storage</a></li>
                    <li class="hover:text-starOrange transition-colors"><a href="{{ route('shop.index', ['category' => 'accessories']) }}">Accessories</a></li>
                    <li class="hover:text-starOrange transition-colors"><a href="{{ route('shop.index', ['category' => 'gadget']) }}">Gadget</a></li>
                    <li class="hover:text-starOrange transition-colors"><a href="{{ route('shop.index', ['category' => 'gaming']) }}">Gaming</a></li>
                    <li class="hover:text-starOrange transition-colors"><a href="{{ route('shop.index', ['category' => 'tv']) }}">TV</a></li>
                    <li class="hover:text-starOrange transition-colors"><a href="{{ route('shop.index', ['category' => 'appliance']) }}">Appliance</a></li>
                </ul>
            </div>
        </nav>
    </header>

    <!-- =========================================================================
         MOBILE CATEGORY DRAWER
         ========================================================================= -->
    <div 
        x-show="mobileMenuOpen" 
        x-cloak
        class="fixed inset-0 z-50 overflow-hidden lg:hidden"
    >
        <div 
            x-show="mobileMenuOpen"
            x-transition:enter="ease-in-out duration-300"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="ease-in-out duration-300"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="fixed inset-0 bg-black/60 backdrop-blur-xs" 
            @click="mobileMenuOpen = false"
        ></div>

        <div class="fixed inset-y-0 left-0 max-w-full flex pr-10">
            <div 
                x-show="mobileMenuOpen"
                x-transition:enter="transform transition ease-in-out duration-300"
                x-transition:enter-start="-translate-x-full"
                x-transition:enter-end="translate-x-0"
                x-transition:leave="transform transition ease-in-out duration-300"
                x-transition:leave-start="translate-x-0"
                x-transition:leave-end="-translate-x-full"
                class="w-screen max-w-xs bg-white shadow-2xl flex flex-col justify-between"
            >
                <div class="p-4 bg-starNavy flex items-center justify-between">
                    <img 
                        src="{{ asset('images/logo.png') }}" 
                        alt="SM Shop" 
                        class="h-10 w-auto max-w-[160px] object-contain"
                    >
                    <button @click="mobileMenuOpen = false" class="text-white hover:text-starOrange text-xl cursor-pointer">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                </div>

                <div class="p-4 flex-1 overflow-y-auto space-y-2 text-sm font-semibold text-slate-800">
                    <a href="{{ route('shop.index', ['category' => 'desktop']) }}" class="block py-2 px-3 hover:bg-slate-100 rounded text-slate-800 hover:text-starOrange">Desktop</a>
                    <a href="{{ route('shop.index', ['category' => 'laptop']) }}" class="block py-2 px-3 hover:bg-slate-100 rounded text-slate-800 hover:text-starOrange">Laptop</a>
                    <a href="{{ route('shop.index', ['category' => 'component']) }}" class="block py-2 px-3 hover:bg-slate-100 rounded text-slate-800 hover:text-starOrange">Component</a>
                    <a href="{{ route('shop.index', ['category' => 'monitor']) }}" class="block py-2 px-3 hover:bg-slate-100 rounded text-slate-800 hover:text-starOrange">Monitor</a>
                    <a href="{{ route('shop.index', ['category' => 'power']) }}" class="block py-2 px-3 hover:bg-slate-100 rounded text-slate-800 hover:text-starOrange">Power</a>
                    <a href="{{ route('shop.index', ['category' => 'phone']) }}" class="block py-2 px-3 hover:bg-slate-100 rounded text-slate-800 hover:text-starOrange">Phone</a>
                    <a href="{{ route('shop.index', ['category' => 'tablet']) }}" class="block py-2 px-3 hover:bg-slate-100 rounded text-slate-800 hover:text-starOrange">Tablet</a>
                    <a href="{{ route('shop.index', ['category' => 'office-equipment']) }}" class="block py-2 px-3 hover:bg-slate-100 rounded text-slate-800 hover:text-starOrange">Office Equipment</a>
                    <a href="{{ route('shop.index', ['category' => 'camera']) }}" class="block py-2 px-3 hover:bg-slate-100 rounded text-slate-800 hover:text-starOrange">Camera</a>
                    <a href="{{ route('shop.index', ['category' => 'security']) }}" class="block py-2 px-3 hover:bg-slate-100 rounded text-slate-800 hover:text-starOrange">Security</a>
                    <a href="{{ route('shop.index', ['category' => 'networking']) }}" class="block py-2 px-3 hover:bg-slate-100 rounded text-slate-800 hover:text-starOrange">Networking</a>
                    <a href="{{ route('shop.index', ['category' => 'software']) }}" class="block py-2 px-3 hover:bg-slate-100 rounded text-slate-800 hover:text-starOrange">Software</a>
                    <a href="{{ route('shop.index', ['category' => 'server-storage']) }}" class="block py-2 px-3 hover:bg-slate-100 rounded text-slate-800 hover:text-starOrange">Server &amp; Storage</a>
                    <a href="{{ route('shop.index', ['category' => 'accessories']) }}" class="block py-2 px-3 hover:bg-slate-100 rounded text-slate-800 hover:text-starOrange">Accessories</a>
                    <a href="{{ route('shop.index', ['category' => 'gadget']) }}" class="block py-2 px-3 hover:bg-slate-100 rounded text-slate-800 hover:text-starOrange">Gadget</a>
                    <a href="{{ route('shop.index', ['category' => 'gaming']) }}" class="block py-2 px-3 hover:bg-slate-100 rounded text-slate-800 hover:text-starOrange">Gaming</a>
                    <a href="{{ route('shop.index', ['category' => 'tv']) }}" class="block py-2 px-3 hover:bg-slate-100 rounded text-slate-800 hover:text-starOrange">TV</a>
                    <a href="{{ route('shop.index', ['category' => 'appliance']) }}" class="block py-2 px-3 hover:bg-slate-100 rounded text-slate-800 hover:text-starOrange">Appliance</a>
                </div>

                <div class="p-4 border-t border-slate-200 bg-slate-50 space-y-2 text-xs">
                    <a href="{{ route('admin.dashboard') }}" class="block text-center py-2.5 bg-starNavy text-white font-bold rounded">
                        Admin / Account Panel
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- =========================================================================
         MAIN CONTENT BODY
         ========================================================================= -->
    <main class="flex-1">
        @yield('content')
    </main>

    <!-- =========================================================================
         STAR TECH OFFICIAL FOOTER
         ========================================================================= -->
    <footer class="bg-starNavy text-white mt-12 pt-12 pb-6 border-t border-slate-800" data-purpose="site-footer">
        <div class="max-w-[1320px] mx-auto px-4 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 mb-10">
            
            <!-- Column 1: Support Hotline & Store Locator -->
            <div class="space-y-4">
                <h4 class="text-xs font-bold text-gray-400 uppercase tracking-widest">Support</h4>
                
                <!-- Phone support card -->
                <a class="flex items-center gap-3 p-3.5 rounded-lg border border-slate-700/80 hover:border-starOrange transition-colors group" href="tel:16793">
                    <div class="w-10 h-10 rounded-full bg-slate-800 flex items-center justify-center text-starOrange group-hover:bg-starOrange group-hover:text-white transition">
                        <i class="fa-solid fa-phone"></i>
                    </div>
                    <div>
                        <p class="text-[11px] text-gray-400">9 AM - 8 PM</p>
                        <p class="text-lg font-bold text-starOrange tracking-wide">16793</p>
                    </div>
                </a>
                
                <!-- Store Locator Card -->
                <a class="flex items-center gap-3 p-3.5 rounded-lg border border-slate-700/80 hover:border-starOrange transition-colors group" href="{{ route('shop.index') }}">
                    <div class="w-10 h-10 rounded-full bg-slate-800 flex items-center justify-center text-starOrange group-hover:bg-starOrange group-hover:text-white transition">
                        <i class="fa-solid fa-location-dot"></i>
                    </div>
                    <div>
                        <p class="text-[11px] text-gray-400">Store Locator</p>
                        <p class="text-sm font-bold text-white group-hover:text-starOrange transition-colors">Find Our 20+ Stores</p>
                    </div>
                </a>
            </div>

            <!-- Column 2: About Us Links -->
            <div class="space-y-3">
                <h4 class="text-xs font-bold text-gray-400 uppercase tracking-widest">About Us</h4>
                <div class="grid grid-cols-2 gap-y-2 text-xs text-gray-300">
                    <a class="hover:text-starOrange transition-colors" href="{{ route('shop.index') }}">Affiliate Program</a>
                    <a class="hover:text-starOrange transition-colors" href="{{ route('shop.index') }}">EMI Terms</a>
                    <a class="hover:text-starOrange transition-colors" href="{{ route('shop.index') }}">Online Delivery</a>
                    <a class="hover:text-starOrange transition-colors" href="{{ route('shop.index') }}">Privacy Policy</a>
                    <a class="hover:text-starOrange transition-colors" href="{{ route('shop.index') }}">Refund Policy</a>
                    <a class="hover:text-starOrange transition-colors" href="{{ route('shop.index') }}">Star Point Policy</a>
                    <a class="hover:text-starOrange transition-colors" href="{{ route('shop.index') }}">Blog</a>
                    <a class="hover:text-starOrange transition-colors" href="{{ route('shop.index') }}">Contact Us</a>
                    <a class="hover:text-starOrange transition-colors" href="{{ route('shop.index') }}">About Us</a>
                    <a class="hover:text-starOrange transition-colors" href="{{ route('shop.index') }}">Terms &amp; Conditions</a>
                    <a class="hover:text-starOrange transition-colors" href="{{ route('shop.index') }}">Career</a>
                    <a class="hover:text-starOrange transition-colors" href="{{ route('shop.index') }}">Brands</a>
                </div>
            </div>

            <!-- Column 3: Corporate Address -->
            <div class="space-y-3">
                <h4 class="text-xs font-bold text-gray-400 uppercase tracking-widest">Stay Connected</h4>
                <div class="space-y-2 text-xs text-gray-300">
                    <p class="font-bold text-white">SM Shop Ltd</p>
                    <p class="leading-relaxed text-gray-400">
                        Head Office: Navana Zohura Square, 28 Kazi Nazrul Islam Ave, Dhaka, Bangladesh
                    </p>
                    <p class="pt-2">
                        <span class="text-gray-400">Email:</span><br/>
                        <a class="text-starOrange hover:underline font-medium" href="mailto:support@smcloudit.top">support@smcloudit.top</a>
                    </p>
                </div>
            </div>

            <!-- Column 4: App Download & Social -->
            <div class="space-y-4">
                <h4 class="text-xs font-bold text-gray-400 uppercase tracking-widest">Experience SM Shop App</h4>
                <div class="flex flex-col sm:flex-row lg:flex-col gap-2">
                    <a class="flex items-center gap-3 bg-slate-900 border border-slate-700 rounded-md px-3 py-2 hover:border-slate-500 transition" href="#">
                        <i class="fa-brands fa-google-play text-xl text-emerald-400"></i>
                        <div class="text-left leading-tight">
                            <p class="text-[9px] text-gray-400 uppercase">Download on</p>
                            <p class="text-xs font-bold text-white">Google Play</p>
                        </div>
                    </a>
                    <a class="flex items-center gap-3 bg-slate-900 border border-slate-700 rounded-md px-3 py-2 hover:border-slate-500 transition" href="#">
                        <i class="fa-brands fa-apple text-2xl text-white"></i>
                        <div class="text-left leading-tight">
                            <p class="text-[9px] text-gray-400 uppercase">Download on</p>
                            <p class="text-xs font-bold text-white">App Store</p>
                        </div>
                    </a>
                </div>

                <!-- Social Icons -->
                <div class="pt-2">
                    <div class="flex items-center gap-3 text-lg text-gray-400">
                        <a aria-label="WhatsApp" class="w-8 h-8 rounded-full bg-slate-800 flex items-center justify-center hover:text-emerald-400 hover:bg-slate-700 transition" href="#"><i class="fa-brands fa-whatsapp"></i></a>
                        <a aria-label="Facebook" class="w-8 h-8 rounded-full bg-slate-800 flex items-center justify-center hover:text-blue-500 hover:bg-slate-700 transition" href="#"><i class="fa-brands fa-facebook-f"></i></a>
                        <a aria-label="YouTube" class="w-8 h-8 rounded-full bg-slate-800 flex items-center justify-center hover:text-red-500 hover:bg-slate-700 transition" href="#"><i class="fa-brands fa-youtube"></i></a>
                        <a aria-label="Instagram" class="w-8 h-8 rounded-full bg-slate-800 flex items-center justify-center hover:text-pink-500 hover:bg-slate-700 transition" href="#"><i class="fa-brands fa-instagram"></i></a>
                    </div>
                </div>
            </div>

        </div>

        <!-- Sub Footer Copyright & Branding -->
        <div class="border-t border-slate-800/80 pt-6">
            <div class="max-w-[1320px] mx-auto px-4 flex flex-col sm:flex-row items-center justify-between text-[11px] text-gray-500 gap-3">
                <p>© {{ date('Y') }} SM Shop Ltd | All rights reserved</p>
                <p>Powered By: <span class="text-gray-300 font-semibold">SM Cloud IT</span></p>
            </div>
        </div>
    </footer>

    <!-- =========================================================================
         STICKY FLOATING WIDGETS (COMPARE & CART BAG)
         ========================================================================= -->
    <aside class="fixed right-3 bottom-8 flex flex-col gap-2 z-40" data-purpose="floating-actions">
        <!-- Compare Widget -->
        <a class="w-12 h-12 bg-starNavy text-white rounded-full flex flex-col items-center justify-center shadow-xl border border-slate-700 hover:scale-105 transition-transform relative group" href="{{ route('shop.index') }}">
            <i class="fa-solid fa-code-compare text-xs text-starOrange"></i>
            <span class="text-[9px] uppercase font-bold mt-0.5">Compare</span>
            <span class="absolute -top-1 -right-1 bg-starOrange text-white text-[10px] w-4 h-4 rounded-full flex items-center justify-center font-bold">0</span>
        </a>

        <!-- Cart Bag Widget Trigger -->
        <button 
            type="button"
            @click="drawerOpen = true"
            class="w-12 h-14 bg-starNavy text-white rounded-full flex flex-col items-center justify-center shadow-xl border border-slate-700 hover:scale-105 transition-transform relative group cursor-pointer"
        >
            <i class="fa-solid fa-basket-shopping text-sm text-starOrange"></i>
            <span class="text-[9px] uppercase font-bold mt-0.5">Cart</span>
            <span class="absolute -top-1 -right-1 bg-starOrange text-white text-[10px] w-4 h-4 rounded-full flex items-center justify-center font-bold">
                {{ $cartCount }}
            </span>
        </button>
    </aside>

    <!-- =========================================================================
         LIVE CART SLIDE-OVER DRAWER (CHECKOUT & BAG SUMMARY)
         ========================================================================= -->
    <div 
        x-show="drawerOpen" 
        x-cloak 
        class="fixed inset-0 z-50 overflow-hidden" 
        style="display: none;"
    >
        <div 
            x-show="drawerOpen"
            x-transition:enter="ease-in-out duration-300"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="ease-in-out duration-300"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="fixed inset-0 bg-black/60 backdrop-blur-xs" 
            @click="drawerOpen = false"
        ></div>

        <div class="fixed inset-y-0 right-0 max-w-full flex pl-10">
            <div 
                x-show="drawerOpen"
                x-transition:enter="transform transition ease-in-out duration-300"
                x-transition:enter-start="translate-x-full"
                x-transition:enter-end="translate-x-0"
                x-transition:leave="transform transition ease-in-out duration-300"
                x-transition:leave-start="translate-x-0"
                x-transition:leave-end="translate-x-full"
                class="w-screen max-w-md bg-white shadow-2xl flex flex-col justify-between"
            >
                <div class="p-4 bg-starNavy text-white flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <i class="fa-solid fa-basket-shopping text-starOrange text-lg"></i>
                        <h3 class="font-bold text-sm uppercase tracking-wide">Your Shopping Cart</h3>
                    </div>
                    <button @click="drawerOpen = false" class="text-gray-400 hover:text-white text-lg cursor-pointer">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                </div>

                <div class="p-4 flex-1 overflow-y-auto divide-y divide-gray-100">
                    @php
                        $cartItems = session()->get('cart', []);
                        $total = 0;
                    @endphp
                    @forelse($cartItems as $id => $item)
                        @php $total += $item['price'] * $item['quantity']; @endphp
                        <div class="py-4 flex gap-3 items-center">
                            <img src="{{ $item['image'] }}" alt="{{ $item['name'] }}" class="w-16 h-16 object-contain rounded bg-slate-50 p-1 shrink-0 border border-slate-200">
                            <div class="flex-1 min-w-0">
                                <h4 class="text-xs font-semibold text-slate-800 truncate">{{ $item['name'] }}</h4>
                                <p class="text-xs text-starOrange font-bold mt-0.5">{{ number_format($item['price']) }}৳ &times; {{ $item['quantity'] }}</p>
                            </div>
                            <form action="{{ route('cart.remove', $id) }}" method="POST">
                                @csrf
                                <button type="submit" class="text-slate-400 hover:text-red-500 text-xs p-1 cursor-pointer">
                                    <i class="fa-solid fa-trash-can"></i>
                                </button>
                            </form>
                        </div>
                    @empty
                        <div class="py-16 text-center space-y-3">
                            <i class="fa-solid fa-basket-shopping text-4xl text-slate-300"></i>
                            <p class="text-xs text-slate-500 font-semibold">Your shopping cart is currently empty.</p>
                            <a href="{{ route('shop.index') }}" @click="drawerOpen = false" class="inline-block px-5 py-2 bg-starOrange hover:bg-starOrangeHover text-white text-xs font-bold rounded">
                                Start Shopping
                            </a>
                        </div>
                    @endforelse
                </div>

                @if(!empty($cartItems))
                    <div class="p-4 bg-slate-50 border-t border-slate-200 space-y-3">
                        <div class="flex justify-between items-center text-sm font-bold">
                            <span class="text-slate-600">Subtotal:</span>
                            <span class="text-starOrange text-base">{{ number_format($total) }}৳</span>
                        </div>
                        <div class="grid grid-cols-2 gap-2">
                            <a href="{{ route('cart.index') }}" class="py-2.5 text-center bg-slate-200 hover:bg-slate-300 text-slate-800 text-xs font-bold rounded transition">
                                View Cart
                            </a>
                            <a href="{{ route('checkout.index') }}" class="py-2.5 text-center bg-starOrange hover:bg-starOrangeHover text-white text-xs font-bold rounded transition shadow">
                                Checkout
                            </a>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

</body>
</html>