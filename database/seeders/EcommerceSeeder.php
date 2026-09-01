<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\Coupon;
use App\Models\Banner;
use App\Models\Review;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class EcommerceSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Roles & Permissions
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $managerRole = Role::firstOrCreate(['name' => 'manager']);
        $customerRole = Role::firstOrCreate(['name' => 'customer']);

        $adminUser = User::firstOrCreate(
            ['email' => 'admin@smecom.com'],
            [
                'name' => 'SM Admin',
                'password' => Hash::make('password'),
            ]
        );
        $adminUser->assignRole('admin');

        // 2. Categories
        $categories = [
            [
                'name' => 'Electronics & Gadgets',
                'slug' => 'electronics-gadgets',
                'description' => 'Latest electronics, mobile phones, audio devices, and smart tech.',
                'image' => 'https://images.unsplash.com/photo-1498049794561-7780e7231661?auto=format&fit=crop&w=600&q=80',
                'icon' => 'laptop',
            ],
            [
                'name' => 'Fashion & Apparel',
                'slug' => 'fashion-apparel',
                'description' => 'Trendy clothing, luxury footwear, and premium lifestyle apparel.',
                'image' => 'https://images.unsplash.com/photo-1445205170230-053b83016050?auto=format&fit=crop&w=600&q=80',
                'icon' => 'shirt',
            ],
            [
                'name' => 'Smart Watches & Wearables',
                'slug' => 'smart-watches-wearables',
                'description' => 'Fitness trackers, luxury smartwatches, and smart accessories.',
                'image' => 'https://images.unsplash.com/photo-1523275335684-37898b6baf30?auto=format&fit=crop&w=600&q=80',
                'icon' => 'watch',
            ],
            [
                'name' => 'Audio & Headphones',
                'slug' => 'audio-headphones',
                'description' => 'Studio quality headphones, noise cancelling earbuds, and bluetooth speakers.',
                'image' => 'https://images.unsplash.com/photo-1505740420928-5e560c06d30e?auto=format&fit=crop&w=600&q=80',
                'icon' => 'headphones',
            ],
            [
                'name' => 'Home & Living',
                'slug' => 'home-living',
                'description' => 'Modern furniture, minimalist decor, and home essentials.',
                'image' => 'https://images.unsplash.com/photo-1513694203232-719a280e022f?auto=format&fit=crop&w=600&q=80',
                'icon' => 'home',
            ],
        ];

        $categoryModels = [];
        foreach ($categories as $catData) {
            $categoryModels[$catData['slug']] = Category::updateOrCreate(
                ['slug' => $catData['slug']],
                $catData
            );
        }

        // 3. Products with Variants and Reviews
        $products = [
            [
                'category_slug' => 'audio-headphones',
                'name' => 'Pro Wireless Noise-Cancelling Headphones',
                'slug' => 'pro-wireless-noise-cancelling-headphones',
                'short_description' => 'Active Noise Cancellation, 40-hour battery life, and spatial audio.',
                'description' => 'Immerse yourself in pristine acoustic clarity with industry-leading Active Noise Cancellation. Features ultra-comfortable plush memory foam earcups, custom titanium drivers, and USB-C fast charging.',
                'price' => 299.99,
                'sale_price' => 249.99,
                'stock' => 35,
                'sku' => 'AUD-ANC-001',
                'image' => 'https://images.unsplash.com/photo-1505740420928-5e560c06d30e?auto=format&fit=crop&w=800&q=80',
                'is_featured' => true,
                'is_active' => true,
                'rating' => 4.9,
                'reviews_count' => 128,
                'variants' => [
                    ['name' => 'Midnight Black', 'color' => '#0f172a', 'size' => 'Standard', 'sku' => 'AUD-ANC-BLK', 'price' => 249.99, 'stock' => 20],
                    ['name' => 'Lunar Silver', 'color' => '#cbd5e1', 'size' => 'Standard', 'sku' => 'AUD-ANC-SLV', 'price' => 249.99, 'stock' => 15],
                ],
            ],
            [
                'category_slug' => 'smart-watches-wearables',
                'name' => 'Ultra Apex Fitness Smartwatch Series 9',
                'slug' => 'ultra-apex-fitness-smartwatch-series-9',
                'short_description' => 'Always-on AMOLED display, ECG monitoring, and 50m water resistance.',
                'description' => 'Engineered for athletes and pioneers. Includes precision dual-frequency GPS, biometric health tracking, sleep stage analysis, and up to 14 days of stamina battery life.',
                'price' => 399.00,
                'sale_price' => 349.00,
                'stock' => 22,
                'sku' => 'WCH-APX-009',
                'image' => 'https://images.unsplash.com/photo-1523275335684-37898b6baf30?auto=format&fit=crop&w=800&q=80',
                'is_featured' => true,
                'is_active' => true,
                'rating' => 4.8,
                'reviews_count' => 94,
                'variants' => [
                    ['name' => 'Titanium Grey 45mm', 'color' => '#475569', 'size' => '45mm', 'sku' => 'WCH-APX-45', 'price' => 349.00, 'stock' => 12],
                    ['name' => 'Stealth Black 49mm', 'color' => '#090d16', 'size' => '49mm', 'sku' => 'WCH-APX-49', 'price' => 379.00, 'stock' => 10],
                ],
            ],
            [
                'category_slug' => 'electronics-gadgets',
                'name' => 'CyberBook Pro 16 M3 Max Edition',
                'slug' => 'cyberbook-pro-16-m3-max-edition',
                'short_description' => '16.2-inch Liquid Retina XDR screen with 120Hz ProMotion and 36GB unified memory.',
                'description' => 'Breakthrough performance for creators and engineers. With phenomenal battery longevity and an astonishing array of ports.',
                'price' => 2499.00,
                'sale_price' => 2299.00,
                'stock' => 10,
                'sku' => 'LPT-CBP-16',
                'image' => 'https://images.unsplash.com/photo-1517336714731-489689fd1ca8?auto=format&fit=crop&w=800&q=80',
                'is_featured' => true,
                'is_active' => true,
                'rating' => 5.0,
                'reviews_count' => 67,
                'variants' => [
                    ['name' => 'Space Black 512GB', 'color' => '#1e293b', 'size' => '512GB', 'sku' => 'LPT-CBP-512', 'price' => 2299.00, 'stock' => 6],
                    ['name' => 'Space Black 1TB', 'color' => '#1e293b', 'size' => '1TB', 'sku' => 'LPT-CBP-1TB', 'price' => 2599.00, 'stock' => 4],
                ],
            ],
            [
                'category_slug' => 'fashion-apparel',
                'name' => 'Minimalist Urban Cyber Bomber Jacket',
                'slug' => 'minimalist-urban-cyber-bomber-jacket',
                'short_description' => 'Waterproof breathable fabric with magnetic snap pockets.',
                'description' => 'Designed for all-season city commuters. Crafted from recycled thermal tech fabrics that block cold winds while regulating core temperature.',
                'price' => 179.00,
                'sale_price' => 129.00,
                'stock' => 45,
                'sku' => 'FSH-JKT-004',
                'image' => 'https://images.unsplash.com/photo-1551028719-00167b16eac5?auto=format&fit=crop&w=800&q=80',
                'is_featured' => true,
                'is_active' => true,
                'rating' => 4.7,
                'reviews_count' => 52,
                'variants' => [
                    ['name' => 'Matte Obsidian - M', 'color' => '#0f172a', 'size' => 'M', 'sku' => 'FSH-JKT-M', 'price' => 129.00, 'stock' => 20],
                    ['name' => 'Matte Obsidian - L', 'color' => '#0f172a', 'size' => 'L', 'sku' => 'FSH-JKT-L', 'price' => 129.00, 'stock' => 25],
                ],
            ],
            [
                'category_slug' => 'audio-headphones',
                'name' => 'Spatial Studio ANC Earbuds Pro',
                'slug' => 'spatial-studio-anc-earbuds-pro',
                'short_description' => 'Wireless charging case with hi-res lossless audio codecs.',
                'description' => 'Experience crystal pure studio sound with transparency mode, 32-hour extended playback, and IPX7 sweat & rain water resistance.',
                'price' => 199.99,
                'sale_price' => 159.99,
                'stock' => 50,
                'sku' => 'AUD-EBD-002',
                'image' => 'https://images.unsplash.com/photo-1590658268037-6bf12165a8df?auto=format&fit=crop&w=800&q=80',
                'is_featured' => false,
                'is_active' => true,
                'rating' => 4.6,
                'reviews_count' => 88,
            ],
            [
                'category_slug' => 'home-living',
                'name' => 'Ergonomic Mesh Pro Executive Chair',
                'slug' => 'ergonomic-mesh-pro-executive-chair',
                'short_description' => 'Dynamic lumbar support, 4D adjustable armrests, and breathable mesh.',
                'description' => 'The ultimate companion for long work and gaming sessions. Built with aircraft-grade aluminum alloy and Italian elastomeric mesh.',
                'price' => 450.00,
                'sale_price' => 389.00,
                'stock' => 15,
                'sku' => 'HOM-CHR-001',
                'image' => 'https://images.unsplash.com/photo-1580481077195-350a8b9e69c7?auto=format&fit=crop&w=800&q=80',
                'is_featured' => false,
                'is_active' => true,
                'rating' => 4.9,
                'reviews_count' => 41,
            ],
            [
                'category_slug' => 'fashion-apparel',
                'name' => 'Italian Handcrafted Leather Sneakers',
                'slug' => 'italian-handcrafted-leather-sneakers',
                'short_description' => 'Full-grain calfskin leather with shock-absorbing vulcanized soles.',
                'description' => 'Effortless luxury for modern everyday wear. Hand-stitched in Tuscany with premium orthotic insoles.',
                'price' => 220.00,
                'sale_price' => null,
                'stock' => 28,
                'sku' => 'FSH-SHS-002',
                'image' => 'https://images.unsplash.com/photo-1549298916-b41d501d3772?auto=format&fit=crop&w=800&q=80',
                'is_featured' => false,
                'is_active' => true,
                'rating' => 4.8,
                'reviews_count' => 39,
            ],
            [
                'category_slug' => 'electronics-gadgets',
                'name' => '4K Ultra Cinema Smart Projector',
                'slug' => '4k-ultra-cinema-smart-projector',
                'short_description' => '2500 ANSI Lumens, HDR10+, Dolby Audio, and built-in Smart TV apps.',
                'description' => 'Turn any plain wall into an astonishing 150-inch 4K IMAX cinematic theater. Instant auto-focus, auto-keystone correction, and low latency.',
                'price' => 899.00,
                'sale_price' => 749.00,
                'stock' => 12,
                'sku' => 'ELC-PRJ-003',
                'image' => 'https://images.unsplash.com/photo-1535016120720-40c646be5580?auto=format&fit=crop&w=800&q=80',
                'is_featured' => true,
                'is_active' => true,
                'rating' => 4.9,
                'reviews_count' => 33,
            ],
        ];

        foreach ($products as $prodData) {
            $catSlug = $prodData['category_slug'];
            unset($prodData['category_slug']);
            $variants = $prodData['variants'] ?? [];
            unset($prodData['variants']);

            $prodData['category_id'] = $categoryModels[$catSlug]->id;

            $product = Product::updateOrCreate(
                ['slug' => $prodData['slug']],
                $prodData
            );

            // Create Variants
            foreach ($variants as $variantData) {
                $variantData['product_id'] = $product->id;
                ProductVariant::updateOrCreate(
                    ['sku' => $variantData['sku']],
                    $variantData
                );
            }

            // Create Sample Reviews
            Review::firstOrCreate(
                ['product_id' => $product->id, 'user_name' => 'Alex Rivera'],
                [
                    'user_email' => 'alex@example.com',
                    'rating' => 5,
                    'title' => 'Astonishing build quality and design!',
                    'comment' => 'The 3D view gave me an exact idea before ordering. Arrived super fast and exceeded all expectations.',
                    'is_approved' => true,
                ]
            );

            Review::firstOrCreate(
                ['product_id' => $product->id, 'user_name' => 'Samantha Vance'],
                [
                    'user_email' => 'sam@example.com',
                    'rating' => 5,
                    'title' => 'Worth every penny, highly recommended.',
                    'comment' => 'Clean finish, great sound and materials. Customer support was very helpful with tracking.',
                    'is_approved' => true,
                ]
            );
        }

        // 4. Seed Coupons
        Coupon::updateOrCreate(
            ['code' => 'SM20'],
            [
                'type' => 'percentage',
                'value' => 20.00,
                'min_spend' => 50.00,
                'max_discount' => 100.00,
                'expires_at' => now()->addMonths(6),
                'usage_limit' => 500,
                'used_count' => 12,
                'is_active' => true,
            ]
        );

        Coupon::updateOrCreate(
            ['code' => 'WELCOME10'],
            [
                'type' => 'percentage',
                'value' => 10.00,
                'min_spend' => 30.00,
                'max_discount' => 50.00,
                'expires_at' => now()->addYear(),
                'usage_limit' => 1000,
                'used_count' => 45,
                'is_active' => true,
            ]
        );

        Coupon::updateOrCreate(
            ['code' => 'FLASHSALE'],
            [
                'type' => 'fixed',
                'value' => 25.00,
                'min_spend' => 100.00,
                'expires_at' => now()->addDays(30),
                'usage_limit' => 200,
                'used_count' => 8,
                'is_active' => true,
            ]
        );

        // 5. Seed Banners
        Banner::updateOrCreate(
            ['title' => 'Next-Gen 3D Spatial Audio Gear'],
            [
                'subtitle' => 'Experience studio acoustics with adaptive noise cancellation.',
                'badge' => '⚡ 50% OFF FLASH SALE',
                'button_text' => 'Explore 3D Audio',
                'link' => '/shop?category=audio-headphones',
                'image' => 'https://images.unsplash.com/photo-1505740420928-5e560c06d30e?auto=format&fit=crop&w=800&q=80',
                'bg_gradient' => 'from-indigo-950 via-slate-900 to-violet-950',
                'is_active' => true,
            ]
        );
    }
}
