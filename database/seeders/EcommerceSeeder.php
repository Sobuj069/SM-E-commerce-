<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\Review;
use App\Models\User;
use App\Models\Coupon;
use App\Models\Banner;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class EcommerceSeeder extends Seeder
{
    /**
     * Run the database seeds for Multi-Category Store (Tech, Electronics, Gadgets & Fashion).
     */
    public function run(): void
    {
        // 1. Roles & Permissions setup
        $adminRole = null;
        $customerRole = null;

        if (class_exists(\Spatie\Permission\Models\Role::class)) {
            $adminRole = \Spatie\Permission\Models\Role::firstOrCreate(['name' => 'admin']);
            $customerRole = \Spatie\Permission\Models\Role::firstOrCreate(['name' => 'customer']);
        }

        // Admin User
        $admin = User::firstOrCreate(
            ['email' => 'admin@smcloudit.top'],
            [
                'name' => 'SM Admin',
                'password' => Hash::make('password123'),
            ]
        );
        if ($adminRole && method_exists($admin, 'assignRole')) {
            $admin->assignRole($adminRole);
        }

        // Demo Customer
        $customer = User::firstOrCreate(
            ['email' => 'customer@smcloudit.top'],
            [
                'name' => 'Alex Turner',
                'password' => Hash::make('password123'),
            ]
        );
        if ($customerRole && method_exists($customer, 'assignRole')) {
            $customer->assignRole($customerRole);
        }

        // 2. Dynamic Coupons Engine
        Coupon::updateOrCreate(
            ['code' => 'SM20'],
            [
                'type' => 'percentage',
                'value' => 20.00,
                'min_spend' => 0.00,
                'max_discount' => 1000.00,
                'is_active' => true,
            ]
        );

        Coupon::updateOrCreate(
            ['code' => 'TECH50'],
            [
                'type' => 'fixed',
                'value' => 50.00,
                'min_spend' => 300.00,
                'max_discount' => 50.00,
                'is_active' => true,
            ]
        );

        // Clean tables to purge old data
        \Illuminate\Support\Facades\Schema::disableForeignKeyConstraints();
        Review::truncate();
        ProductVariant::truncate();
        Product::truncate();
        Category::truncate();
        Banner::truncate();
        \Illuminate\Support\Facades\Schema::enableForeignKeyConstraints();

        // 3. Multi-Category Banners (Tech & Fashion)
        Banner::create([
            'title' => 'NEXT-GEN TECH & SMART DEVICES',
            'subtitle' => 'Unleash extreme performance. Flagship smartphones, M3 Max MacBooks, noise-cancelling audio & smartwatch tech.',
            'badge' => '⚡ 2026 FLAGSHIP TECH',
            'button_text' => 'SHOP TECH & GADGETS',
            'link' => '/shop?category=smartphones',
            'image' => 'https://images.unsplash.com/photo-1519389950473-47ba0277781c?w=1600&auto=format&fit=crop',
            'is_active' => true,
        ]);

        Banner::create([
            'title' => 'CONDITIONING & FASHION DROPS',
            'subtitle' => 'Engineered seamless activewear, heavyweight fleece pump covers, and squat-proof fitness wear for peak human performance.',
            'badge' => '🔥 FASHION & GYMWEAR',
            'button_text' => 'EXPLORE FASHION',
            'link' => '/shop?category=women',
            'image' => '/images/gymshark_hero_banner.jpg',
            'is_active' => true,
        ]);

        Banner::create([
            'title' => 'PRO LAPTOPS & WORKSTATIONS',
            'subtitle' => 'Extreme computing power. Apple Silicon MacBooks, OLED display laptops, and high-performance gaming rigs.',
            'badge' => '💻 ULTRA-FAST COMPUTING',
            'button_text' => 'EXPLORE LAPTOPS',
            'link' => '/shop?category=laptops-pc',
            'image' => 'https://images.unsplash.com/photo-1550745165-9bc0b252726f?w=1600&auto=format&fit=crop',
            'is_active' => true,
        ]);

        // 4. Multi-Category Taxonomy (Tech, Electronics, Gadgets + Fashion & Apparel)
        $categories = [
            // --- TECH & ELECTRONICS CATEGORIES ---
            [
                'name' => 'Mobile Phones & Tablets',
                'slug' => 'smartphones',
                'description' => 'Flagship smartphones, 5G devices, Apple iPhones, Samsung Galaxy, and Pro Tablets.',
                'image' => 'https://images.unsplash.com/photo-1511707171634-5f897ff02aa9?w=600',
                'icon' => 'mobile-screen-button',
                'is_active' => true,
            ],
            [
                'name' => 'Laptops & Computers',
                'slug' => 'laptops-pc',
                'description' => 'Apple MacBooks, high-performance gaming laptops, ultrabooks, and PC workstations.',
                'image' => 'https://images.unsplash.com/photo-1517336714731-489689fd1ca8?w=600',
                'icon' => 'laptop',
                'is_active' => true,
            ],
            [
                'name' => 'Smartwatches & Wearables',
                'slug' => 'smartwatches',
                'description' => 'Apple Watch Ultra, Galaxy smartwatches, fitness bands, and cellular wearables.',
                'image' => 'https://images.unsplash.com/photo-1508685096489-7aacd43bd3b1?w=600',
                'icon' => 'clock',
                'is_active' => true,
            ],
            [
                'name' => 'Audio, Headphones & Earbuds',
                'slug' => 'audio-gadgets',
                'description' => 'Active noise cancelling headphones, AirPods, wireless earbuds, and Bluetooth audio.',
                'image' => 'https://images.unsplash.com/photo-1505740420928-5e560c06d30e?w=600',
                'icon' => 'headphones',
                'is_active' => true,
            ],
            [
                'name' => 'Tech & Gaming Accessories',
                'slug' => 'tech-accessories',
                'description' => 'Mechanical keyboards, gaming mice, GaN fast chargers, and MagSafe power banks.',
                'image' => 'https://images.unsplash.com/photo-1587829741301-dc798b83add3?w=600',
                'icon' => 'gamepad',
                'is_active' => true,
            ],

            // --- FASHION & ACTIVEWEAR CATEGORIES ---
            [
                'name' => 'Women\'s Activewear',
                'slug' => 'women',
                'description' => 'High-waisted leggings, seamless sports bras, crop tops, and conditioning sets.',
                'image' => '/images/cat_women_apparel.jpg',
                'icon' => 'person-dress',
                'is_active' => true,
            ],
            [
                'name' => 'Men\'s Gymwear',
                'slug' => 'men',
                'description' => 'Physique-enhancing t-shirts, stringers, 5" workout shorts, and compression gear.',
                'image' => '/images/cat_men_gymwear.jpg',
                'icon' => 'person',
                'is_active' => true,
            ],
            [
                'name' => 'Seamless Collection',
                'slug' => 'seamless',
                'description' => 'Engineered knit technology, 4-way stretch fabric, and contour ventilation.',
                'image' => '/images/cat_seamless_tech.jpg',
                'icon' => 'layer-group',
                'is_active' => true,
            ],
            [
                'name' => 'Hoodies & Sweats',
                'slug' => 'hoodies-sweats',
                'description' => 'Heavyweight 420 GSM oversized hoodies, pump covers, and fleece joggers.',
                'image' => '/images/cat_hoodies_sweats.jpg',
                'icon' => 'shirt',
                'is_active' => true,
            ],
            [
                'name' => 'Accessories & Gear',
                'slug' => 'accessories',
                'description' => 'Gym duffles, lifting straps, crew socks, shaker bottles, and headwear.',
                'image' => '/images/prod_backpack.jpg',
                'icon' => 'bag-shopping',
                'is_active' => true,
            ],
        ];

        $categoryModels = [];
        foreach ($categories as $catData) {
            $categoryModels[$catData['slug']] = Category::create($catData);
        }

        // 5. High-Impact Tech & Fashion Catalog with Variants
        $products = [
            // ==================== TECH PRODUCTS ====================
            [
                'category_slug' => 'laptops-pc',
                'name' => 'Apple MacBook Pro 16" (M3 Max / 36GB RAM / 1TB SSD)',
                'slug' => 'apple-macbook-pro-16-m3-max',
                'short_description' => 'Liquid Retina XDR display, up to 22h battery life, Extreme M3 Max performance.',
                'description' => 'The ultimate pro laptop. Powered by Apple Silicon M3 Max with a 16-core CPU, 40-core GPU, and 36GB unified memory. Features a stunning 16.2-inch Liquid Retina XDR screen with ProMotion 120Hz, studio-quality 3-mic array, and 6-speaker sound system with Spatial Audio.',
                'price' => 3499.00,
                'sale_price' => 3299.00,
                'stock' => 25,
                'sku' => 'APL-MBP16-M3M',
                'image' => 'https://images.unsplash.com/photo-1517336714731-489689fd1ca8?w=800',
                'gallery_images' => [
                    'https://images.unsplash.com/photo-1611186871348-b1ce696e52c9?w=800',
                    'https://images.unsplash.com/photo-1541807084-5c52b6b3adef?w=800',
                ],
                'is_featured' => true,
                'is_active' => true,
                'rating' => 5.0,
                'reviews_count' => 142,
                'variants' => [
                    ['name' => 'Space Black - 512GB', 'color' => '#18181b', 'size' => '512GB', 'sku' => 'APL-MBP-BLK-512', 'price' => 2999.00, 'stock' => 10],
                    ['name' => 'Space Black - 1TB', 'color' => '#18181b', 'size' => '1TB', 'sku' => 'APL-MBP-BLK-1TB', 'price' => 3299.00, 'stock' => 15],
                    ['name' => 'Silver - 1TB', 'color' => '#e4e4e7', 'size' => '1TB', 'sku' => 'APL-MBP-SLV-1TB', 'price' => 3299.00, 'stock' => 8],
                ],
            ],
            [
                'category_slug' => 'smartphones',
                'name' => 'Apple iPhone 16 Pro Max (256GB / Grade 5 Titanium)',
                'slug' => 'apple-iphone-16-pro-max',
                'short_description' => '48MP Fusion Camera, A18 Pro chip, 6.9" Super Retina XDR with Promotion.',
                'description' => 'Forged in titanium. Features a larger 6.9-inch Super Retina XDR display with narrower borders, the groundbreaking A18 Pro chip, enhanced 4K 120 fps Dolby Vision recording, and dedicated Camera Control button for instant capture.',
                'price' => 1199.00,
                'sale_price' => 1099.00,
                'stock' => 45,
                'sku' => 'APL-IP16PM-256',
                'image' => 'https://images.unsplash.com/photo-1695048133142-1a20484d2569?w=800',
                'gallery_images' => [
                    'https://images.unsplash.com/photo-1592750475338-74b7b21085ab?w=800',
                ],
                'is_featured' => true,
                'is_active' => true,
                'rating' => 4.9,
                'reviews_count' => 320,
                'variants' => [
                    ['name' => 'Natural Titanium - 256GB', 'color' => '#a1a1aa', 'size' => '256GB', 'sku' => 'IP16PM-NAT-256', 'price' => 1099.00, 'stock' => 15],
                    ['name' => 'Desert Titanium - 256GB', 'color' => '#d4af37', 'size' => '256GB', 'sku' => 'IP16PM-DSR-256', 'price' => 1099.00, 'stock' => 15],
                    ['name' => 'Black Titanium - 512GB', 'color' => '#09090b', 'size' => '512GB', 'sku' => 'IP16PM-BLK-512', 'price' => 1299.00, 'stock' => 15],
                ],
            ],
            [
                'category_slug' => 'smartphones',
                'name' => 'Samsung Galaxy S24 Ultra 5G (Snapdragon 8 Gen 3 / S-Pen)',
                'slug' => 'samsung-galaxy-s24-ultra-5g',
                'short_description' => 'Galaxy AI built-in, 200MP Quad Telephoto Camera, Titanium Armor frame.',
                'description' => 'Welcome to the era of mobile AI. Circle to Search with Google, Live Translate on calls, and Photo Assist. Powered by Snapdragon 8 Gen 3 for Galaxy, vapor chamber cooling, flat 6.8-inch Dynamic AMOLED 2X 2600 nit display, and integrated S-Pen.',
                'price' => 1299.00,
                'sale_price' => 1149.00,
                'stock' => 35,
                'sku' => 'SAM-S24U-512',
                'image' => 'https://images.unsplash.com/photo-1610945265064-0e34e5519bbf?w=800',
                'is_featured' => true,
                'is_active' => true,
                'rating' => 4.9,
                'reviews_count' => 218,
                'variants' => [
                    ['name' => 'Titanium Gray - 256GB', 'color' => '#71717a', 'size' => '256GB', 'sku' => 'S24U-GRY-256', 'price' => 1149.00, 'stock' => 15],
                    ['name' => 'Titanium Black - 512GB', 'color' => '#18181b', 'size' => '512GB', 'sku' => 'S24U-BLK-512', 'price' => 1299.00, 'stock' => 20],
                ],
            ],
            [
                'category_slug' => 'laptops-pc',
                'name' => 'ASUS ROG Zephyrus G16 OLED Gaming Laptop (Intel Core Ultra 9 / RTX 4080)',
                'slug' => 'asus-rog-zephyrus-g16-gaming-laptop',
                'short_description' => '2.5K 240Hz ROG Nebula OLED, CNC Aluminum chassis, 32GB LPDDR5X.',
                'description' => 'Ultra-thin gaming supremacy. Precision CNC-milled aluminum unibody housing Intel Core Ultra 9 processor, NVIDIA GeForce RTX 4080 GPU, and ROG Nebula 2.5K 240Hz OLED HDR display. Only 1.49cm thin with Slash Lighting rear matrix.',
                'price' => 2399.00,
                'sale_price' => 2199.00,
                'stock' => 18,
                'sku' => 'ASUS-ROG-G16',
                'image' => 'https://images.unsplash.com/photo-1603302576837-37561b2e2302?w=800',
                'is_featured' => true,
                'is_active' => true,
                'rating' => 4.8,
                'reviews_count' => 96,
                'variants' => [
                    ['name' => 'Eclipse Gray - 32GB/1TB', 'color' => '#27272a', 'size' => '32GB / 1TB', 'sku' => 'ROG-G16-GRY', 'price' => 2199.00, 'stock' => 10],
                    ['name' => 'Platinum White - 32GB/2TB', 'color' => '#f4f4f5', 'size' => '32GB / 2TB', 'sku' => 'ROG-G16-WHT', 'price' => 2399.00, 'stock' => 8],
                ],
            ],
            [
                'category_slug' => 'audio-gadgets',
                'name' => 'Sony WH-1000XM5 Wireless Noise-Cancelling Headphones',
                'slug' => 'sony-wh-1000xm5-noise-cancelling-headphones',
                'short_description' => 'Industry-leading noise cancellation, Auto NC Optimizer, 30h battery life.',
                'description' => 'Two processors control 8 microphones for unprecedented active noise cancellation and crystal-clear hands-free calling. Ultra-comfortable soft fit leather, 30-hour battery life with quick 3-minute charging for 3 hours playback.',
                'price' => 399.00,
                'sale_price' => 329.00,
                'stock' => 60,
                'sku' => 'SNY-WH1000XM5',
                'image' => 'https://images.unsplash.com/photo-1505740420928-5e560c06d30e?w=800',
                'is_featured' => true,
                'is_active' => true,
                'rating' => 4.9,
                'reviews_count' => 520,
                'variants' => [
                    ['name' => 'Black', 'color' => '#09090b', 'size' => 'Standard', 'sku' => 'XM5-BLK', 'price' => 329.00, 'stock' => 30],
                    ['name' => 'Silver', 'color' => '#e4e4e7', 'size' => 'Standard', 'sku' => 'XM5-SLV', 'price' => 329.00, 'stock' => 20],
                    ['name' => 'Midnight Blue', 'color' => '#1e3a8a', 'size' => 'Standard', 'sku' => 'XM5-BLU', 'price' => 329.00, 'stock' => 10],
                ],
            ],
            [
                'category_slug' => 'smartwatches',
                'name' => 'Apple Watch Ultra 2 (49mm Titanium / GPS + Cellular)',
                'slug' => 'apple-watch-ultra-2-titanium',
                'short_description' => '3000 nits Always-On Retina, Dual-frequency GPS, 36h normal / 72h low power.',
                'description' => 'The most rugged and capable Apple Watch. Built for endurance, outdoor adventure, and water sports with a 49mm aerospace-grade titanium case, customizable Action Button, depth gauge to 40m, and precision dual-frequency GPS.',
                'price' => 799.00,
                'sale_price' => 749.00,
                'stock' => 30,
                'sku' => 'APL-WCH-ULT2',
                'image' => 'https://images.unsplash.com/photo-1508685096489-7aacd43bd3b1?w=800',
                'is_featured' => true,
                'is_active' => true,
                'rating' => 4.9,
                'reviews_count' => 184,
                'variants' => [
                    ['name' => 'Orange Ocean Band', 'color' => '#ea580c', 'size' => '49mm', 'sku' => 'ULT2-OCN-ORG', 'price' => 749.00, 'stock' => 15],
                    ['name' => 'Black Trail Loop', 'color' => '#18181b', 'size' => '49mm', 'sku' => 'ULT2-TRL-BLK', 'price' => 749.00, 'stock' => 15],
                ],
            ],
            [
                'category_slug' => 'tech-accessories',
                'name' => 'Keychron Q1 Pro Wireless Custom Mechanical Keyboard',
                'slug' => 'keychron-q1-pro-wireless-keyboard',
                'short_description' => 'Full CNC Aluminum body, QMK/VIA programmable, Hot-swappable switches.',
                'description' => 'A ground-breaking all-metal wireless custom mechanical keyboard. Supports Bluetooth 5.1 & Type-C wired, South-facing RGB backlighting, double-gasket design for acoustic comfort, and Mac/Windows switchable layout.',
                'price' => 198.00,
                'sale_price' => 168.00,
                'stock' => 40,
                'sku' => 'KEY-Q1-PRO',
                'image' => 'https://images.unsplash.com/photo-1587829741301-dc798b83add3?w=800',
                'is_featured' => true,
                'is_active' => true,
                'rating' => 4.8,
                'reviews_count' => 112,
                'variants' => [
                    ['name' => 'Carbon Black - Red Switch', 'color' => '#18181b', 'size' => 'Red Switch', 'sku' => 'Q1-BLK-RED', 'price' => 168.00, 'stock' => 20],
                    ['name' => 'Silver Grey - Brown Switch', 'color' => '#71717a', 'size' => 'Brown Switch', 'sku' => 'Q1-SLV-BRN', 'price' => 168.00, 'stock' => 20],
                ],
            ],

            // ==================== FASHION PRODUCTS ====================
            [
                'category_slug' => 'women',
                'name' => 'Vital Seamless 2.0 High-Waisted Leggings',
                'slug' => 'vital-seamless-2-high-waisted-leggings',
                'short_description' => 'Squat-proof, supportive ribbed waistband, 4-way contour stretch fabric.',
                'description' => 'The legend returns. Vital Seamless 2.0 is crafted from a high-performance 90% Nylon / 10% Elastane knit with sweat-wicking DRY technology. Features subtle glute contour shading, compressive high-rise waistband, and zero-chafing flatlock seams.',
                'price' => 54.00,
                'sale_price' => 44.00,
                'stock' => 120,
                'sku' => 'GS-VIT-LEG-01',
                'image' => '/images/prod_vital_leggings.jpg',
                'is_featured' => true,
                'is_active' => true,
                'rating' => 4.9,
                'reviews_count' => 384,
                'variants' => [
                    ['name' => 'Black Marl - S', 'color' => '#18181b', 'size' => 'S', 'sku' => 'GS-VIT-BLK-S', 'price' => 44.00, 'stock' => 30],
                    ['name' => 'Black Marl - M', 'color' => '#18181b', 'size' => 'M', 'sku' => 'GS-VIT-BLK-M', 'price' => 44.00, 'stock' => 40],
                    ['name' => 'Black Marl - L', 'color' => '#18181b', 'size' => 'L', 'sku' => 'GS-VIT-BLK-L', 'price' => 44.00, 'stock' => 30],
                    ['name' => 'Black Marl - XL', 'color' => '#18181b', 'size' => 'XL', 'sku' => 'GS-VIT-BLK-XL', 'price' => 44.00, 'stock' => 20],
                ],
            ],
            [
                'category_slug' => 'men',
                'name' => 'Apex Seamless Athletic Workout T-Shirt',
                'slug' => 'apex-seamless-athletic-workout-t-shirt',
                'short_description' => 'Jacquard ventilation maps, muscle-enhancing slim fit, anti-odor technology.',
                'description' => 'Engineered for intense conditioning. Apex Seamless features targeted body-mapped ventilation zones on the chest and back to release heat. Lightweight 85% Nylon / 15% Polyester knit with 4-way elasticity gives total freedom of movement.',
                'price' => 48.00,
                'sale_price' => 38.00,
                'stock' => 95,
                'sku' => 'GS-APX-TEE-02',
                'image' => '/images/prod_apex_tee.jpg',
                'is_featured' => true,
                'is_active' => true,
                'rating' => 4.9,
                'reviews_count' => 248,
                'variants' => [
                    ['name' => 'Onyx Black - S', 'color' => '#09090b', 'size' => 'S', 'sku' => 'GS-APX-BLK-S', 'price' => 38.00, 'stock' => 25],
                    ['name' => 'Onyx Black - M', 'color' => '#09090b', 'size' => 'M', 'sku' => 'GS-APX-BLK-M', 'price' => 38.00, 'stock' => 35],
                    ['name' => 'Onyx Black - L', 'color' => '#09090b', 'size' => 'L', 'sku' => 'GS-APX-BLK-L', 'price' => 38.00, 'stock' => 20],
                    ['name' => 'Onyx Black - XL', 'color' => '#09090b', 'size' => 'XL', 'sku' => 'GS-APX-BLK-XL', 'price' => 38.00, 'stock' => 15],
                ],
            ],
            [
                'category_slug' => 'hoodies-sweats',
                'name' => 'Power Heavyweight Oversized Fleece Hoodie',
                'slug' => 'power-heavyweight-oversized-fleece-hoodie',
                'short_description' => '420 GSM French Terry cotton, dropped shoulders, relaxed pump-cover silhouette.',
                'description' => 'The ultimate gym pump cover. Built from premium 420 GSM 100% heavyweight cotton with a soft fleece-brushed interior. Features a double-lined hood, ribbed cuffs, and a deep kangaroo pouch to keep you focused during warmups and rest days.',
                'price' => 64.00,
                'sale_price' => 54.00,
                'stock' => 75,
                'sku' => 'GS-PWR-HD-03',
                'image' => '/images/prod_oversized_hoodie.jpg',
                'is_featured' => true,
                'is_active' => true,
                'rating' => 4.9,
                'reviews_count' => 412,
                'variants' => [
                    ['name' => 'Washed Charcoal - S', 'color' => '#27272a', 'size' => 'S', 'sku' => 'GS-PWR-CHR-S', 'price' => 54.00, 'stock' => 15],
                    ['name' => 'Washed Charcoal - M', 'color' => '#27272a', 'size' => 'M', 'sku' => 'GS-PWR-CHR-M', 'price' => 54.00, 'stock' => 30],
                    ['name' => 'Washed Charcoal - L', 'color' => '#27272a', 'size' => 'L', 'sku' => 'GS-PWR-CHR-L', 'price' => 54.00, 'stock' => 20],
                ],
            ],
            [
                'category_slug' => 'men',
                'name' => 'Arrival 5" Lightweight Gym Shorts',
                'slug' => 'arrival-5-lightweight-gym-shorts',
                'short_description' => 'Split hem mobility, zippered secure pockets, sweat-wicking lightweight fabric.',
                'description' => 'Built for squats, sprints, and HIIT. Featuring a modern 5-inch inseam, breathable woven mechanical stretch fabric, internal drawstring, and secure zipper pockets to hold your essentials without bouncing.',
                'price' => 34.00,
                'sale_price' => 28.00,
                'stock' => 110,
                'sku' => 'GS-ARV-SHT-04',
                'image' => '/images/prod_arrival_shorts.jpg',
                'is_featured' => true,
                'is_active' => true,
                'rating' => 4.8,
                'reviews_count' => 192,
                'variants' => [
                    ['name' => 'Navy Blue - S', 'color' => '#1e3a8a', 'size' => 'S', 'sku' => 'GS-ARV-NVY-S', 'price' => 28.00, 'stock' => 30],
                    ['name' => 'Navy Blue - M', 'color' => '#1e3a8a', 'size' => 'M', 'sku' => 'GS-ARV-NVY-M', 'price' => 28.00, 'stock' => 40],
                    ['name' => 'Navy Blue - L', 'color' => '#1e3a8a', 'size' => 'L', 'sku' => 'GS-ARV-NVY-L', 'price' => 28.00, 'stock' => 25],
                ],
            ],
            [
                'category_slug' => 'accessories',
                'name' => 'Everyday Tactical Gym Duffle Backpack (35L)',
                'slug' => 'everyday-tactical-gym-duffle-backpack-35l',
                'short_description' => 'Waterproof ripstop fabric, dedicated vented shoe compartment, laptop sleeve.',
                'description' => 'The only bag you will need from work to the squat rack. Features heavy-duty water-resistant Cordura construction, padded 16-inch laptop pocket, wet towel/shoe compartment, and ergonomic shoulder straps.',
                'price' => 68.00,
                'sale_price' => 58.00,
                'stock' => 85,
                'sku' => 'GS-EVR-BAG-07',
                'image' => '/images/prod_backpack.jpg',
                'is_featured' => true,
                'is_active' => true,
                'rating' => 4.9,
                'reviews_count' => 156,
                'variants' => [
                    ['name' => 'Stealth Black - 35L', 'color' => '#09090b', 'size' => '35L', 'sku' => 'GS-BAG-BLK-35L', 'price' => 58.00, 'stock' => 50],
                ],
            ],
        ];

        foreach ($products as $prodData) {
            $catSlug = $prodData['category_slug'];
            $variants = $prodData['variants'] ?? [];
            unset($prodData['category_slug'], $prodData['variants']);

            $prodData['category_id'] = $categoryModels[$catSlug]->id ?? 1;
            $product = Product::create($prodData);

            // Create Variants
            foreach ($variants as $v) {
                $product->variants()->create($v);
            }

            // Create Genuine Customer Reviews
            Review::create([
                'product_id' => $product->id,
                'user_id' => $customer->id,
                'customer_name' => 'Sarah Jenkins',
                'rating' => 5,
                'title' => 'Exceptional Quality & Super Fast Delivery!',
                'comment' => 'Arrived in 2 days. The quality, feel, and performance exceed all expectations. Will definitely order again from SM Shop!',
                'is_verified_purchase' => true,
                'is_approved' => true,
                'created_at' => now()->subDays(rand(2, 20)),
            ]);

            Review::create([
                'product_id' => $product->id,
                'user_id' => $customer->id,
                'customer_name' => 'David Miller',
                'rating' => 5,
                'title' => 'Top-tier performance & authentic build!',
                'comment' => 'One of the best purchases I have made this year. High quality materials, looks even better in person.',
                'is_verified_purchase' => true,
                'is_approved' => true,
                'created_at' => now()->subDays(rand(1, 15)),
            ]);
        }
    }
}