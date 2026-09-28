@extends('layouts.admin')

@section('title', 'AI Bulk Product Importer - SM Shop Control Center')

@section('content')
<div class="space-y-6" x-data="aiImporterApp()" x-init="initApp()">
    
    <!-- Top Header & Action Strip -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 bg-[#1e1e2d] border border-[#2b2b40] p-6 rounded-2xl shadow-lg">
        <div class="space-y-1">
            <div class="flex items-center gap-2">
                <span class="w-8 h-8 rounded-lg bg-gradient-to-br from-purple-500 to-indigo-600 flex items-center justify-center text-white text-base shadow-md">
                    <i class="fa-solid fa-wand-magic-sparkles text-amber-300"></i>
                </span>
                <h1 class="text-xl sm:text-2xl font-black text-white tracking-tight">AI Bulk Product Importer &amp; Rewriter</h1>
            </div>
            <p class="text-xs text-gray-400">
                Paste any product or <strong class="text-indigo-400">category listing URL</strong>. Google Gemini AI automatically extracts all high-res gallery images, rewrites titles &amp; descriptions with <strong class="text-white">SM Shop</strong> branding, and saves to database.
            </p>
        </div>

        <!-- Action Buttons -->
        <div class="flex items-center gap-3">
            <form action="{{ route('admin.products.purge-demo') }}" method="POST" onsubmit="return confirm('WARNING: This will remove all existing products from the database so you can start fresh with your imported products. Continue?');">
                @csrf
                <button type="submit" class="px-4 py-2.5 rounded-xl bg-red-500/10 hover:bg-red-500/20 text-red-400 border border-red-500/30 text-xs font-bold transition flex items-center gap-2 cursor-pointer">
                    <i class="fa-solid fa-trash-can"></i>
                    <span>Purge Old Products</span>
                </button>
            </form>
            <a href="{{ route('admin.products.index') }}" class="px-4 py-2.5 rounded-xl bg-[#2b2b40] hover:bg-[#32324d] text-white text-xs font-bold transition flex items-center gap-2">
                <i class="fa-solid fa-boxes-stacked"></i> View Catalog ({{ $totalProducts }})
            </a>
        </div>
    </div>

    <!-- Alert / Status Notifications -->
    @if(session('success'))
        <div class="p-4 rounded-xl bg-emerald-500/10 border border-emerald-500/30 text-emerald-400 text-xs font-bold flex items-center justify-between">
            <div class="flex items-center gap-2">
                <i class="fa-solid fa-circle-check text-base"></i>
                <span>{{ session('success') }}</span>
            </div>
            <button type="button" onclick="this.parentElement.remove()" class="text-emerald-400 hover:text-white cursor-pointer"><i class="fa-solid fa-xmark"></i></button>
        </div>
    @endif
    @if(session('error'))
        <div class="p-4 rounded-xl bg-red-500/10 border border-red-500/30 text-red-400 text-xs font-bold flex items-center justify-between">
            <div class="flex items-center gap-2">
                <i class="fa-solid fa-circle-exclamation text-base"></i>
                <span>{{ session('error') }}</span>
            </div>
            <button type="button" onclick="this.parentElement.remove()" class="text-red-400 hover:text-white cursor-pointer"><i class="fa-solid fa-xmark"></i></button>
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
        
        <!-- Left 8 Columns: Main Import Form -->
        <div class="lg:col-span-8 space-y-6">
            <div class="bg-[#1e1e2d] border border-[#2b2b40] rounded-2xl p-6 shadow-lg space-y-6">
                
                <div class="flex items-center justify-between pb-4 border-b border-[#2b2b40]">
                    <h2 class="text-sm font-bold text-white uppercase tracking-wider flex items-center gap-2">
                        <i class="fa-solid fa-link text-indigo-400"></i> Import Sources &amp; Product Links
                    </h2>
                    <span class="text-[11px] text-purple-300 bg-purple-500/20 px-2.5 py-1 rounded-full font-bold border border-purple-500/30">
                        ⚡ Powered by Google Gemini AI
                    </span>
                </div>

                <form action="{{ route('admin.products.ai-import.process') }}" method="POST" @submit="handleSubmit($event)" class="space-y-5">
                    @csrf

                    <!-- Google Gemini API Key Input (Persistent & Remembered) -->
                    <div class="p-4 rounded-xl bg-[#13141a] border border-[#2b2b40] space-y-2">
                        <div class="flex items-center justify-between">
                            <label class="text-xs font-bold text-gray-200 uppercase tracking-wider flex items-center gap-1.5">
                                <i class="fa-brands fa-google text-amber-400"></i>
                                <span>Google Gemini API Key</span>
                            </label>
                            <span x-show="apiKey" class="text-[11px] text-emerald-400 font-bold flex items-center gap-1 bg-emerald-500/10 px-2 py-0.5 rounded border border-emerald-500/20">
                                <i class="fa-solid fa-circle-check"></i> Saved &amp; Active (বার বার দেওয়া লাগবে না)
                            </span>
                        </div>

                        <div class="flex gap-2">
                            <input 
                                type="text" 
                                name="api_key" 
                                x-model="apiKey"
                                @input="onKeyChange()"
                                placeholder="Paste your Google Gemini API Key here (e.g. AIzaSy...)"
                                class="flex-1 px-4 py-2.5 bg-[#0e0f14] border border-[#2b2b40] rounded-xl text-xs font-mono text-gray-200 focus:outline-none focus:border-purple-500"
                            >
                            <button 
                                type="button" 
                                @click="saveApiKeyPermanently()" 
                                class="px-4 py-2.5 rounded-xl bg-purple-600/30 hover:bg-purple-600/50 text-purple-200 border border-purple-500/40 text-xs font-bold transition flex items-center gap-1.5 cursor-pointer shrink-0"
                            >
                                <i class="fa-solid fa-floppy-disk"></i>
                                <span x-text="keySavedText">Save Key</span>
                            </button>
                        </div>
                        <p class="text-[11px] text-gray-400">API Key টি একবার Save করলে আর কখনো টাইপ করা লাগবে না। এটি দিয়ে টাইটেল ও ডেসক্রিপশন SM Shop ব্র্যান্ডিংয়ে রিরাইট করা হয়।</p>
                    </div>

                    <!-- URL Input Textarea -->
                    <div>
                        <div class="flex items-center justify-between mb-1.5 flex-wrap gap-2">
                            <label class="text-xs font-bold text-gray-300 uppercase tracking-wider">
                                Product URLs / Category Listing URL *
                            </label>
                            <div class="flex items-center gap-3">
                                <button 
                                    type="button" 
                                    @click="discoverFromCategory()" 
                                    :disabled="isDiscovering || getUrlCount() === 0"
                                    class="text-[11px] text-amber-300 bg-amber-500/20 border border-amber-500/30 px-2.5 py-1 rounded font-bold hover:bg-amber-500/30 transition cursor-pointer flex items-center gap-1"
                                >
                                    <i class="fa-solid fa-magnifying-glass" x-show="!isDiscovering"></i>
                                    <i class="fa-solid fa-spinner fa-spin" x-show="isDiscovering" style="display:none;"></i>
                                    <span>Extract All Products From Category</span>
                                </button>

                                <button 
                                    type="button" 
                                    @click="insertSampleUrls()" 
                                    class="text-[11px] text-indigo-400 hover:text-indigo-300 font-bold hover:underline cursor-pointer"
                                >
                                    + Sample Tech Links
                                </button>
                            </div>
                        </div>

                        <textarea 
                            name="urls" 
                            x-model="urlText"
                            rows="8" 
                            placeholder="এখানে এক বা একাধিক প্রোডাক্ট লিংক পেস্ট করুন অথবা ক্যাটাগরি পেজের লিংক দিন:&#10;https://www.techlandbd.com/shop-laptop-computer/brand-laptops&#10;https://www.startech.com.bd/laptop-notebook/laptop&#10;https://www.startech.com.bd/asus-tuf-gaming-a15-fa506nc-ryzen-5-7535hs-rtx-3050-graphics-gaming-laptop"
                            class="w-full px-4 py-3 bg-[#13141a] border border-[#2b2b40] rounded-xl text-xs font-mono text-gray-200 focus:outline-none focus:border-purple-500 leading-relaxed placeholder-gray-600"
                            required
                        ></textarea>

                        <div class="flex items-center justify-between text-[11px] text-gray-400 mt-1">
                            <span>ক্যাটাগরি লিংক দিলে সিস্টেম নিজে থেকেই সব প্রোডাক্ট খুঁজে নিয়ে একবারে ইমপোর্ট করবে।</span>
                            <span class="font-mono text-purple-300 font-bold" x-text="getUrlCount() + ' link(s) ready'"></span>
                        </div>
                    </div>

                    <!-- Options Checkboxes -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 pt-2">
                        <label class="p-3.5 rounded-xl bg-[#13141a] border border-[#2b2b40] flex items-center gap-3 cursor-pointer hover:border-purple-500/50 transition">
                            <input type="checkbox" name="purge_demo" value="1" x-model="purgeDemo" class="rounded bg-[#1e1e2d] border-[#2b2b40] text-red-500 focus:ring-0">
                            <div>
                                <span class="text-xs font-bold text-white block">Purge Old Products First</span>
                                <span class="text-[10px] text-gray-400">নতুন ইমপোর্টের আগে ডেমো প্রোডাক্ট মুছে ফেলুন</span>
                            </div>
                        </label>

                        <label class="p-3.5 rounded-xl bg-[#13141a] border border-[#2b2b40] flex items-center gap-3 cursor-pointer hover:border-purple-500/50 transition">
                            <input type="checkbox" checked disabled class="rounded bg-[#1e1e2d] border-[#2b2b40] text-purple-500 focus:ring-0">
                            <div>
                                <span class="text-xs font-bold text-white block">SM Shop Brand Rewrite &amp; Gallery</span>
                                <span class="text-[10px] text-emerald-400">Official warranty + Multiple HD images</span>
                            </div>
                        </label>
                    </div>

                    <!-- Submit Actions -->
                    <div class="pt-4 flex flex-col sm:flex-row gap-3">
                        <button 
                            type="button" 
                            @click="startInteractiveImport()" 
                            :disabled="isImporting"
                            class="flex-1 bg-gradient-to-r from-purple-600 to-indigo-600 hover:from-purple-500 hover:to-indigo-500 disabled:opacity-50 text-white text-xs font-black uppercase tracking-wider py-4 px-6 rounded-xl transition shadow-lg shadow-purple-600/30 flex items-center justify-center gap-2 cursor-pointer"
                        >
                            <i class="fa-solid fa-bolt" x-show="!isImporting"></i>
                            <i class="fa-solid fa-spinner fa-spin" x-show="isImporting" style="display: none;"></i>
                            <span x-text="isImporting ? 'AI Scraping & Processing...' : 'Start Real-time AI Bulk Import (Recommended)'"></span>
                        </button>

                        <button 
                            type="submit" 
                            :disabled="isImporting"
                            class="px-6 py-4 rounded-xl bg-[#2b2b40] hover:bg-[#383854] text-white text-xs font-bold transition flex items-center justify-center gap-2 cursor-pointer"
                        >
                            <i class="fa-solid fa-server"></i>
                            <span>Standard Server Import</span>
                        </button>
                    </div>
                </form>

                <!-- Live Interactive Progress Panel -->
                <div x-show="showProgress" x-cloak class="p-5 rounded-xl bg-[#13141a] border border-purple-500/30 space-y-4" style="display: none;">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-2 text-xs font-bold text-white">
                            <span class="w-2.5 h-2.5 rounded-full bg-purple-500 animate-ping"></span>
                            <span x-text="'Processing: ' + progressCurrent + ' of ' + progressTotal"></span>
                        </div>
                        <span class="text-xs font-mono text-purple-300 font-bold" x-text="progressPercent + '%'"></span>
                    </div>

                    <div class="w-full h-2.5 bg-[#1e1e2d] rounded-full overflow-hidden border border-[#2b2b40]">
                        <div class="h-full bg-gradient-to-r from-purple-500 to-indigo-500 transition-all duration-300" :style="'width: ' + progressPercent + '%'"></div>
                    </div>

                    <!-- Live Log Console -->
                    <div class="max-h-56 overflow-y-auto space-y-1.5 font-mono text-[11px] p-3 rounded-lg bg-[#0d0e12] border border-[#1e1e2d]" id="import-log-console">
                        <template x-for="(log, idx) in logs" :key="idx">
                            <div class="flex items-start gap-2" :class="log.type === 'error' ? 'text-red-400' : (log.type === 'success' ? 'text-emerald-400' : (log.type === 'warn' ? 'text-amber-400' : 'text-gray-300'))">
                                <span class="text-gray-600 shrink-0" x-text="log.time"></span>
                                <span x-html="log.message"></span>
                            </div>
                        </template>
                    </div>
                </div>

            </div>
        </div>

        <!-- Right 4 Columns: Guide & Live Import Stats -->
        <div class="lg:col-span-4 space-y-6">
            
            <!-- How It Works Card -->
            <div class="bg-[#1e1e2d] border border-[#2b2b40] rounded-2xl p-6 shadow-lg space-y-4">
                <h3 class="text-xs font-bold text-white uppercase tracking-wider flex items-center gap-2 pb-3 border-b border-[#2b2b40]">
                    <i class="fa-solid fa-circle-question text-amber-400"></i> How AI Importer Works
                </h3>
                
                <div class="space-y-3.5 text-xs text-gray-300 leading-relaxed">
                    <div class="flex items-start gap-3">
                        <div class="w-6 h-6 rounded-full bg-purple-500/20 text-purple-300 font-bold text-xs flex items-center justify-center shrink-0 border border-purple-500/30">1</div>
                        <p><strong class="text-white">Category / Single Links:</strong> ক্যাটালগ লিংক দিলে স্বয়ংক্রিয়ভাবে ক্যাটাগরির সমস্ত প্রোডাক্ট একসাথে এক্সট্র্যাক্ট করে নেয়।</p>
                    </div>
                    <div class="flex items-start gap-3">
                        <div class="w-6 h-6 rounded-full bg-indigo-500/20 text-indigo-300 font-bold text-xs flex items-center justify-center shrink-0 border border-indigo-500/30">2</div>
                        <p><strong class="text-white">Multiple Gallery HD Images:</strong> মূল থাম্বনেইলের পাশাপাশি ৪-৬টি হাই-রেজ্যুলেশন গ্যালারি ফটো সেভ করে।</p>
                    </div>
                    <div class="flex items-start gap-3">
                        <div class="w-6 h-6 rounded-full bg-emerald-500/20 text-emerald-300 font-bold text-xs flex items-center justify-center shrink-0 border border-emerald-500/30">3</div>
                        <p><strong class="text-white">Gemini AI Rewrite:</strong> অন্য দোকানের নাম মুছে <strong class="text-white">SM Shop</strong> এর ওয়ারেন্টি পলিসি ও হাই-কনভার্টিং কপিরাইটিং তৈরি করে।</p>
                    </div>
                    <div class="flex items-start gap-3">
                        <div class="w-6 h-6 rounded-full bg-amber-500/20 text-amber-300 font-bold text-xs flex items-center justify-center shrink-0 border border-amber-500/30">4</div>
                        <p><strong class="text-white">Social Proof:</strong> প্রতিটি পণ্যের জন্য বাংলা ও ইংরেজি ভেরিফাইড কাস্টমার রিভিউ ও ৫-স্টার রেটিং যোগ করে।</p>
                    </div>
                </div>
            </div>

            <!-- Category Summary -->
            <div class="bg-[#1e1e2d] border border-[#2b2b40] rounded-2xl p-6 shadow-lg space-y-3">
                <h3 class="text-xs font-bold text-white uppercase tracking-wider flex items-center justify-between pb-3 border-b border-[#2b2b40]">
                    <span>Catalog Categories</span>
                    <span class="text-gray-400 text-[11px] font-mono">{{ $categories->count() }} Total</span>
                </h3>
                <div class="max-h-60 overflow-y-auto space-y-1.5 pr-1 text-xs">
                    @foreach($categories as $cat)
                        <div class="flex items-center justify-between p-2 rounded-lg bg-[#13141a] text-gray-300">
                            <span class="font-medium">{{ $cat->name }}</span>
                            <span class="text-[11px] font-mono font-bold text-purple-300 bg-purple-500/20 px-2 py-0.5 rounded">{{ $cat->products_count }} items</span>
                        </div>
                    @endforeach
                </div>
            </div>

        </div>

    </div>

    <!-- Recently Imported Products Table -->
    <div class="bg-[#1e1e2d] border border-[#2b2b40] rounded-2xl p-6 shadow-lg space-y-4">
        <div class="flex items-center justify-between pb-3 border-b border-[#2b2b40]">
            <h3 class="text-sm font-bold text-white uppercase tracking-wider flex items-center gap-2">
                <i class="fa-solid fa-clock-rotate-left text-purple-400"></i> Recently Added Products ({{ $recentProducts->count() }})
            </h3>
            <a href="{{ route('admin.products.index') }}" class="text-xs text-indigo-400 hover:underline font-bold">
                View All in Catalog &rarr;
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-xs text-left">
                <thead class="bg-[#13141a] text-gray-400 uppercase text-[10px] tracking-wider">
                    <tr>
                        <th class="py-3 px-4">Product Details</th>
                        <th class="py-3 px-4">Category</th>
                        <th class="py-3 px-4">Price (৳)</th>
                        <th class="py-3 px-4">Stock</th>
                        <th class="py-3 px-4 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#2b2b40]">
                    @forelse($recentProducts as $prod)
                        <tr class="hover:bg-[#26273b] transition">
                            <td class="py-3 px-4 flex items-center gap-3">
                                <img src="{{ $prod->image }}" alt="{{ $prod->name }}" class="w-10 h-10 rounded-lg object-contain bg-white p-1 border border-gray-700 shrink-0">
                                <div class="min-w-0">
                                    <div class="font-bold text-white truncate max-w-sm">{{ $prod->name }}</div>
                                    <div class="text-[10px] text-gray-400 font-mono">SKU: {{ $prod->sku }} | Images: {{ 1 + count($prod->gallery_images ?? []) }}</div>
                                </div>
                            </td>
                            <td class="py-3 px-4 text-gray-300">
                                {{ $prod->category->name ?? 'N/A' }}
                            </td>
                            <td class="py-3 px-4">
                                <span class="font-bold text-starOrange">{{ number_format($prod->effective_price) }}৳</span>
                                @if($prod->has_discount)
                                    <span class="text-[10px] text-gray-500 line-through block">{{ number_format($prod->price) }}৳</span>
                                @endif
                            </td>
                            <td class="py-3 px-4">
                                <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-emerald-500/20 text-emerald-400">
                                    {{ $prod->stock }} In Stock
                                </span>
                            </td>
                            <td class="py-3 px-4 text-right space-x-2">
                                <a href="{{ route('product.show', $prod->slug) }}" target="_blank" class="px-2.5 py-1 rounded bg-[#2b2b40] hover:bg-[#3b3b5c] text-white text-[11px] font-bold transition">
                                    <i class="fa-solid fa-arrow-up-right-from-square"></i> Store View
                                </a>
                                <a href="{{ route('admin.products.edit', $prod->id) }}" class="px-2.5 py-1 rounded bg-indigo-500/20 hover:bg-indigo-500/30 text-indigo-300 text-[11px] font-bold transition">
                                    <i class="fa-solid fa-pen-to-square"></i> Edit
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-8 text-gray-500 italic">No products imported yet. Paste some URLs above to get started!</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>

<!-- Alpine.js Live Importer Script -->
<script>
    function aiImporterApp() {
        return {
            apiKey: '{{ $geminiApiKey }}',
            keySavedText: 'Save Key',
            urlText: '',
            purgeDemo: false,
            isImporting: false,
            isDiscovering: false,
            showProgress: false,
            progressCurrent: 0,
            progressTotal: 0,
            progressPercent: 0,
            logs: [],

            initApp() {
                const stored = localStorage.getItem('sm_gemini_api_key');
                if (stored && !this.apiKey) {
                    this.apiKey = stored;
                }
                if (this.apiKey) {
                    localStorage.setItem('sm_gemini_api_key', this.apiKey);
                }
            },

            onKeyChange() {
                if (this.apiKey) {
                    localStorage.setItem('sm_gemini_api_key', this.apiKey);
                }
            },

            async saveApiKeyPermanently() {
                if (!this.apiKey) {
                    alert('Please enter your Google API key first.');
                    return;
                }
                localStorage.setItem('sm_gemini_api_key', this.apiKey);
                this.keySavedText = 'Saving...';

                try {
                    const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
                    const res = await fetch('{{ route("admin.products.ai-import.save-key") }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': token || ''
                        },
                        body: JSON.stringify({ api_key: this.apiKey })
                    });
                    const data = await res.json();
                    if (data.success) {
                        this.keySavedText = '✓ Saved!';
                        setTimeout(() => this.keySavedText = 'Save Key', 3000);
                    }
                } catch (e) {
                    this.keySavedText = 'Save Key';
                }
            },

            getUrlCount() {
                const links = this.urlText.split(/[\r\n,]+/).map(s => s.trim()).filter(s => s.length > 8);
                return links.length;
            },

            insertSampleUrls() {
                this.urlText = [
                    'https://www.startech.com.bd/laptop-notebook/laptop',
                    'https://www.startech.com.bd/lenovo-ideapad-slim-3-15abr8-ryzen-7-7730u-laptop',
                    'https://www.startech.com.bd/asus-tuf-gaming-a15-fa506nc-ryzen-5-7535hs-rtx-3050-graphics-gaming-laptop',
                    'https://www.startech.com.bd/amd-ryzen-5-5600g-processor-desktop-pc'
                ].join('\n');
            },

            async discoverFromCategory() {
                const lines = this.urlText.split(/[\r\n,]+/).map(s => s.trim()).filter(s => s.length > 8);
                if (lines.length === 0) {
                    alert('Please enter a Category / Listing URL first.');
                    return;
                }

                const targetUrl = lines[0];
                this.isDiscovering = true;
                this.addLog(`🔍 Scanning category URL for products: <span class="text-white">${targetUrl}</span>`);

                try {
                    const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
                    const res = await fetch('{{ route("admin.products.ai-import.discover") }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': token || ''
                        },
                        body: JSON.stringify({ url: targetUrl })
                    });

                    const data = await res.json();
                    if (data.success && data.links.length > 0) {
                        this.urlText = data.links.join('\n');
                        this.addLog(`✓ Found <strong>${data.links.length}</strong> products in this category! Populated in the URL box ready for AI import.`, 'success');
                    } else {
                        this.addLog(`⚠️ No child links found automatically for this URL.`, 'warn');
                    }
                } catch (e) {
                    this.addLog(`✗ Category scan failed: ${e.message}`, 'error');
                } finally {
                    this.isDiscovering = false;
                }
            },

            addLog(message, type = 'info') {
                const now = new Date();
                const time = now.toTimeString().split(' ')[0];
                this.logs.push({ time, message, type });
                this.$nextTick(() => {
                    const el = document.getElementById('import-log-console');
                    if (el) el.scrollTop = el.scrollHeight;
                });
            },

            async startInteractiveImport() {
                let rawLinks = this.urlText.split(/[\r\n,]+/).map(s => s.trim()).filter(s => s.length > 8);
                if (rawLinks.length === 0) {
                    alert('Please enter at least one valid product or category URL.');
                    return;
                }

                // If user entered only 1 URL and it's a category, let's discover sub-links
                if (rawLinks.length === 1 && (rawLinks[0].includes('laptop') || rawLinks[0].includes('shop-') || rawLinks[0].includes('category') || rawLinks[0].includes('brand-'))) {
                    this.isImporting = true;
                    this.showProgress = true;
                    this.logs = [];
                    this.addLog(`🔍 Category page detected (<span class="text-white">${rawLinks[0]}</span>). Extracting all products from this category...`);
                    
                    try {
                        const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
                        const res = await fetch('{{ route("admin.products.ai-import.discover") }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'Accept': 'application/json',
                                'X-CSRF-TOKEN': token || ''
                            },
                            body: JSON.stringify({ url: rawLinks[0] })
                        });
                        const data = await res.json();
                        if (data.success && data.links.length > 0) {
                            rawLinks = data.links;
                            this.addLog(`✓ Discovered <strong>${rawLinks.length}</strong> products from category! Starting AI import queue...`, 'success');
                        }
                    } catch (e) {
                        this.addLog(`Proceeding with direct link...`);
                    }
                }

                this.isImporting = true;
                this.showProgress = true;
                this.logs = this.logs || [];
                this.progressCurrent = 0;
                this.progressTotal = rawLinks.length;
                this.progressPercent = 0;

                this.addLog(`🚀 Initializing AI Bulk Import for <strong>${rawLinks.length}</strong> product(s)...`);

                if (this.purgeDemo) {
                    this.addLog(`🧹 Purging old products as requested...`);
                    try {
                        const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
                        await fetch('{{ route("admin.products.purge-demo") }}', {
                            method: 'POST',
                            headers: { 'X-CSRF-TOKEN': token || '' }
                        });
                        this.addLog(`✓ Database cleared for clean fresh imports.`, 'success');
                    } catch (e) {
                        this.addLog(`⚠️ Could not purge products: ${e.message}`, 'error');
                    }
                }

                let successCount = 0;
                let failedCount = 0;
                const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

                for (let i = 0; i < rawLinks.length; i++) {
                    const url = rawLinks[i];
                    this.progressCurrent = i + 1;
                    this.progressPercent = Math.round(((i + 1) / rawLinks.length) * 100);

                    this.addLog(`[${i+1}/${rawLinks.length}] 🌐 Scraping &amp; AI rewriting: <span class="text-white">${url}</span>`);

                    try {
                        const res = await fetch('{{ route("admin.products.ai-import.single") }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'Accept': 'application/json',
                                'X-CSRF-TOKEN': token || ''
                            },
                            body: JSON.stringify({
                                url: url,
                                api_key: this.apiKey
                            })
                        });

                        const data = await res.json();

                        if (data.success) {
                            successCount++;
                            this.addLog(`✓ <strong>[IMPORTED]</strong> ${data.name} (<span class="text-starOrange font-bold">${data.price}৳</span>) - ${data.image_count} images <a href="${data.product_url}" target="_blank" class="underline text-indigo-300 ml-1">View Store &rarr;</a>`, 'success');
                        } else {
                            failedCount++;
                            this.addLog(`✗ <strong>[FAILED]</strong> ${data.error || 'Import error'}`, 'error');
                        }
                    } catch (err) {
                        failedCount++;
                        this.addLog(`✗ Connection error: ${err.message}`, 'error');
                    }
                }

                this.isImporting = false;
                this.addLog(`🎉 <strong>All Done!</strong> Successfully imported: ${successCount}, Failed: ${failedCount}`, 'success');

                setTimeout(() => {
                    window.location.reload();
                }, 2500);
            },

            handleSubmit(e) {
                if (this.getUrlCount() === 0) {
                    e.preventDefault();
                    alert('Please enter at least one URL.');
                }
            }
        };
    }
</script>
@endsection
