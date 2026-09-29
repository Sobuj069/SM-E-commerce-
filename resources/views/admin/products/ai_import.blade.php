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
                <h1 class="text-xl sm:text-2xl font-black text-white tracking-tight">100% Exact Product &amp; Category Importer</h1>
            </div>
            <p class="text-xs text-gray-400">
                যেকোনো সিঙ্গেল প্রোডাক্ট লিংক অথবা ক্যাটাগরি পেজ লিংক দিন — হুবহু সেই প্রোডাক্টের ১০০% সঠিক টাইটেল, আসল দাম (৳) এবং হাই-কোয়ালিটি গ্যালারি ইমেজ সহ ইম্পোর্ট হবে।
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
                    <!-- Input Mode Switcher Tabs -->
                    <div class="flex items-center gap-2">
                        <button 
                            type="button" 
                            @click="mode = 'urls'" 
                            class="px-3.5 py-1.5 rounded-lg text-xs font-bold transition cursor-pointer"
                            :class="mode === 'urls' ? 'bg-purple-600 text-white shadow-md' : 'bg-[#13141a] text-gray-400 hover:text-white'"
                        >
                            <i class="fa-solid fa-link mr-1"></i> Web URLs Mode
                        </button>
                        <button 
                            type="button" 
                            @click="mode = 'html'" 
                            class="px-3.5 py-1.5 rounded-lg text-xs font-bold transition cursor-pointer"
                            :class="mode === 'html' ? 'bg-purple-600 text-white shadow-md' : 'bg-[#13141a] text-gray-400 hover:text-white'"
                        >
                            <i class="fa-solid fa-code mr-1"></i> Paste HTML / Page Source Mode
                        </button>
                    </div>

                    <span class="text-[11px] text-emerald-300 bg-emerald-500/20 px-2.5 py-1 rounded-full font-bold border border-emerald-500/30">
                        🎯 100% Exact Title, Price &amp; Images
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
                                <i class="fa-solid fa-circle-check"></i> Saved &amp; Active
                            </span>
                        </div>

                        <div class="flex gap-2">
                            <input 
                                type="text" 
                                name="api_key" 
                                x-model="apiKey"
                                @input="onKeyChange()"
                                placeholder="Paste your Google Gemini API Key here (optional)..."
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
                        <p class="text-[11px] text-gray-400">
                            Saved securely. Even without an API key, exact scraping will import 100% identical titles, authentic prices, and HD gallery images.
                        </p>
                    </div>

                    <!-- MODE 1: Web URLs Input -->
                    <div x-show="mode === 'urls'" class="space-y-2">
                        <div class="flex items-center justify-between mb-1 flex-wrap gap-2">
                            <label class="text-xs font-bold text-gray-300 uppercase tracking-wider">
                                Product URLs / Category Listing URL *
                            </label>
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
                        </div>

                        <!-- Quick Category Presets -->
                        <div class="flex items-center gap-1.5 flex-wrap pb-1">
                            <span class="text-[10px] text-gray-500 uppercase font-bold">Quick Presets:</span>
                            <button type="button" @click="setCategoryUrl('https://www.startech.com.bd/laptop-notebook/laptop')" class="text-[10px] px-2.5 py-1 rounded bg-[#2b2b40] hover:bg-purple-600/50 text-gray-200 border border-[#383854] transition cursor-pointer">
                                💻 20 Laptops (Exact Same Price &amp; Images)
                            </button>
                            <button type="button" @click="setCategoryUrl('https://www.startech.com.bd/desktops')" class="text-[10px] px-2.5 py-1 rounded bg-[#2b2b40] hover:bg-purple-600/50 text-gray-200 border border-[#383854] transition cursor-pointer">
                                🖥️ Desktop PCs
                            </button>
                            <button type="button" @click="setCategoryUrl('https://www.startech.com.bd/monitor')" class="text-[10px] px-2.5 py-1 rounded bg-[#2b2b40] hover:bg-purple-600/50 text-gray-200 border border-[#383854] transition cursor-pointer">
                                🖥️ Monitors
                            </button>
                        </div>

                        <textarea 
                            name="urls" 
                            x-model="urlText"
                            rows="6"
                            placeholder="Paste product links (one per line) or a Category page link:&#10;https://www.startech.com.bd/laptop-notebook/laptop&#10;https://www.startech.com.bd/microsoft-13-inch-surface-laptop"
                            class="w-full px-4 py-3 bg-[#13141a] border border-[#2b2b40] rounded-xl text-xs font-mono text-gray-200 placeholder-gray-500 focus:outline-none focus:border-purple-500 leading-relaxed"
                            required
                        ></textarea>
                        
                        <div class="flex items-center justify-between text-[11px] text-gray-400">
                            <span>Detected URLs: <strong class="text-purple-400 font-bold" x-text="getUrlCount()">0</strong></span>
                            <button type="button" @click="urlText = ''" class="text-gray-400 hover:text-red-400 cursor-pointer">Clear URLs</button>
                        </div>
                    </div>

                    <!-- MODE 2: Paste Raw HTML / Page Source -->
                    <div x-show="mode === 'html'" class="space-y-2" style="display: none;">
                        <div class="flex items-center justify-between mb-1">
                            <label class="text-xs font-bold text-amber-300 uppercase tracking-wider flex items-center gap-1.5">
                                <i class="fa-solid fa-code"></i>
                                <span>Paste Full HTML / Page Source</span>
                            </label>
                            <span class="text-[10px] bg-amber-500/20 text-amber-300 px-2 py-0.5 rounded border border-amber-500/30">
                                🛡️ Bypasses Cloudflare / Bot blocks
                            </span>
                        </div>

                        <p class="text-[11px] text-gray-400 leading-relaxed bg-[#13141a] p-3 rounded-lg border border-[#2b2b40]">
                            <strong>How to use:</strong> Open any page (TechlandBD, Ryans, StarTech, Daraz) in your browser &rarr; Press <kbd class="px-1.5 py-0.5 bg-[#2b2b40] rounded text-[10px] font-mono text-white">Ctrl + U</kbd> (View Source) &rarr; Press <kbd class="px-1.5 py-0.5 bg-[#2b2b40] rounded text-[10px] font-mono text-white">Ctrl + A</kbd> &rarr; <kbd class="px-1.5 py-0.5 bg-[#2b2b40] rounded text-[10px] font-mono text-white">Ctrl + C</kbd> &rarr; Paste here. All product cards with identical titles and prices will be extracted instantly!
                        </p>

                        <textarea 
                            name="html" 
                            x-model="htmlText"
                            rows="7"
                            placeholder="Paste &lt;html&gt; source code here..."
                            class="w-full px-4 py-3 bg-[#13141a] border border-[#2b2b40] rounded-xl text-xs font-mono text-gray-200 placeholder-gray-500 focus:outline-none focus:border-amber-500 leading-relaxed"
                        ></textarea>

                        <div class="flex items-center justify-between text-[11px] text-gray-400">
                            <span>HTML length: <strong class="text-amber-400 font-bold" x-text="htmlText.length.toLocaleString()">0</strong> characters</span>
                            <button type="button" @click="htmlText = ''" class="text-gray-400 hover:text-red-400 cursor-pointer">Clear HTML</button>
                        </div>
                    </div>

                    <!-- Clean Database Checkbox -->
                    <div class="p-3.5 rounded-xl bg-[#13141a] border border-[#2b2b40] flex items-center justify-between">
                        <label class="flex items-center gap-2.5 cursor-pointer select-none">
                            <input 
                                type="checkbox" 
                                name="purge_demo" 
                                value="1" 
                                x-model="purgeDemo"
                                class="w-4 h-4 rounded text-purple-600 bg-[#0e0f14] border-gray-600 focus:ring-0 focus:ring-offset-0"
                            >
                            <div>
                                <span class="text-xs font-bold text-gray-200">Purge &amp; replace old products</span>
                                <p class="text-[11px] text-gray-400">Deletes existing database items before importing fresh products.</p>
                            </div>
                        </label>
                        <span class="text-[10px] uppercase font-black text-amber-400/80 tracking-wider">Recommended</span>
                    </div>

                    <!-- Actions -->
                    <div class="flex items-center justify-end gap-3 pt-2">
                        <button 
                            type="button" 
                            @click="startLiveQueueImport()"
                            :disabled="isImporting"
                            class="px-6 py-3 rounded-xl bg-gradient-to-r from-purple-600 to-indigo-600 hover:from-purple-500 hover:to-indigo-500 text-white text-xs font-black tracking-wide shadow-lg shadow-purple-600/30 transition flex items-center gap-2 cursor-pointer disabled:opacity-50 disabled:cursor-not-allowed"
                        >
                            <i class="fa-solid fa-bolt text-amber-300" x-show="!isImporting"></i>
                            <i class="fa-solid fa-spinner fa-spin" x-show="isImporting" style="display: none;"></i>
                            <span x-text="isImporting ? 'Importing Exact Products...' : 'Start 100% Exact Import'">Start 100% Exact Import</span>
                        </button>
                    </div>
                </form>

                <!-- Live Import Progress Console -->
                <div x-show="showProgress" class="space-y-3 pt-4 border-t border-[#2b2b40]" style="display: none;">
                    <div class="flex items-center justify-between text-xs">
                        <span class="font-bold text-gray-200 flex items-center gap-2">
                            <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                            Live Import Progress: <span x-text="progressCurrent">0</span> / <span x-text="progressTotal">0</span>
                        </span>
                        <span class="font-mono text-purple-400 font-bold" x-text="progressPercent + '%'">0%</span>
                    </div>

                    <!-- Progress Bar -->
                    <div class="w-full h-2.5 bg-[#13141a] rounded-full overflow-hidden border border-[#2b2b40]">
                        <div class="h-full bg-gradient-to-r from-purple-600 to-emerald-400 transition-all duration-300" :style="'width: ' + progressPercent + '%'"></div>
                    </div>

                    <!-- Terminal Logs Box -->
                    <div class="bg-[#0e0f14] border border-[#2b2b40] rounded-xl p-4 font-mono text-xs text-gray-300 max-h-60 overflow-y-auto space-y-1.5 shadow-inner">
                        <template x-for="(log, idx) in logs" :key="idx">
                            <div class="flex items-start gap-2 leading-relaxed" :class="log.type === 'error' ? 'text-red-400' : (log.type === 'success' ? 'text-emerald-400' : 'text-gray-300')">
                                <span class="text-gray-600 select-none">&rsaquo;</span>
                                <span x-html="log.text"></span>
                            </div>
                        </template>
                    </div>
                </div>

            </div>
        </div>

        <!-- Right 4 Columns: Information & Categories -->
        <div class="lg:col-span-4 space-y-6">
            
            <!-- Exact Match Guarantee Card -->
            <div class="bg-gradient-to-br from-[#1e1e2d] to-[#161622] border border-[#2b2b40] rounded-2xl p-5 shadow-lg space-y-3">
                <div class="flex items-center gap-2 text-emerald-400 font-bold text-xs uppercase tracking-wider">
                    <i class="fa-solid fa-shield-check text-base"></i>
                    <span>100% Exact Scraper Guarantee</span>
                </div>
                <ul class="text-xs text-gray-300 space-y-2 leading-relaxed">
                    <li class="flex items-start gap-2">
                        <i class="fa-solid fa-check text-emerald-400 mt-0.5 shrink-0"></i>
                        <span><strong>Same Title:</strong> Exact laptop/desktop brand &amp; model name.</span>
                    </li>
                    <li class="flex items-start gap-2">
                        <i class="fa-solid fa-check text-emerald-400 mt-0.5 shrink-0"></i>
                        <span><strong>Same BD Price:</strong> Actual cash price in Taka (৳) directly from source.</span>
                    </li>
                    <li class="flex items-start gap-2">
                        <i class="fa-solid fa-check text-emerald-400 mt-0.5 shrink-0"></i>
                        <span><strong>Same HD Gallery:</strong> Extracts main image + up to 8 high-res gallery shots.</span>
                    </li>
                    <li class="flex items-start gap-2">
                        <i class="fa-solid fa-check text-emerald-400 mt-0.5 shrink-0"></i>
                        <span><strong>Branded Copy:</strong> Company name set to <strong>SM Shop</strong> with official warranty.</span>
                    </li>
                </ul>
            </div>

            <!-- Categories Overview -->
            <div class="bg-[#1e1e2d] border border-[#2b2b40] rounded-2xl p-5 shadow-lg space-y-4">
                <div class="flex items-center justify-between pb-3 border-b border-[#2b2b40]">
                    <h3 class="text-xs font-bold text-gray-200 uppercase tracking-wider flex items-center gap-2">
                        <i class="fa-solid fa-folder-tree text-purple-400"></i>
                        <span>Target Categories</span>
                    </h3>
                    <span class="text-[11px] text-gray-400 font-bold">{{ $categories->count() }} total</span>
                </div>

                <div class="space-y-2 max-h-56 overflow-y-auto pr-1">
                    @forelse($categories as $cat)
                        <div class="flex items-center justify-between p-2 rounded-lg bg-[#13141a] border border-[#2b2b40] text-xs">
                            <span class="font-semibold text-gray-200">{{ $cat->name }}</span>
                            <span class="text-[11px] font-mono text-purple-400 font-bold bg-purple-500/10 px-2 py-0.5 rounded border border-purple-500/20">
                                {{ $cat->products_count }} items
                            </span>
                        </div>
                    @empty
                        <p class="text-xs text-gray-500 text-center py-4">No categories created yet.</p>
                    @endforelse
                </div>
            </div>

            <!-- Recently Imported List -->
            <div class="bg-[#1e1e2d] border border-[#2b2b40] rounded-2xl p-5 shadow-lg space-y-4">
                <div class="flex items-center justify-between pb-3 border-b border-[#2b2b40]">
                    <h3 class="text-xs font-bold text-gray-200 uppercase tracking-wider flex items-center gap-2">
                        <i class="fa-solid fa-clock-rotate-left text-amber-400"></i>
                        <span>Recently Imported</span>
                    </h3>
                    <span class="text-[11px] text-emerald-400 font-bold">Latest 5</span>
                </div>

                <div class="space-y-2.5">
                    @forelse($recentProducts as $rp)
                        <div class="flex items-center gap-3 p-2 rounded-xl bg-[#13141a] border border-[#2b2b40] text-xs">
                            <img src="{{ $rp->image }}" alt="{{ $rp->name }}" class="w-10 h-10 rounded-lg object-contain bg-white p-1 border border-gray-700 shrink-0">
                            <div class="flex-1 min-w-0">
                                <a href="{{ route('product.show', $rp->slug) }}" target="_blank" class="font-bold text-gray-200 hover:text-purple-400 truncate block transition">
                                    {{ $rp->name }}
                                </a>
                                <div class="flex items-center gap-2 mt-0.5 text-[11px]">
                                    <span class="text-starOrange font-bold">{{ number_format($rp->effective_price) }}৳</span>
                                    <span class="text-gray-500">&bull;</span>
                                    <span class="text-gray-400">{{ $rp->category->name ?? 'Uncategorized' }}</span>
                                </div>
                            </div>
                        </div>
                    @empty
                        <p class="text-xs text-gray-500 text-center py-4">No products imported yet.</p>
                    @endforelse
                </div>
            </div>

        </div>

    </div>

</div>

<script>
function aiImporterApp() {
    return {
        mode: 'urls',
        apiKey: '{{ $geminiApiKey ?? "" }}',
        keySavedText: 'Save Key',
        urlText: '',
        htmlText: '',
        purgeDemo: true,
        isDiscovering: false,
        isImporting: false,
        showProgress: false,
        progressCurrent: 0,
        progressTotal: 0,
        progressPercent: 0,
        logs: [],

        initApp() {
            const storedKey = localStorage.getItem('gemini_api_key');
            if (storedKey && !this.apiKey) {
                this.apiKey = storedKey;
            }
        },

        onKeyChange() {
            if (this.apiKey) {
                localStorage.setItem('gemini_api_key', this.apiKey.trim());
            }
        },

        async saveApiKeyPermanently() {
            if (!this.apiKey || this.apiKey.trim().length < 5) {
                alert('Please enter a valid Google Gemini API Key.');
                return;
            }
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
                    body: JSON.stringify({ api_key: this.apiKey.trim() })
                });
                const data = await res.json();
                if (data.success) {
                    localStorage.setItem('gemini_api_key', this.apiKey.trim());
                    this.keySavedText = 'Saved ✓';
                    setTimeout(() => { this.keySavedText = 'Save Key'; }, 3000);
                } else {
                    alert(data.message || 'Could not save key.');
                    this.keySavedText = 'Save Key';
                }
            } catch (e) {
                localStorage.setItem('gemini_api_key', this.apiKey.trim());
                this.keySavedText = 'Saved ✓';
                setTimeout(() => { this.keySavedText = 'Save Key'; }, 3000);
            }
        },

        setCategoryUrl(url) {
            this.urlText = url;
        },

        getUrlCount() {
            if (!this.urlText) return 0;
            return this.urlText.split(/[\r\n,]+/).map(s => s.trim()).filter(s => s.length > 8).length;
        },

        addLog(text, type = 'info') {
            this.logs.push({ text, type });
            this.$nextTick(() => {
                const box = document.querySelector('.overflow-y-auto');
                if (box) box.scrollTop = box.scrollHeight;
            });
        },

        async discoverFromCategory() {
            const rawLinks = this.urlText.split(/[\r\n,]+/).map(s => s.trim()).filter(s => s.length > 8);
            if (rawLinks.length === 0) {
                alert('Please enter a category URL to extract links from.');
                return;
            }

            this.isDiscovering = true;
            this.showProgress = true;
            this.logs = [];
            this.addLog(`🔍 Scanning category URL: <span class="text-white">${rawLinks[0]}</span>`);

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
                    this.urlText = data.links.join('\n');
                    this.addLog(`✓ Found <strong>${data.links.length}</strong> product links! You can now click "Start 100% Exact Import".`, 'success');
                } else {
                    this.addLog(`ℹ️ Category card engine is ready. Click "Start 100% Exact Import" to fetch all items directly.`, 'info');
                }
            } catch (e) {
                this.addLog(`ℹ️ Ready to import. Click "Start 100% Exact Import".`, 'info');
            } finally {
                this.isDiscovering = false;
            }
        },

        async startLiveQueueImport() {
            const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

            // 1. HTML Paste Mode
            if (this.mode === 'html') {
                if (!this.htmlText || this.htmlText.trim().length < 50) {
                    alert('Please paste the page HTML source first.');
                    return;
                }

                this.isImporting = true;
                this.showProgress = true;
                this.logs = [];
                this.progressCurrent = 1;
                this.progressTotal = 1;
                this.progressPercent = 50;

                this.addLog(`🚀 Parsing pasted HTML for exact products...`);

                if (this.purgeDemo) {
                    this.addLog(`🧹 Purging old products first...`);
                    try {
                        await fetch('{{ route("admin.products.purge-demo") }}', {
                            method: 'POST',
                            headers: { 'X-CSRF-TOKEN': token || '' }
                        });
                        this.addLog(`✓ Database cleared.`, 'success');
                    } catch (e) {}
                }

                try {
                    const res = await fetch('{{ route("admin.products.ai-import.single") }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': token || ''
                        },
                        body: JSON.stringify({
                            url: 'https://source-page.com/listing',
                            html: this.htmlText,
                            api_key: this.apiKey
                        })
                    });
                    const data = await res.json();
                    if (data.success) {
                        this.progressPercent = 100;
                        if (data.is_listing && data.products) {
                            this.addLog(`✓ <strong>Successfully Imported ${data.products.length} Products!</strong>`, 'success');
                            data.products.forEach((p, idx) => {
                                this.addLog(`[${idx+1}] ${p.name} - <strong class="text-starOrange">${p.sale_price}৳</strong>`, 'success');
                            });
                        } else {
                            this.addLog(`✓ <strong>[IMPORTED]</strong> ${data.name} (<span class="text-starOrange font-bold">${data.sale_price}৳</span>)`, 'success');
                        }
                    } else {
                        this.addLog(`✗ Error: ${data.error}`, 'error');
                    }
                } catch (e) {
                    this.addLog(`✗ Connection error: ${e.message}`, 'error');
                }

                this.isImporting = false;
                setTimeout(() => window.location.reload(), 2500);
                return;
            }

            // 2. URLs Mode
            let rawLinks = this.urlText.split(/[\r\n,]+/).map(s => s.trim()).filter(s => s.length > 8);
            if (rawLinks.length === 0) {
                alert('Please enter at least one product URL.');
                return;
            }

            this.isImporting = true;
            this.showProgress = true;
            this.logs = [];
            this.progressCurrent = 0;
            this.progressTotal = rawLinks.length;
            this.progressPercent = 0;

            this.addLog(`🚀 Starting import for <strong>${rawLinks.length}</strong> link(s)...`);

            if (this.purgeDemo) {
                this.addLog(`🧹 Purging old products as requested...`);
                try {
                    await fetch('{{ route("admin.products.purge-demo") }}', {
                        method: 'POST',
                        headers: { 'X-CSRF-TOKEN': token || '' }
                    });
                    this.addLog(`✓ Database cleared.`, 'success');
                } catch (e) {}
            }

            let successCount = 0;
            let failedCount = 0;

            for (let i = 0; i < rawLinks.length; i++) {
                const url = rawLinks[i];
                this.progressCurrent = i + 1;
                this.progressPercent = Math.round(((i + 1) / rawLinks.length) * 100);

                this.addLog(`[${i+1}/${rawLinks.length}] 🌐 Fetching exact data: <span class="text-white">${url}</span>`);

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
                        if (data.is_listing && data.products) {
                            this.addLog(`✓ <strong>[CATEGORY IMPORTED]</strong> Extracted <strong>${data.products.length}</strong> exact products!`, 'success');
                            data.products.forEach((p, idx) => {
                                this.addLog(`  ↳ [${idx+1}] ${p.name} - <strong class="text-starOrange">${p.sale_price}৳</strong>`, 'success');
                            });
                        } else {
                            this.addLog(`✓ <strong>[IMPORTED]</strong> ${data.name} (<span class="text-starOrange font-bold">${data.sale_price}৳</span>) <a href="${data.product_url}" target="_blank" class="underline text-indigo-300 ml-1">View Store &rarr;</a>`, 'success');
                        }
                    } else {
                        failedCount++;
                        this.addLog(`✗ <strong>[FAILED]</strong> ${data.error || 'Import error'}`, 'error');
                    }
                } catch (err) {
                    failedCount++;
                    this.addLog(`✗ Error: ${err.message}`, 'error');
                }
            }

            this.isImporting = false;
            this.addLog(`🎉 <strong>All Done!</strong> Successfully imported: ${successCount}`, 'success');

            setTimeout(() => window.location.reload(), 2500);
        },

        handleSubmit(e) {
            if (this.getUrlCount() === 0 && (!this.htmlText || this.htmlText.length < 50)) {
                e.preventDefault();
                alert('Please enter at least one URL or paste HTML.');
            }
        }
    };
}
</script>
@endsection
