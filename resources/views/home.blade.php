@extends('layouts.app')

@section('title', 'Star Tech - Leading Computer, Laptop & Gadget Shop in Bangladesh')

@section('content')
<div class="max-w-[1320px] mx-auto px-4 py-4 space-y-6">

    <!-- =========================================================================
         1. NOTICE BAR
         ========================================================================= -->
    <div class="bg-white rounded-full py-2.5 px-6 shadow-sm border border-slate-100 flex items-center justify-center text-xs md:text-sm text-slate-700 text-center font-normal">
        <span class="inline-block truncate">
            Branches are open including Elephant Road branch. Additionally, our online activities are open and operational. Please check our contact page for schedule.
        </span>
    </div>

    <!-- =========================================================================
         2. HERO PROMO BANNERS (3 + 1 GRID)
         ========================================================================= -->
    <section class="grid grid-cols-1 lg:grid-cols-4 gap-4" data-purpose="hero-promotions">
        <!-- Main Promotional Slider / Banner Area -->
        <a href="{{ route('shop.index', ['category' => 'laptop']) }}" class="lg:col-span-3 rounded-lg overflow-hidden shadow-sm relative bg-gradient-to-r from-purple-950 via-slate-900 to-red-950 text-white min-h-[300px] flex items-center justify-between p-6 sm:p-8 border border-slate-800 group block">
            <div class="z-10 max-w-md space-y-3">
                <span class="inline-block bg-red-600 text-white text-xs uppercase px-2.5 py-1 rounded font-bold tracking-wide">Special Campaign</span>
                <h2 class="text-2xl sm:text-3xl md:text-4xl font-black leading-tight tracking-tight text-white">
                    লেনোভো -এর <span class="text-red-500 font-extrabold">AMD প্রসেসর যুক্ত</span><br/>
                    নির্দিষ্ট ল্যাপটপ কিনলেই পেয়ে যাচ্ছেন
                </h2>
                <div class="bg-white/10 backdrop-blur-md rounded-md p-3 border border-white/20 inline-block">
                    <p class="text-base sm:text-lg font-bold text-amber-300">স্মার্টওয়াচ অথবা এয়ারবাডস ফ্রি!</p>
                </div>
                <p class="text-xs text-gray-300">*শর্ত প্রযোজ্য</p>
            </div>
            
            <!-- Promo Graphic Highlights -->
            <div class="hidden sm:flex flex-col items-center justify-center pr-4 lg:pr-6 gap-3 z-10">
                <div class="w-28 sm:w-32 h-28 sm:h-32 rounded-full border-4 border-red-500/30 p-2 bg-black/40 flex items-center justify-center group-hover:scale-105 transition-transform">
                    <i class="fa-solid fa-laptop-code text-4xl sm:text-5xl text-red-500"></i>
                </div>
                <span class="text-xs font-semibold bg-red-600 px-3 py-1 rounded-full shadow">ধামাকা অফার</span>
            </div>
            
            <!-- Background subtle glow -->
            <div class="absolute -right-20 -bottom-20 w-80 h-80 bg-red-600/20 rounded-full blur-3xl pointer-events-none"></div>
        </a>

        <!-- Right Column Dual Teasers -->
        <div class="flex flex-col gap-4">
            <!-- Feedback Teaser -->
            <div class="bg-gradient-to-br from-[#0c2e4e] to-[#081a2d] text-white p-5 rounded-lg flex flex-col justify-between h-full border border-sky-900/50 shadow-sm relative overflow-hidden group">
                <div>
                    <p class="text-xs text-cyan-400 font-medium">গ্রাহক মতামত ও পরামর্শ</p>
                    <h3 class="text-xl font-bold mt-1 text-white">অভিযোগ বা মতামত</h3>
                </div>
                <div class="mt-4">
                    <a class="inline-flex items-center gap-2 bg-amber-500 hover:bg-amber-600 text-slate-900 text-xs font-bold px-4 py-2 rounded-full transition shadow" href="{{ route('shop.index') }}">
                        <span>জানান এখানে</span>
                        <i class="fa-solid fa-arrow-right text-[10px]"></i>
                    </a>
                </div>
                <i class="fa-solid fa-comments absolute -right-3 -bottom-3 text-7xl text-white/5 group-hover:scale-105 transition-transform"></i>
            </div>

            <!-- Career Teaser -->
            <div class="bg-gradient-to-br from-[#bf2e1b] to-[#7f1d1d] text-white p-5 rounded-lg flex flex-col justify-between h-full border border-red-800/50 shadow-sm relative overflow-hidden group">
                <div class="z-10">
                    <span class="text-[10px] bg-white/20 text-white font-bold px-2 py-0.5 rounded uppercase">Apply Now</span>
                    <h3 class="text-2xl font-black mt-2 leading-tight">Shape<br/>Your Career<br/><span class="text-amber-300">With Us!</span></h3>
                </div>
                <i class="fa-solid fa-briefcase absolute -right-3 -bottom-3 text-7xl text-white/10 group-hover:scale-105 transition-transform"></i>
            </div>
        </div>
    </section>

    <!-- =========================================================================
         3. QUICK FEATURE TOOLS (4 CARDS)
         ========================================================================= -->
    <section class="grid grid-cols-2 md:grid-cols-4 gap-3.5" data-purpose="quick-tools">
        <!-- Laptop Finder -->
        <a class="bg-white p-3.5 rounded-lg shadow-sm hover:shadow transition-shadow flex items-center gap-3.5 border border-slate-100 group" href="{{ route('shop.index', ['category' => 'laptop']) }}">
            <div class="w-11 h-11 rounded-full bg-red-100 text-starOrange flex items-center justify-center text-lg shrink-0 group-hover:bg-starOrange group-hover:text-white transition-colors">
                <i class="fa-solid fa-laptop"></i>
            </div>
            <div>
                <h4 class="font-bold text-xs md:text-sm text-slate-800">Laptop Finder</h4>
                <p class="text-[11px] text-gray-500">Find Your Laptop Easily</p>
            </div>
        </a>

        <!-- Raise a Complain -->
        <a class="bg-white p-3.5 rounded-lg shadow-sm hover:shadow transition-shadow flex items-center gap-3.5 border border-slate-100 group" href="{{ route('shop.index') }}">
            <div class="w-11 h-11 rounded-full bg-red-100 text-starOrange flex items-center justify-center text-lg shrink-0 group-hover:bg-starOrange group-hover:text-white transition-colors">
                <i class="fa-regular fa-comment-dots"></i>
            </div>
            <div>
                <h4 class="font-bold text-xs md:text-sm text-slate-800">Raise a Complain</h4>
                <p class="text-[11px] text-gray-500">Share your experience</p>
            </div>
        </a>

        <!-- AC Ton Calculator -->
        <a class="bg-white p-3.5 rounded-lg shadow-sm hover:shadow transition-shadow flex items-center gap-3.5 border border-slate-100 group" href="{{ route('shop.index', ['category' => 'appliance']) }}">
            <div class="w-11 h-11 rounded-full bg-red-100 text-starOrange flex items-center justify-center text-lg shrink-0 group-hover:bg-starOrange group-hover:text-white transition-colors">
                <i class="fa-solid fa-snowflake"></i>
            </div>
            <div>
                <h4 class="font-bold text-xs md:text-sm text-slate-800">AC Ton Calculator</h4>
                <p class="text-[11px] text-gray-500">Find Perfect AC</p>
            </div>
        </a>

        <!-- Servicing Center -->
        <a class="bg-white p-3.5 rounded-lg shadow-sm hover:shadow transition-shadow flex items-center gap-3.5 border border-slate-100 group" href="{{ route('shop.index') }}">
            <div class="w-11 h-11 rounded-full bg-red-100 text-starOrange flex items-center justify-center text-lg shrink-0 group-hover:bg-starOrange group-hover:text-white transition-colors">
                <i class="fa-solid fa-screwdriver-wrench"></i>
            </div>
            <div>
                <h4 class="font-bold text-xs md:text-sm text-slate-800">Servicing Center</h4>
                <p class="text-[11px] text-gray-500">Repair Your Device</p>
            </div>
        </a>
    </section>

    <!-- =========================================================================
         4. FEATURED CATEGORY SECTION (16 ICON TILES)
         ========================================================================= -->
    <section class="space-y-4" data-purpose="featured-categories">
        <div class="text-center space-y-1">
            <h2 class="text-xl md:text-2xl font-bold text-slate-900 tracking-tight">Featured Category</h2>
            <p class="text-xs md:text-sm text-gray-500">Get Your Desired Product from Featured Category!</p>
        </div>

        <div class="grid grid-cols-4 sm:grid-cols-6 md:grid-cols-8 gap-3">
            <!-- 1. AC -->
            <a class="bg-white p-3 rounded-lg shadow-sm hover:shadow border border-slate-100 flex flex-col items-center justify-center text-center group transition" href="{{ route('shop.index', ['category' => 'appliance', 'q' => 'ac']) }}">
                <div class="w-10 h-10 flex items-center justify-center text-slate-600 group-hover:text-starOrange mb-1.5 text-2xl">
                    <i class="fa-solid fa-wind"></i>
                </div>
                <span class="text-[11px] font-semibold text-slate-700 group-hover:text-starOrange line-clamp-1">AC</span>
            </a>

            <!-- 2. Portable Power Station -->
            <a class="bg-white p-3 rounded-lg shadow-sm hover:shadow border border-slate-100 flex flex-col items-center justify-center text-center group transition" href="{{ route('shop.index', ['category' => 'power']) }}">
                <div class="w-10 h-10 flex items-center justify-center text-slate-600 group-hover:text-starOrange mb-1.5 text-2xl">
                    <i class="fa-solid fa-car-battery"></i>
                </div>
                <span class="text-[11px] font-semibold text-slate-700 group-hover:text-starOrange leading-tight">Power Station</span>
            </a>

            <!-- 3. Air Fryer -->
            <a class="bg-white p-3 rounded-lg shadow-sm hover:shadow border border-slate-100 flex flex-col items-center justify-center text-center group transition" href="{{ route('shop.index', ['category' => 'appliance', 'q' => 'air fryer']) }}">
                <div class="w-10 h-10 flex items-center justify-center text-slate-600 group-hover:text-starOrange mb-1.5 text-2xl">
                    <i class="fa-solid fa-fire-burner"></i>
                </div>
                <span class="text-[11px] font-semibold text-slate-700 group-hover:text-starOrange line-clamp-1">Air Fryer</span>
            </a>

            <!-- 4. Drone -->
            <a class="bg-white p-3 rounded-lg shadow-sm hover:shadow border border-slate-100 flex flex-col items-center justify-center text-center group transition" href="{{ route('shop.index', ['category' => 'camera', 'q' => 'drone']) }}">
                <div class="w-10 h-10 flex items-center justify-center text-slate-600 group-hover:text-starOrange mb-1.5 text-2xl">
                    <i class="fa-solid fa-helicopter"></i>
                </div>
                <span class="text-[11px] font-semibold text-slate-700 group-hover:text-starOrange line-clamp-1">Drone</span>
            </a>

            <!-- 5. Gimbal -->
            <a class="bg-white p-3 rounded-lg shadow-sm hover:shadow border border-slate-100 flex flex-col items-center justify-center text-center group transition" href="{{ route('shop.index', ['category' => 'camera', 'q' => 'gimbal']) }}">
                <div class="w-10 h-10 flex items-center justify-center text-slate-600 group-hover:text-starOrange mb-1.5 text-2xl">
                    <i class="fa-solid fa-video"></i>
                </div>
                <span class="text-[11px] font-semibold text-slate-700 group-hover:text-starOrange line-clamp-1">Gimbal</span>
            </a>

            <!-- 6. Table PC -->
            <a class="bg-white p-3 rounded-lg shadow-sm hover:shadow border border-slate-100 flex flex-col items-center justify-center text-center group transition" href="{{ route('shop.index', ['category' => 'tablet']) }}">
                <div class="w-10 h-10 flex items-center justify-center text-slate-600 group-hover:text-starOrange mb-1.5 text-2xl">
                    <i class="fa-solid fa-tablet-screen-button"></i>
                </div>
                <span class="text-[11px] font-semibold text-slate-700 group-hover:text-starOrange line-clamp-1">Tablet PC</span>
            </a>

            <!-- 7. TV -->
            <a class="bg-white p-3 rounded-lg shadow-sm hover:shadow border border-slate-100 flex flex-col items-center justify-center text-center group transition" href="{{ route('shop.index', ['category' => 'tv']) }}">
                <div class="w-10 h-10 flex items-center justify-center text-slate-600 group-hover:text-starOrange mb-1.5 text-2xl">
                    <i class="fa-solid fa-tv"></i>
                </div>
                <span class="text-[11px] font-semibold text-slate-700 group-hover:text-starOrange line-clamp-1">TV</span>
            </a>

            <!-- 8. Fridge -->
            <a class="bg-white p-3 rounded-lg shadow-sm hover:shadow border border-slate-100 flex flex-col items-center justify-center text-center group transition" href="{{ route('shop.index', ['category' => 'appliance', 'q' => 'fridge']) }}">
                <div class="w-10 h-10 flex items-center justify-center text-slate-600 group-hover:text-starOrange mb-1.5 text-2xl">
                    <i class="fa-solid fa-box-tissue"></i>
                </div>
                <span class="text-[11px] font-semibold text-slate-700 group-hover:text-starOrange line-clamp-1">Fridge</span>
            </a>

            <!-- 9. Mobile Phone -->
            <a class="bg-white p-3 rounded-lg shadow-sm hover:shadow border border-slate-100 flex flex-col items-center justify-center text-center group transition" href="{{ route('shop.index', ['category' => 'phone']) }}">
                <div class="w-10 h-10 flex items-center justify-center text-slate-600 group-hover:text-starOrange mb-1.5 text-2xl">
                    <i class="fa-solid fa-mobile-screen-button"></i>
                </div>
                <span class="text-[11px] font-semibold text-slate-700 group-hover:text-starOrange line-clamp-1">Mobile Phone</span>
            </a>

            <!-- 10. Mobile Accessories -->
            <a class="bg-white p-3 rounded-lg shadow-sm hover:shadow border border-slate-100 flex flex-col items-center justify-center text-center group transition" href="{{ route('shop.index', ['category' => 'accessories']) }}">
                <div class="w-10 h-10 flex items-center justify-center text-slate-600 group-hover:text-starOrange mb-1.5 text-2xl">
                    <i class="fa-solid fa-plug"></i>
                </div>
                <span class="text-[11px] font-semibold text-slate-700 group-hover:text-starOrange leading-tight">Mobile Accessories</span>
            </a>

            <!-- 11. Health Monitor -->
            <a class="bg-white p-3 rounded-lg shadow-sm hover:shadow border border-slate-100 flex flex-col items-center justify-center text-center group transition" href="{{ route('shop.index', ['category' => 'gadget', 'q' => 'health']) }}">
                <div class="w-10 h-10 flex items-center justify-center text-slate-600 group-hover:text-starOrange mb-1.5 text-2xl">
                    <i class="fa-solid fa-heart-pulse"></i>
                </div>
                <span class="text-[11px] font-semibold text-slate-700 group-hover:text-starOrange line-clamp-1">Health Monitor</span>
            </a>

            <!-- 12. WiFi Camera -->
            <a class="bg-white p-3 rounded-lg shadow-sm hover:shadow border border-slate-100 flex flex-col items-center justify-center text-center group transition" href="{{ route('shop.index', ['category' => 'security']) }}">
                <div class="w-10 h-10 flex items-center justify-center text-slate-600 group-hover:text-starOrange mb-1.5 text-2xl">
                    <i class="fa-solid fa-camera-rotate"></i>
                </div>
                <span class="text-[11px] font-semibold text-slate-700 group-hover:text-starOrange line-clamp-1">WiFi Camera</span>
            </a>

            <!-- 13. Trimmer -->
            <a class="bg-white p-3 rounded-lg shadow-sm hover:shadow border border-slate-100 flex flex-col items-center justify-center text-center group transition" href="{{ route('shop.index', ['category' => 'gadget', 'q' => 'trimmer']) }}">
                <div class="w-10 h-10 flex items-center justify-center text-slate-600 group-hover:text-starOrange mb-1.5 text-2xl">
                    <i class="fa-solid fa-wand-magic-sparkles"></i>
                </div>
                <span class="text-[11px] font-semibold text-slate-700 group-hover:text-starOrange line-clamp-1">Trimmer</span>
            </a>

            <!-- 14. Smart Watch -->
            <a class="bg-white p-3 rounded-lg shadow-sm hover:shadow border border-slate-100 flex flex-col items-center justify-center text-center group transition" href="{{ route('shop.index', ['category' => 'gadget', 'q' => 'watch']) }}">
                <div class="w-10 h-10 flex items-center justify-center text-slate-600 group-hover:text-starOrange mb-1.5 text-2xl">
                    <i class="fa-solid fa-stopwatch"></i>
                </div>
                <span class="text-[11px] font-semibold text-slate-700 group-hover:text-starOrange line-clamp-1">Smart Watch</span>
            </a>

            <!-- 15. Earbuds -->
            <a class="bg-white p-3 rounded-lg shadow-sm hover:shadow border border-slate-100 flex flex-col items-center justify-center text-center group transition" href="{{ route('shop.index', ['category' => 'gadget', 'q' => 'earbuds']) }}">
                <div class="w-10 h-10 flex items-center justify-center text-slate-600 group-hover:text-starOrange mb-1.5 text-2xl">
                    <i class="fa-solid fa-headphones-simple"></i>
                </div>
                <span class="text-[11px] font-semibold text-slate-700 group-hover:text-starOrange line-clamp-1">Earbuds</span>
            </a>

            <!-- 16. Torch Light -->
            <a class="bg-white p-3 rounded-lg shadow-sm hover:shadow border border-slate-100 flex flex-col items-center justify-center text-center group transition" href="{{ route('shop.index', ['category' => 'gadget', 'q' => 'torch']) }}">
                <div class="w-10 h-10 flex items-center justify-center text-slate-600 group-hover:text-starOrange mb-1.5 text-2xl">
                    <i class="fa-solid fa-flashlight"></i>
                </div>
                <span class="text-[11px] font-semibold text-slate-700 group-hover:text-starOrange line-clamp-1">Torch Light</span>
            </a>
        </div>
    </section>

    <!-- =========================================================================
         5. PHYSICAL STORES BANNER
         ========================================================================= -->
    <section class="bg-gradient-to-r from-[#0088cc] via-[#0297df] to-[#04689b] rounded-lg p-5 md:p-6 text-white shadow-sm flex flex-col sm:flex-row items-center justify-between gap-4">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 rounded-full bg-white/20 flex items-center justify-center text-2xl shrink-0">
                <i class="fa-solid fa-location-dot"></i>
            </div>
            <div>
                <h3 class="text-xl md:text-2xl font-bold leading-tight">20+ Physical Stores</h3>
                <p class="text-xs md:text-sm text-sky-100">Visit Our Store &amp; Get Your Desired IT Product!</p>
            </div>
        </div>
        <a class="bg-[#f59e0b] hover:bg-[#d97706] text-slate-900 font-bold px-6 py-2.5 rounded-full text-xs md:text-sm transition flex items-center gap-2 shrink-0 shadow" href="{{ route('shop.index') }}">
            <span>Find Our Store</span>
            <i class="fa-solid fa-magnifying-glass text-xs"></i>
        </a>
    </section>

    <!-- =========================================================================
         6. FEATURED PRODUCTS (20 OFFICIAL STAR TECH PRODUCTS GRID)
         ========================================================================= -->
    <section class="space-y-4" data-purpose="featured-products">
        <div class="text-center space-y-1">
            <h2 class="text-xl md:text-2xl font-bold text-slate-900 tracking-tight">Featured Products</h2>
            <p class="text-xs md:text-sm text-gray-500">Check &amp; Get Your Desired Product!</p>
        </div>

        <!-- 20 Product Grid (5 columns on desktop) -->
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-3">
            @foreach($featuredProducts as $product)
                <div class="bg-white rounded-md border border-slate-200 overflow-hidden flex flex-col justify-between hover:shadow-lg transition-shadow relative p-3 group">
                    
                    <!-- Dynamic Badge / Tag -->
                    @if($product->has_discount)
                        @php
                            $savingAmount = $product->price - $product->sale_price;
                        @endphp
                        <span class="absolute top-2 left-2 bg-[#6e42c1] text-white text-[10px] font-semibold px-2 py-0.5 rounded-xs z-10">
                            Save: {{ number_format($savingAmount) }}৳ (-{{ $product->discount_percent }}%)
                        </span>
                    @elseif($product->price > 80000)
                        <span class="absolute top-2 left-2 bg-[#082b49] text-white text-[10px] font-semibold px-2 py-0.5 rounded-xs z-10">
                            Earn Point: 450
                        </span>
                    @endif

                    <!-- Product Image Container -->
                    <a href="{{ route('product.show', $product->slug) }}" class="py-4 flex justify-center items-center h-44 block">
                        <img 
                            alt="{{ $product->name }}" 
                            class="max-h-36 max-w-full object-contain group-hover:scale-105 transition-transform duration-300" 
                            src="{{ $product->image }}"
                        />
                    </a>

                    <!-- Product Title & Price -->
                    <div class="border-t border-slate-100 pt-3 space-y-2">
                        <h3 class="text-xs font-semibold text-slate-800 group-hover:text-starOrange line-clamp-2 leading-relaxed">
                            <a href="{{ route('product.show', $product->slug) }}">
                                {{ $product->name }}
                            </a>
                        </h3>

                        <div class="flex items-center gap-2">
                            @if($product->has_discount)
                                <span class="text-starOrange font-bold text-sm">{{ number_format($product->sale_price) }}৳</span>
                                <span class="text-gray-400 line-through text-xs">{{ number_format($product->price) }}৳</span>
                            @else
                                <span class="text-starOrange font-bold text-sm">{{ number_format($product->price) }}৳</span>
                            @endif
                        </div>

                        <!-- Quick Add to Cart Action -->
                        <form action="{{ route('cart.add', $product->id) }}" method="POST" class="pt-1">
                            @csrf
                            <button type="submit" class="w-full py-1.5 bg-[#f2f4f8] hover:bg-starOrange hover:text-white text-slate-700 text-[11px] font-bold rounded transition flex items-center justify-center gap-1.5 cursor-pointer">
                                <i class="fa-solid fa-cart-plus text-[10px]"></i>
                                <span>Buy Now</span>
                            </button>
                        </form>
                    </div>

                </div>
            @endforeach
        </div>
    </section>

    <!-- =========================================================================
         7. BRAND NARRATIVE AND SEO ARTICLE
         ========================================================================= -->
    <article class="bg-white rounded-lg p-6 md:p-8 space-y-6 text-slate-600 text-xs md:text-[13px] leading-relaxed border border-slate-200/80 shadow-sm" data-purpose="seo-content">
        <div class="space-y-2">
            <h2 class="text-lg md:text-xl font-bold text-slate-900">Leading Computer, Laptop &amp; Gaming PC Retail &amp; Online Shop in Bangladesh</h2>
            <p>
                Technology has become a part of our daily lives, and we depend on tech products daily for a vast portion of our lives. There is hardly a home in Bangladesh without a tech product. This is where we come in. <a class="text-starOrange hover:underline font-semibold" href="#">Star Tech Ltd.</a> started as a Tech Product Shop in March 2007. We focus on giving the best customer service in Bangladesh, following our motto of <strong>"Customer Comes First."</strong> This is why Star Tech is the most <strong>trusted computer shop in Bangladesh</strong> today, capturing the loyalty of a large customer base. After a long 16-year journey, in 2022, Star Tech Ltd. was certified with the renowned "ISO 9001:2015 certification" as a recognition for the best Quality Control Management System. As an <strong>ISO-certified organization</strong>, Star Tech Ltd. is now up to the international standards that specify a Quality Management System (QMS). This Certification denotes that the organization strictly maintains all sorts of regulatory requirements to provide customers with products and services of a global standard.
            </p>
        </div>

        <div class="space-y-2">
            <h3 class="text-base font-bold text-slate-900">Best Laptop Shop In Bangladesh</h3>
            <p>
                Star Tech is the most popular <a class="text-starOrange hover:underline font-semibold" href="#">Laptop Brand Shop in BD</a>. Star Tech <a class="text-starOrange hover:underline" href="#">Laptop</a> Shop has the perfect device, whether you are a freelancer, officegoer, or student. Gamers love our collection of <a class="text-starOrange hover:underline" href="#">Gaming Laptops</a> because we always bring the latest laptops in Bangladesh. As the best laptop shop in BD, a customer's budget is our first concern. We bring the latest Intel Laptop and AMD Laptop under budget for every customer - from starters to expert users. Star Tech is considered the most trusted laptop shop in BD, allowing you to buy the best laptops from top laptop brands in the world. Along with the best laptop brands, our experts provide you with the best buying decisions based on your needs and budget - making Star Tech the trusted and most popular laptop shop in Bangladesh. Star Tech lets you buy an official Apple <a class="text-starOrange hover:underline" href="#">MacBook</a> Air or MacBook Pro from <a class="text-starOrange hover:underline" href="#">Apple Store in Bangladesh</a>. Star Tech sells the latest models of the most popular laptop brands, such as - <a class="text-starOrange hover:underline" href="#">Razer</a>, <a class="text-starOrange hover:underline" href="#">HP</a>, Dell, <a class="text-starOrange hover:underline" href="#">Apple MacBook</a>, <a class="text-starOrange hover:underline" href="#">Asus</a>, <a class="text-starOrange hover:underline" href="#">Acer</a>, <a class="text-starOrange hover:underline" href="#">Lenovo</a>, <a class="text-starOrange hover:underline" href="#">Microsoft Surface</a>, MSI, Gigabyte, <a class="text-starOrange hover:underline" href="#">Infinix</a>, <a class="text-starOrange hover:underline" href="#">Walton</a>, Xiaomi Mi, Huawei, Chuwi, etc.
            </p>
        </div>

        <div class="space-y-2">
            <h3 class="text-base font-bold text-slate-900">Best Desktop PC Shop In Bangladesh</h3>
            <p>
                <a class="text-starOrange hover:underline font-semibold" href="#">Star Tech</a> has the most comprehensive array of <a class="text-starOrange hover:underline" href="#">Desktop PCs</a>. We offer top-of-the-line Custom PC, <a class="text-starOrange hover:underline" href="#">Brand PC</a>, All-in-One PC, and <a class="text-starOrange hover:underline" href="#">Portable Mini PC</a> at Star Tech outlets, the trusted and most popular Desktop PC shop in Bangladesh, which are spread nationwide. Get your new iMac Desktop or <a class="text-starOrange hover:underline" href="#">Apple Mac Mini</a> with an international warranty and servicing plan. You can always depend on the Star Tech PC shop experts to build the best desktop PC or computer with parts of your choice. Star Tech is Bangladesh's most reliable repair shop for PC, laptops, &amp; other consumer electronics. Take your gaming or professional content creation to the next level with a large collection of high-end Gaming PC and Editing PC from Star Tech. You can build a complete personal computer with the best desktop PC parts picked by you with our <a class="text-starOrange hover:underline font-semibold" href="#">PC Builder</a> feature. The features let you <a class="text-starOrange hover:underline" href="#">pick PC parts</a> to buy the best desktop PC anytime. Or, you can visit any Star Tech custom PC shop near you to build the best Desktop PC according to your taste, live, and in front of you.
            </p>
        </div>

        <div class="space-y-2">
            <h3 class="text-base font-bold text-slate-900">Best Gaming PC Shop In Bangladesh</h3>
            <p>
                We at Star Tech love gaming. Therefore, we aim to provide a holistic gaming experience with our best gaming PC shop in Bangladesh, "Star Tech Rig House." The Rig House is a specialized shop for PC builds with high-end PC components. Star Tech Rig House is highly decorated with the best gaming PC parts for customers to build online Gaming or editing PC. Our gaming PC shop in Bangladesh offers the broadest range of Gaming PC, Gaming Laptops, and <a class="text-starOrange hover:underline" href="#">Game Consoles</a> from XBOX &amp; PlayStation. Star Tech's largest Gaming PC shop consists of Gaming Motherboards, Liquid Coolers, Custom Water Cooling for PC, Gaming Casings, high-performance RAM Kits, Graphics Cards, etc. Our exceptional gaming accessories cover Gaming Chairs, Gaming Sofas, RGB Mousepads, Gaming Headphones, Headphone Stands, RGB Gaming PC Light-Strips and many more. We have strategic partnerships with many world-renowned computer gaming brands like Razer, PNY, ASRock, Asus, Zotac, GALAX, Noctua, Antec, Lian Li, CRYORIG, EKWB, Gamdias, KWG, XFX, etc. Our gaming concern extends to leading gaming brands, including A4Tech Bloody, SteelSeries, Logitech, Corsair, Redragon, Cooler Master, Fantech, DeepCool, Cougar, Gigabyte &amp; Elgato products at our exclusive Gaming PC Shop.
            </p>
        </div>

        <div class="space-y-2">
            <h3 class="text-base font-bold text-slate-900">Best Office Equipment Shop In Bangladesh</h3>
            <p>
                Star Tech Ltd. is Bangladesh's most trusted <a class="text-starOrange hover:underline" href="#">Office Equipment</a> Shop. For more than 18 years, we have been providing the best Office Solution. Take a quick drive to the nearest Star Tech retail center and furnish your home office, Start-up business desk, or corporate space with the best <a class="text-starOrange hover:underline" href="#">Office Equipment</a> and office supplies. <a class="text-starOrange hover:underline" href="#">Find Laptops</a>, Desktops, Antiviruses, CCTV &amp; IP Cameras, Printers, Routers, Photocopiers, Attendance Machines, Scanners, Conference Systems, Server Equipment, etc for smooth office operation.
            </p>
        </div>

        <div class="space-y-2">
            <h3 class="text-base font-bold text-slate-900">Largest Gadget Shop In Bangladesh</h3>
            <p>
                We bring in the most sought-after <a class="text-starOrange hover:underline" href="#">gadgets</a> at Star Tech. Only genuine and leading brands of <a class="text-starOrange hover:underline" href="#">Smart Watch</a>, <a class="text-starOrange hover:underline" href="#">Earbuds</a>, <a class="text-starOrange hover:underline" href="#">TV</a>, <a class="text-starOrange hover:underline" href="#">Power Bank</a>, and Mobile Phone Accessories are available at our Gadget Shop. We are also concerned for creative professionals for whom we bring exciting gadgets like Drones, Studio Equipment, <a class="text-starOrange hover:underline" href="#">DSLR Camera</a>, <a class="text-starOrange hover:underline" href="#">Gimbals</a> &amp; Stream Decks from internationally reputed brands like DJI, Blackmagic, Corsair, Zhiyun, Gudsen, and Loupedeck. Star Tech has established the largest gadget shop in BD with the help of an app &amp; E-commerce website. Ease up your chores with Daily Lifestyle gadgets from our gadget shop. Xiaomi, Anker, Micropack, Vention, Fire-Boltt, UGREEN, OnePlus, Apple, Baseus, Orico, Havit, Samsung, and HOCO are a few of the brands we cover.
            </p>
        </div>

        <div class="space-y-2">
            <h3 class="text-base font-bold text-slate-900">Top Mobile Shop In Bangladesh</h3>
            <p>
                Star Tech <a class="text-starOrange hover:underline" href="#">mobile phone</a> shop offers the latest smartphones and <a class="text-starOrange hover:underline" href="#">feature phones</a> from top mobile brands. <a class="text-starOrange hover:underline" href="#">Samsung</a>, Motorola, Google Pixel, <a class="text-starOrange hover:underline" href="#">Vivo</a>, Huawei, Xiaomi, <a class="text-starOrange hover:underline" href="#">OPPO</a>, Mi, Realme, and <a class="text-starOrange hover:underline" href="#">OnePlus</a> are among the Android smartphone brands at our mobile shop. Star Tech is a one-stop solution for buying <a class="text-starOrange hover:underline" href="#">iPhones</a> in Bangladesh. Star Tech is also your go-to destination for buying the latest Android tablets and <a class="text-starOrange hover:underline" href="#">iPads</a> in Bangladesh. Offering extensive warranty, EMI &amp; home delivery service spanning the country, we are the top <a class="text-starOrange hover:underline" href="#">mobile</a> shop in Bangladesh, presenting the best online shop for mobile phones. Our mobile phone shop has an extensive collection of <a class="text-starOrange hover:underline" href="#">mobile phone accessories</a>, including chargers, USB Type-C Cables, Power Banks, Wireless Chargers, and many more to go with your smartphone.
            </p>
        </div>

        <div class="space-y-2">
            <h3 class="text-base font-bold text-slate-900">Best Home Appliance Shop In Bangladesh</h3>
            <p>
                Star Tech is a popular home appliance shop in Bangladesh with a variety of top-quality home appliances including <a class="text-starOrange hover:underline" href="#">air conditioners</a>, <a class="text-starOrange hover:underline" href="#">washing machines</a>, <a class="text-starOrange hover:underline" href="#">ovens</a>, refrigerators, <a class="text-starOrange hover:underline" href="#">geysers</a>, vacuum cleaners, <a class="text-starOrange hover:underline" href="#">sewing machines</a>, <a class="text-starOrange hover:underline" href="#">electric room heaters</a>, and more. Star Tech offers home appliances from renowned brands like Samsung, LG, Hitachi, Whirlpool, Singer, Haier, <a class="text-starOrange hover:underline" href="#">Walton</a>, and so on. To assist customers in selecting the appropriate air conditioner, Star Tech has an <a class="text-starOrange hover:underline" href="#">AC Ton Calculator</a>, helping determine the ideal AC capacity based on room size and other factors. Star Tech focuses on the evolving needs of modern households and ensures best quality Home Appliance at best price in Bangladesh.
            </p>
        </div>

        <div class="space-y-2">
            <h3 class="text-base font-bold text-slate-900">Trusted Online Shopping From Bangladesh at The Best E-Commerce Website</h3>
            <p>
                Star Tech believes the most in customer satisfaction. To meet the surging demand for online shopping from Bangladesh, we launched our <a class="text-starOrange hover:underline" href="#">E-Commerce</a> website. Our highly trusted online shop has been regarded as one of the best E-Commerce websites with most visits. Star Tech is revolutionizing online shopping in Bangladesh, featuring a brilliant search engine that helps our valued customers find their desired products easily. We have developed the most comprehensive PC Builder App, also integrated into our online retail store. With the PC Builder, you can build your custom PC, save the build, get an estimated price, and compare components to make your ideal desktop PC.
            </p>
        </div>

        <div class="space-y-2">
            <h3 class="text-base font-bold text-slate-900">Best Price, Product, After-Sales Customer Service, &amp; Fastest Delivery</h3>
            <p>
                Star Tech Ltd. has taken care of its customers since the beginning. Whether a customer is purchasing or inquiring, our customers get the highest priority. We deliver the best product for the best price with extended after-sales support &amp; the highest standard of customer service. We offer your desired product within the fastest delivery timeframe. With our nationwide presence, we cover all 64 districts of Bangladesh. Our distribution hubs are located in Dhaka, Chattogram, Khulna, Rangpur, Gazipur, Rajshahi, and Mymensingh. We also have over 15 dedicated service centers and are proud to offer computer home service for the first time in Bangladesh.
            </p>
        </div>
    </article>

</div>
@endsection