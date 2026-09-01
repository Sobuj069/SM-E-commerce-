<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Category;
use App\Models\Product;

class EcommerceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
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

        $products = [
            [
                'category_slug' => 'audio-headphones',
                'name' => 'Pro Wireless Noise-Cancelling Headphones',
                'slug' => 'pro-wireless-noise-cancelling-headphones',
                'short_description' => 'Immersive acoustic experience with adaptive noise cancellation and 40-hour battery life.',
                'description' => 'Engineered for exceptional clarity and deep bass, these wireless headphones feature next-generation active noise cancellation, ambient listening modes, plush memory foam earcups, and ultra-fast USB-C charging.',
                'price' => 299.99,
                'sale_price' => 249.99,
                'stock' => 35,
                'sku' => 'AUD-001',
                'image' => 'https://images.unsplash.com/photo-1505740420928-5e560c06d30e?auto=format&fit=crop&w=800&q=80',
                'is_featured' => true,
                'rating' => 4.90,
                'reviews_count' => 128,
            ],
            [
                'category_slug' => 'smart-watches-wearables',
                'name' => 'Apex Pro Smartwatch AMOLED',
                'slug' => 'apex-pro-smartwatch-amoled',
                'short_description' => 'Ultra-bright AMOLED display, GPS tracking, and comprehensive health monitoring.',
                'description' => 'Stay connected and track your wellness with real-time heart rate, SpO2, sleep tracking, and over 100 sports modes. Water resistant up to 50 meters with titanium casing.',
                'price' => 199.00,
                'sale_price' => 169.00,
                'stock' => 50,
                'sku' => 'WCH-002',
                'image' => 'https://images.unsplash.com/photo-1523275335684-37898b6baf30?auto=format&fit=crop&w=800&q=80',
                'is_featured' => true,
                'rating' => 4.85,
                'reviews_count' => 94,
            ],
            [
                'category_slug' => 'electronics-gadgets',
                'name' => 'UltraSlim 4K UHD Smart Monitor 27"',
                'slug' => 'ultraslim-4k-uhd-smart-monitor-27',
                'short_description' => 'Crisp 4K resolution, 144Hz refresh rate, and Type-C 90W Power Delivery.',
                'description' => 'A productivity powerhouse with IPS panel, 99% sRGB color accuracy, ultra-thin bezels, and versatile ergonomic stand. Perfect for creators, developers, and entertainment.',
                'price' => 449.00,
                'sale_price' => 399.00,
                'stock' => 20,
                'sku' => 'ELC-003',
                'image' => 'https://images.unsplash.com/photo-1527443224154-c4a3942d3acf?auto=format&fit=crop&w=800&q=80',
                'is_featured' => true,
                'rating' => 4.95,
                'reviews_count' => 67,
            ],
            [
                'category_slug' => 'fashion-apparel',
                'name' => 'Classic Leather Minimalist Backpack',
                'slug' => 'classic-leather-minimalist-backpack',
                'short_description' => 'Handcrafted full-grain leather backpack with padded 16" laptop sleeve.',
                'description' => 'Designed for daily commuters and modern travelers. Features weather-resistant brass hardware, breathable back padding, and dedicated organizational compartments.',
                'price' => 149.00,
                'sale_price' => 129.00,
                'stock' => 42,
                'sku' => 'FSH-004',
                'image' => 'https://images.unsplash.com/photo-1553062407-98eeb64c6a62?auto=format&fit=crop&w=800&q=80',
                'is_featured' => true,
                'rating' => 4.80,
                'reviews_count' => 82,
            ],
            [
                'category_slug' => 'electronics-gadgets',
                'name' => 'Ergonomic Mechanical Wireless Keyboard',
                'slug' => 'ergonomic-mechanical-wireless-keyboard',
                'short_description' => 'Custom hot-swappable switches, RGB backlight, and multi-device Bluetooth 5.2.',
                'description' => 'Enhance your typing experience with tactile mechanical switches, PBT double-shot keycaps, aluminum frame, and multi-OS seamless switching.',
                'price' => 119.00,
                'sale_price' => null,
                'stock' => 60,
                'sku' => 'ELC-005',
                'image' => 'https://images.unsplash.com/photo-1587829741301-dc798b83add3?auto=format&fit=crop&w=800&q=80',
                'is_featured' => false,
                'rating' => 4.75,
                'reviews_count' => 45,
            ],
            [
                'category_slug' => 'audio-headphones',
                'name' => 'True Wireless Studio Earbuds ANC',
                'slug' => 'true-wireless-studio-earbuds-anc',
                'short_description' => 'Compact wireless earbuds with deep bass and crystal-clear microphone.',
                'description' => 'IPX7 water resistance, touch controls, transparency mode, wireless charging case, and up to 32 hours total playtime.',
                'price' => 89.00,
                'sale_price' => 69.00,
                'stock' => 80,
                'sku' => 'AUD-006',
                'image' => 'https://images.unsplash.com/photo-1590658268037-6bf12165a8df?auto=format&fit=crop&w=800&q=80',
                'is_featured' => true,
                'rating' => 4.70,
                'reviews_count' => 110,
            ],
            [
                'category_slug' => 'home-living',
                'name' => 'Nordic Minimalist Desk Lamp',
                'slug' => 'nordic-minimalist-desk-lamp',
                'short_description' => 'Dimmable warm LED lighting with touch sensor and wireless phone charger base.',
                'description' => 'Sleek matte finish, flexible gooseneck, 3 color temperatures (warm, natural, white), integrated 15W Qi fast charging pad.',
                'price' => 65.00,
                'sale_price' => 49.00,
                'stock' => 25,
                'sku' => 'HOM-007',
                'image' => 'https://images.unsplash.com/photo-1507473885765-e6ed057f782c?auto=format&fit=crop&w=800&q=80',
                'is_featured' => false,
                'rating' => 4.65,
                'reviews_count' => 38,
            ],
            [
                'category_slug' => 'fashion-apparel',
                'name' => 'Premium Polarized Sunglasses UV400',
                'slug' => 'premium-polarized-sunglasses-uv400',
                'short_description' => 'Ultra-lightweight alloy frame with 100% UVA/UVB protection.',
                'description' => 'Timeless unisex silhouette featuring anti-glare scratch-resistant polarized lenses and durable spring hinges.',
                'price' => 79.00,
                'sale_price' => null,
                'stock' => 40,
                'sku' => 'FSH-008',
                'image' => 'https://images.unsplash.com/photo-1572635196237-14b3f281503f?auto=format&fit=crop&w=800&q=80',
                'is_featured' => true,
                'rating' => 4.88,
                'reviews_count' => 54,
            ],
        ];

        foreach ($products as $item) {
            $catSlug = $item['category_slug'];
            unset($item['category_slug']);
            $item['category_id'] = $categoryModels[$catSlug]->id ?? null;

            Product::updateOrCreate(
                ['slug' => $item['slug']],
                $item
            );
        }
    }
}
