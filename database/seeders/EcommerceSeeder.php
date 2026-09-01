<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\Review;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class EcommerceSeeder extends Seeder
{
    /**
     * Run the database seeds.
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
                'name' => 'John Doe',
                'password' => Hash::make('password123'),
            ]
        );
        if ($customerRole && method_exists($customer, 'assignRole')) {
            $customer->assignRole($customerRole);
        }

        // 2. High-Impact Categories
        $categories = [
            [
                'name' => 'Electronics & Gadgets',
                'slug' => 'electronics-gadgets',
                'description' => 'Next-generation computing, creative displays, and smart gadgets.',
                'image' => '/images/cat_tech_gadgets.jpg',
                'icon' => 'laptop',
            ],
            [
                'name' => 'Fashion & Apparel',
                'slug' => 'fashion-apparel',
                'description' => 'Minimalist urban techwear, sportswear, and luxury essentials.',
                'image' => '/images/cat_techwear_apparel.jpg',
                'icon' => 'shirt',
            ],
            [
                'name' => 'Smart Watches & Wearables',
                'slug' => 'smart-watches-wearables',
                'description' => 'Fitness trackers, luxury smartwatches, and smart biometric gear.',
                'image' => '/images/cat_smart_wearables.jpg',
                'icon' => 'watch',
            ],
            [
                'name' => 'Audio & Headphones',
                'slug' => 'audio-headphones',
                'description' => 'Studio quality headphones, spatial noise cancelling earbuds, and speakers.',
                'image' => '/images/cat_audio_studio.jpg',
                'icon' => 'headphones',
            ],
            [
                'name' => 'Home & Living',
                'slug' => 'home-living',
                'description' => 'Modern ergonomic furniture and minimalist decor.',
                'image' => '/images/cat_tech_gadgets.jpg',
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

        // Clean tables to prevent duplicate key conflicts
        \Illuminate\Support\Facades\Schema::disableForeignKeyConstraints();
        Review::truncate();
        ProductVariant::truncate();
        Product::truncate();
        \Illuminate\Support\Facades\Schema::enableForeignKeyConstraints();

        // 3. Products with High-End Studio Photography
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
                'image' => '/images/prod_headphones.jpg',
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
                'name' => 'Apex Pro Smartwatch AMOLED',
                'slug' => 'apex-pro-smartwatch-amoled',
                'short_description' => 'Ultra-bright AMOLED display, GPS tracking, and titanium bezel.',
                'description' => 'Engineered for athletes and pioneers. Includes precision dual-frequency GPS, biometric health tracking, sleep stage analysis, and up to 14 days of stamina battery life.',
                'price' => 199.00,
                'sale_price' => 169.00,
                'stock' => 22,
                'sku' => 'WCH-APX-009',
                'image' => '/images/prod_smartwatch.jpg',
                'is_featured' => true,
                'is_active' => true,
                'rating' => 4.9,
                'reviews_count' => 94,
                'variants' => [
                    ['name' => 'Titanium Grey 45mm', 'color' => '#475569', 'size' => '45mm', 'sku' => 'WCH-APX-45', 'price' => 169.00, 'stock' => 12],
                    ['name' => 'Stealth Black 49mm', 'color' => '#090d16', 'size' => '49mm', 'sku' => 'WCH-APX-49', 'price' => 189.00, 'stock' => 10],
                ],
            ],
            [
                'category_slug' => 'electronics-gadgets',
                'name' => 'UltraSlim 4K UHD Smart Monitor 27"',
                'slug' => 'ultraslim-4k-uhd-smart-monitor-27',
                'short_description' => 'Crisp 4K resolution, 144Hz refresh rate, and Type-C 90W charging.',
                'description' => 'A visual masterpiece for creators and engineers. With 99% DCI-P3 color accuracy, HDR1000 peak brightness, and integrated stereo speakers.',
                'price' => 449.00,
                'sale_price' => 399.00,
                'stock' => 14,
                'sku' => 'ELC-MON-4K',
                'image' => '/images/prod_monitor.jpg',
                'is_featured' => true,
                'is_active' => true,
                'rating' => 5.0,
                'reviews_count' => 48,
            ],
            [
                'category_slug' => 'fashion-apparel',
                'name' => 'Classic Leather Minimalist Backpack',
                'slug' => 'classic-leather-minimalist-backpack',
                'short_description' => 'Handcrafted full-grain leather backpack with padded laptop sleeve.',
                'description' => 'Engineered for sleek urban travel. Built with weather-resistant full-grain leather, magnetic quick-release clasps, and ergonomic air-mesh straps.',
                'price' => 149.00,
                'sale_price' => 129.00,
                'stock' => 30,
                'sku' => 'FSH-BAG-001',
                'image' => '/images/prod_backpack.jpg',
                'is_featured' => true,
                'is_active' => true,
                'rating' => 4.8,
                'reviews_count' => 34,
            ],
            [
                'category_slug' => 'audio-headphones',
                'name' => 'True Wireless Studio Earbuds ANC',
                'slug' => 'true-wireless-studio-earbuds-anc',
                'short_description' => 'Compact wireless earbuds with deep bass and crystal-clear microphone.',
                'description' => 'Pocket-sized sonic powerhouse. Features 36-hour combined battery, fast wireless charging case, touch controls, and IPX5 splash protection.',
                'price' => 89.00,
                'sale_price' => 69.00,
                'stock' => 60,
                'sku' => 'AUD-EBD-001',
                'image' => '/images/prod_earbuds.jpg',
                'is_featured' => true,
                'is_active' => true,
                'rating' => 4.7,
                'reviews_count' => 110,
            ],
            [
                'category_slug' => 'fashion-apparel',
                'name' => 'Premium Polarized Sunglasses UV400',
                'slug' => 'premium-polarized-sunglasses-uv400',
                'short_description' => 'Ultra-lightweight alloy frame with 100% UVA/UVB protection.',
                'description' => 'Timeless aesthetic meets aerospace alloy durability. High-clarity polarized lenses eliminate glare while maintaining accurate color rendition.',
                'price' => 99.00,
                'sale_price' => 79.00,
                'stock' => 40,
                'sku' => 'FSH-SGL-001',
                'image' => '/images/prod_sunglasses.jpg',
                'is_featured' => true,
                'is_active' => true,
                'rating' => 4.9,
                'reviews_count' => 54,
            ],
            [
                'category_slug' => 'smart-watches-wearables',
                'name' => 'Ultra Apex Fitness Smartwatch Series X',
                'slug' => 'ultra-apex-fitness-smartwatch-series-x',
                'short_description' => 'Always-on AMOLED display, ECG monitoring, and 50m water resistance.',
                'description' => 'Designed for extreme conditions and peak human performance. Features dual-frequency GPS, biometric body sensor matrix, and up to 18 days of battery stamina.',
                'price' => 399.00,
                'sale_price' => 349.00,
                'stock' => 18,
                'sku' => 'WCH-APX-010',
                'image' => '/images/prod_fitness_watch.jpg',
                'is_featured' => true,
                'is_active' => true,
                'rating' => 4.8,
                'reviews_count' => 86,
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
                'image' => '/images/prod_laptop.jpg',
                'is_featured' => true,
                'is_active' => true,
                'rating' => 5.0,
                'reviews_count' => 67,
                'variants' => [
                    ['name' => 'Space Black 512GB', 'color' => '#1e293b', 'size' => '512GB', 'sku' => 'LPT-CBP-512', 'price' => 2299.00, 'stock' => 6],
                    ['name' => 'Space Black 1TB', 'color' => '#1e293b', 'size' => '1TB', 'sku' => 'LPT-CBP-1TB', 'price' => 2599.00, 'stock' => 4],
                ],
            ],
        ];

        foreach ($products as $prodData) {
            $catSlug = $prodData['category_slug'];
            unset($prodData['category_slug']);
            $variants = $prodData['variants'] ?? [];
            unset($prodData['variants']);

            $prodData['category_id'] = $categoryModels[$catSlug]->id;

            $product = Product::updateOrCreate(
                ['sku' => $prodData['sku']],
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
    }
}