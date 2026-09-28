@extends('layouts.app')

@section('title', 'SM Shop - Leading Computer, Laptop & Gadget Shop in Bangladesh')

@section('content')
<div class="max-w-[1320px] mx-auto px-4 py-4 space-y-6">

    <!-- =========================================================================
         1. NOTICE BAR
         ========================================================================= -->
    <div class="bg-white rounded-full py-2.5 px-6 shadow-sm border border-slate-100 flex items-center justify-center text-xs md:text-sm text-slate-700 text-center font-normal">
        <span class="inline-block truncate">
            স্বাগতম SM Shop এ! ঢাকা সহ সারাদেশে দ্রুত হোম ডেলিভারি ও অরিজিনাল টেক প্রোডাক্টের অফিসিয়াল ওয়ারেন্টি। হেল্পলাইন: 16793
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
                Technology has become an integral part of our daily lives, and we depend on tech products daily for work, study, and recreation. <a class="text-starOrange hover:underline font-semibold" href="#">SM Shop</a> is your premier destination for genuine tech gear in Bangladesh. We focus on giving the best customer service, adhering to our core principle: <strong>"Customer Comes First."</strong> This is why SM Shop is rapidly becoming one of the most <strong>trusted computer &amp; gadget shops in Bangladesh</strong>, providing official brand warranties, verified quality products, and express nationwide delivery.
            </p>
        </div>

        <div class="space-y-2">
            <h3 class="text-base font-bold text-slate-900">Best Laptop &amp; Desktop PC Shop in Bangladesh</h3>
            <p>
                SM Shop offers an extensive range of <a class="text-starOrange hover:underline font-semibold" href="{{ route('shop.index', ['category' => 'laptop']) }}">laptops</a> and <a class="text-starOrange hover:underline font-semibold" href="{{ route('shop.index', ['category' => 'desktop']) }}">desktop PCs</a>. Whether you are a student, programmer, creative professional, or gamer, we carry top brands including Asus, Lenovo, HP, Dell, MSI, Apple MacBook, Acer, and custom AMD Ryzen / Intel gaming rigs. Our experienced technical team helps you select the best components to fit your exact workload and budget.
            </p>
        </div>

        <div class="space-y-2">
            <h3 class="text-base font-bold text-slate-900">100% Genuine Components &amp; Fast Nationwide Delivery</h3>
            <p>
                At SM Shop, we guarantee 100% genuine products with official distributor warranties. We deliver to all 64 districts across Bangladesh with secure cash-on-delivery and digital payment options. For inquiries, advice, or order tracking, our support helpline and live chat team are always ready to assist you.
            </p>
        </div>
    </article>

</div>
@endsection