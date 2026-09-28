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
     * Run the database seeds for Gymshark Clothing & Activewear store.
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
            ['code' => 'WELCOME10'],
            [
                'type' => 'percentage',
                'value' => 10.00,
                'min_spend' => 0.00,
                'max_discount' => 500.00,
                'is_active' => true,
            ]
        );

        // Clean tables to purge old non-apparel data
        \Illuminate\Support\Facades\Schema::disableForeignKeyConstraints();
        Review::truncate();
        ProductVariant::truncate();
        Product::truncate();
        Category::truncate();
        Banner::truncate();
        \Illuminate\Support\Facades\Schema::enableForeignKeyConstraints();

        // 3. High-Impact Gymshark Banners
        Banner::create([
            'title' => 'CONDITIONING IS EVERYTHING',
            'subtitle' => 'Engineered seamless gymwear, heavyweight fleece pump covers, and squat-proof activewear designed for peak human performance.',
            'badge' => 'NEW 2026 DROP',
            'button_text' => 'SHOP WOMEN',
            'link' => '/shop?category=women',
            'image' => '/images/gymshark_hero_banner.jpg',
            'is_active' => true,
        ]);

        Banner::create([
            'title' => 'SEAMLESS 2.0 INNOVATION',
            'subtitle' => 'Precision jacquard knitwear with sweat-wicking DRY technology, zero-chafing ergonomic construction, and body-sculpting contour shading.',
            'badge' => 'FABRIC TECHNOLOGY',
            'button_text' => 'EXPLORE SEAMLESS',
            'link' => '/shop?category=seamless',
            'image' => '/images/gymshark_campaign_banner.jpg',
            'is_active' => true,
        ]);

        // 4. Gymshark Athletic Categories
        $categories = [
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

        // 5. Authentic Gymshark Apparel Catalog with Fabric & Sizing
        $products = [
            [
                'category_slug' => 'women',
                'name' => 'Vital Seamless 2.0 High-Waisted Leggings',
                'slug' => 'vital-seamless-2-high-waisted-leggings',
                'short_description' => 'Squat-proof, supportive ribbed waistband, 4-way contour stretch fabric.',
                'description' => 'The legend returns. Vital Seamless 2.0 is crafted from a high-performance 90% Nylon / 10% Elastane knit with sweat-wicking DRY technology. Features subtle glute contour shading, compressive high-rise waistband, and zero-chafing flatlock seams for limitless lifting sessions.',
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
                    ['name' => 'Washed Charcoal - XL', 'color' => '#27272a', 'size' => 'XL', 'sku' => 'GS-PWR-CHR-XL', 'price' => 54.00, 'stock' => 10],
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
                    ['name' => 'Navy Blue - XL', 'color' => '#1e3a8a', 'size' => 'XL', 'sku' => 'GS-ARV-NVY-XL', 'price' => 28.00, 'stock' => 15],
                ],
            ],
            [
                'category_slug' => 'women',
                'name' => 'Adapt Seamless Compression Sports Bra',
                'slug' => 'adapt-seamless-compression-sports-bra',
                'short_description' => 'Medium-to-high support, removable padding, breathable ribbed underband.',
                'description' => 'Train without distractions. Adapt Seamless Sports Bra delivers supportive compression with a stylish racerback design. Features heat-sealed branding, sweat-absorbing inner lining, and seamless knit construction.',
                'price' => 46.00,
                'sale_price' => 36.00,
                'stock' => 80,
                'sku' => 'GS-ADP-BRA-05',
                'image' => '/images/prod_sports_bra.jpg',
                'is_featured' => true,
                'is_active' => true,
                'rating' => 4.9,
                'reviews_count' => 165,
                'variants' => [
                    ['name' => 'Sage Green - XS', 'color' => '#84a98c', 'size' => 'XS', 'sku' => 'GS-ADP-SGE-XS', 'price' => 36.00, 'stock' => 20],
                    ['name' => 'Sage Green - S', 'color' => '#84a98c', 'size' => 'S', 'sku' => 'GS-ADP-SGE-S', 'price' => 36.00, 'stock' => 30],
                    ['name' => 'Sage Green - M', 'color' => '#84a98c', 'size' => 'M', 'sku' => 'GS-ADP-SGE-M', 'price' => 36.00, 'stock' => 20],
                    ['name' => 'Sage Green - L', 'color' => '#84a98c', 'size' => 'L', 'sku' => 'GS-ADP-SGE-L', 'price' => 36.00, 'stock' => 10],
                ],
            ],
            [
                'category_slug' => 'hoodies-sweats',
                'name' => 'Rest Day Heavyweight Fleece Joggers',
                'slug' => 'rest-day-heavyweight-fleece-joggers',
                'short_description' => 'Brushed cotton comfort, tailored tapered ankle cuff, deep side pockets.',
                'description' => 'Crafted for downtime recovery and gym commutes. Made with 380 GSM ultra-soft brushed fleece, relaxed thigh with tapered ankles, thick ribbed waistband, and custom metal-tipped drawcords.',
                'price' => 58.00,
                'sale_price' => 48.00,
                'stock' => 70,
                'sku' => 'GS-RST-JOG-06',
                'image' => '/images/prod_fleece_joggers.jpg',
                'is_featured' => true,
                'is_active' => true,
                'rating' => 4.9,
                'reviews_count' => 210,
                'variants' => [
                    ['name' => 'Charcoal Heather - S', 'color' => '#3f3f46', 'size' => 'S', 'sku' => 'GS-RST-CHR-S', 'price' => 48.00, 'stock' => 20],
                    ['name' => 'Charcoal Heather - M', 'color' => '#3f3f46', 'size' => 'M', 'sku' => 'GS-RST-CHR-M', 'price' => 48.00, 'stock' => 25],
                    ['name' => 'Charcoal Heather - L', 'color' => '#3f3f46', 'size' => 'L', 'sku' => 'GS-RST-CHR-L', 'price' => 48.00, 'stock' => 15],
                    ['name' => 'Charcoal Heather - XL', 'color' => '#3f3f46', 'size' => 'XL', 'sku' => 'GS-RST-CHR-XL', 'price' => 48.00, 'stock' => 10],
                ],
            ],
            [
                'category_slug' => 'seamless',
                'name' => 'Apex Seamless Long Sleeve Conditioning Top',
                'slug' => 'apex-seamless-long-sleeve-conditioning-top',
                'short_description' => 'Contour jacquard knit, integrated thumbholes, thermal temperature control.',
                'description' => 'Stay locked in through every set. Precision seamless engineering hugs the musculature while venting core body heat. Thumbhole cuffs keep sleeves perfectly placed during dynamic lifts.',
                'price' => 52.00,
                'sale_price' => 42.00,
                'stock' => 60,
                'sku' => 'GS-APX-LS-07',
                'image' => '/images/cat_seamless_tech.jpg',
                'is_featured' => true,
                'is_active' => true,
                'rating' => 4.9,
                'reviews_count' => 134,
                'variants' => [
                    ['name' => 'Carbon Grey - S', 'color' => '#27272a', 'size' => 'S', 'sku' => 'GS-APX-LS-S', 'price' => 42.00, 'stock' => 15],
                    ['name' => 'Carbon Grey - M', 'color' => '#27272a', 'size' => 'M', 'sku' => 'GS-APX-LS-M', 'price' => 42.00, 'stock' => 25],
                    ['name' => 'Carbon Grey - L', 'color' => '#27272a', 'size' => 'L', 'sku' => 'GS-APX-LS-L', 'price' => 42.00, 'stock' => 20],
                ],
            ],
            [
                'category_slug' => 'accessories',
                'name' => 'Everyday 35L Water-Resistant Gym Holdall Bag',
                'slug' => 'everyday-35l-water-resistant-gym-holdall-bag',
                'short_description' => 'Dedicated shoe tunnel, waterproof wet pocket, padded shoulder strap.',
                'description' => 'Everything you need for work and gym. 35L capacity with durable 600D ripstop polyester, ventilated compartment for lifting shoes, internal laptop sleeve, and water bottle holder.',
                'price' => 45.00,
                'sale_price' => 38.00,
                'stock' => 50,
                'sku' => 'GS-BAG-35L-08',
                'image' => '/images/prod_backpack.jpg',
                'is_featured' => true,
                'is_active' => true,
                'rating' => 4.8,
                'reviews_count' => 88,
                'variants' => [
                    ['name' => 'Stealth Black - 35L', 'color' => '#000000', 'size' => '35L', 'sku' => 'GS-BAG-BLK-35L', 'price' => 38.00, 'stock' => 50],
                ],
            ],
        ];

        foreach ($products as $prodData) {
            $category = $categoryModels[$prodData['category_slug']] ?? null;
            if (!$category) continue;

            $variants = $prodData['variants'] ?? [];
            unset($prodData['category_slug'], $prodData['variants']);

            $product = Product::create(
                array_merge($prodData, ['category_id' => $category->id])
            );

            // Create Variants
            foreach ($variants as $varData) {
                ProductVariant::create(
                    array_merge($varData, ['product_id' => $product->id])
                );
            }

            // Create Verified Customer Reviews
            $sampleReviews = [
                [
                    'user_name' => 'Samantha Vance',
                    'rating' => 5,
                    'title' => 'Best seamless leggings I have ever worn!',
                    'comment' => 'The fabric quality is unreal. 100% squat proof, does not roll down on the waist, and feels like a second skin during heavy deadlifts.',
                    'is_approved' => true,
                ],
                [
                    'user_name' => 'Marcus Brody',
                    'rating' => 5,
                    'title' => 'Unbelievable fit and fabric breathability',
                    'comment' => 'The taper and stretch on these is incredible. Wicks sweat instantly and hugs the chest and arms perfectly without feeling tight.',
                    'is_approved' => true,
                ],
                [
                    'user_name' => 'Jessica Lin',
                    'rating' => 5,
                    'title' => 'Heavyweight fleece quality is top tier',
                    'comment' => 'The material is so thick and comfortable. Perfect oversized drop shoulder fit for gym warmups and casual streetwear.',
                    'is_approved' => true,
                ],
            ];

            foreach ($sampleReviews as $rev) {
                Review::create([
                    'product_id' => $product->id,
                    'user_email' => 'alex.turner@example.com',
                    'user_name' => $rev['user_name'],
                    'rating' => $rev['rating'],
                    'title' => $rev['title'],
                    'comment' => $rev['comment'],
                    'is_approved' => true,
                ]);
            }
        }
    }
}