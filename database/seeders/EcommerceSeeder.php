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
     * Run the database seeds for SM Shop Computer, Laptop & Gadget Store.
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
                'name' => 'SM Shop Admin',
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
                'name' => 'Tariqul Islam',
                'password' => Hash::make('password123'),
            ]
        );
        if ($customerRole && method_exists($customer, 'assignRole')) {
            $customer->assignRole($customerRole);
        }

        // 2. Dynamic Coupons Engine
        Coupon::updateOrCreate(
            ['code' => 'STAR1000'],
            [
                'type' => 'fixed',
                'value' => 1000.00,
                'min_spend' => 15000.00,
                'max_discount' => 1000.00,
                'is_active' => true,
            ]
        );

        Coupon::updateOrCreate(
            ['code' => 'OFFER5'],
            [
                'type' => 'percentage',
                'value' => 5.00,
                'min_spend' => 5000.00,
                'max_discount' => 5000.00,
                'is_active' => true,
            ]
        );

        // Ensure image columns are TEXT to prevent 1406 Data too long errors
        try {
            \Illuminate\Support\Facades\DB::statement('ALTER TABLE banners MODIFY COLUMN image TEXT NULL');
        } catch (\Throwable $e) {}
        try {
            \Illuminate\Support\Facades\DB::statement('ALTER TABLE products MODIFY COLUMN image TEXT NULL');
        } catch (\Throwable $e) {}
        try {
            \Illuminate\Support\Facades\DB::statement('ALTER TABLE categories MODIFY COLUMN image TEXT NULL');
        } catch (\Throwable $e) {}
        try {
            \Illuminate\Support\Facades\DB::statement('ALTER TABLE product_variants MODIFY COLUMN image TEXT NULL');
        } catch (\Throwable $e) {}

        // Clean tables to purge old data
        \Illuminate\Support\Facades\Schema::disableForeignKeyConstraints();
        Review::truncate();
        ProductVariant::truncate();
        Product::truncate();
        Category::truncate();
        Banner::truncate();
        \Illuminate\Support\Facades\Schema::enableForeignKeyConstraints();

        // 3. Star Tech Banners
        Banner::create([
            'title' => 'লেনোভো -এর AMD প্রসেসর যুক্ত ল্যাপটপ কিনলেই ধামাকা অফার!',
            'subtitle' => 'নির্দিষ্ট ল্যাপটপ কিনলেই পেয়ে যাচ্ছেন স্মার্টওয়াচ অথবা এয়ারবাডস একদম ফ্রি!',
            'badge' => 'SPECIAL CAMPAIGN',
            'button_text' => 'ল্যাপটপ দেখুন',
            'link' => '/shop?category=laptop',
            'image' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuBY_v7fCmV2a4JUN-bYKu9Fct_TOgh-cTNdcR3jMOUMKCQbRPkmtv1GzEcqZ0N25w8E0AUF1k7fQlOJ8MRSEMYq-LI9YN__3lNvZDkpRThsBW5Iymvlb26duyA4GimSgxzmCloRmeoO6aqm6dmz7mdVGFhPiX2Rv7f1yV8nUvNHMZa2Fv044sX6zFB0p2kL1lXLE5QBCsDISuJMr0ed9yPQj3Xf72J5CBeHLtPmiNUPFwvHU43eA4Qdag',
            'is_active' => true,
        ]);

        // 4. Primary Star Tech Categories
        $categories = [
            ['name' => 'Desktop', 'slug' => 'desktop', 'description' => 'Brand PC, Custom Gaming PC, All-in-One PC, Portable Mini PC.', 'icon' => 'desktop', 'is_active' => true],
            ['name' => 'Laptop', 'slug' => 'laptop', 'description' => 'Gaming Laptops, Ultrabooks, MacBooks, Core i5, Ryzen Laptops.', 'icon' => 'laptop', 'is_active' => true],
            ['name' => 'Component', 'slug' => 'component', 'description' => 'Processors, Motherboards, Graphics Cards, RAM, SSD, Power Supply.', 'icon' => 'microchip', 'is_active' => true],
            ['name' => 'Monitor', 'slug' => 'monitor', 'description' => '4K Monitors, Fast IPS Gaming Monitors, Curved Displays, Smart Screens.', 'icon' => 'display', 'is_active' => true],
            ['name' => 'Power', 'slug' => 'power', 'description' => 'Portable Power Stations, UPS, Inverters, Solar Generators.', 'icon' => 'car-battery', 'is_active' => true],
            ['name' => 'Phone', 'slug' => 'phone', 'description' => 'Smartphones, Feature Phones, iPhones, Samsung Galaxy, Pixel.', 'icon' => 'mobile-screen-button', 'is_active' => true],
            ['name' => 'Tablet', 'slug' => 'tablet', 'description' => 'Apple iPad, Android Tablets, Graphic Drawing Tablets.', 'icon' => 'tablet-screen-button', 'is_active' => true],
            ['name' => 'Office Equipment', 'slug' => 'office-equipment', 'description' => 'Printers, Projectors, Money Counters, Photocopiers, Attendance Machines.', 'icon' => 'print', 'is_active' => true],
            ['name' => 'Camera', 'slug' => 'camera', 'description' => 'DSLR Cameras, Action Cameras, Drones, Gimbals, Tripods.', 'icon' => 'camera', 'is_active' => true],
            ['name' => 'Security', 'slug' => 'security', 'description' => 'CCTV Cameras, WiFi IP Cameras, DVR/NVR, Access Control.', 'icon' => 'shield-halved', 'is_active' => true],
            ['name' => 'Networking', 'slug' => 'networking', 'description' => 'WiFi 6 Routers, Switches, Access Points, Network Cables.', 'icon' => 'network-wired', 'is_active' => true],
            ['name' => 'Software', 'slug' => 'software', 'description' => 'Windows OS, Antivirus, Office Suite, Creative Software.', 'icon' => 'compact-disc', 'is_active' => true],
            ['name' => 'Server & Storage', 'slug' => 'server-storage', 'description' => 'Rack Servers, NAS Storage, Enterprise Hard Drives.', 'icon' => 'server', 'is_active' => true],
            ['name' => 'Accessories', 'slug' => 'accessories', 'description' => 'Keyboards, Mice, Cables, Converters, Laptop Bags, USB Hubs.', 'icon' => 'keyboard', 'is_active' => true],
            ['name' => 'Gadget', 'slug' => 'gadget', 'description' => 'Smart Watches, TWS Earbuds, Power Banks, Health Monitors.', 'icon' => 'headphones-simple', 'is_active' => true],
            ['name' => 'Gaming', 'slug' => 'gaming', 'description' => 'PlayStation 5, Xbox, Gaming Chairs, RGB Peripherals.', 'icon' => 'gamepad', 'is_active' => true],
            ['name' => 'TV', 'slug' => 'tv', 'description' => '4K Google TV, HQLED Smart TV, Android LED Televisions.', 'icon' => 'tv', 'is_active' => true],
            ['name' => 'Appliance', 'slug' => 'appliance', 'description' => 'Air Conditioners, Robot Vacuums, Air Fryers, Geysers.', 'icon' => 'wind', 'is_active' => true],
        ];

        $categoryModels = [];
        foreach ($categories as $catData) {
            $categoryModels[$catData['slug']] = Category::create($catData);
        }

        // 5. Exact 20 Star Tech Products from Official Showcase
        $products = [
            [
                'category_slug' => 'desktop',
                'name' => 'AMD Ryzen 3 3200G Budget Desktop PC With Monitor',
                'slug' => 'amd-ryzen-3-3200g-budget-desktop-pc-with-monitor',
                'short_description' => 'AMD Ryzen 3 3200G, A320M Motherboard, 8GB DDR4 RAM, 256GB NVMe SSD, 19" HD LED Monitor.',
                'description' => 'The ultimate budget desktop package for home, office, and freelancing. Equipped with AMD Ryzen 3 3200G with Radeon Vega 8 Graphics, 8GB 3200MHz RAM, lightning-fast 256GB NVMe M.2 SSD, and a crisp 19-inch LED monitor with 3 years warranty.',
                'price' => 38049.00,
                'sale_price' => 33999.00,
                'stock' => 50,
                'sku' => 'ST-DSK-3200G',
                'image' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuAzb8kmkRILY3SisZrHIZPV0bl3OHrYmfv46hj-dfPetmjaN8iLnnsIOugQPPP8AYK94E9Djgj6aoY8cJdhurIi9yH0hCqQMJvg9Yr4Aqj3a9Ajf4ADUzKap7S-6uKcaZu7eW91UUq_9jP2rZBXhOlXJB-1uPeDpvykKIgOUSSq5HAxEV3fbmis8oHRr7WmvIEYmAfmstZwc6CpwaMqzx2GtUGwMGmveuWiidwr--_0UB2NEsajQmm6Vg',
                'is_featured' => true,
                'is_active' => true,
                'rating' => 4.9,
                'reviews_count' => 128,
            ],
            [
                'category_slug' => 'desktop',
                'name' => 'AMD Ryzen 5 3400G Processor Gaming Desktop PC',
                'slug' => 'amd-ryzen-5-3400g-processor-gaming-desktop-pc',
                'short_description' => 'AMD Ryzen 5 3400G 4-Core 8-Thread, B450 Motherboard, 16GB RAM, 512GB SSD, RGB Gaming Casing.',
                'description' => 'Smooth esports gaming performance on a budget. Featuring AMD Ryzen 5 3400G with Radeon RX Vega 11 Graphics, 16GB Dual-Channel High Speed RAM, 512GB SSD, and an acrylic tempered glass gaming casing with 4x ARGB fans.',
                'price' => 35000.00,
                'sale_price' => 29999.00,
                'stock' => 40,
                'sku' => 'ST-DSK-3400G',
                'image' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuC4vMfOl_e8cv9epkYCfJlUBODlyW9dXeTaKHl7QMCAndIWkgnToejwh5heFUIBc2uE-bdbc2VGnqItp73j8-fSwIOj3w508AJMBz2-Zx55vJfWG55FeJvk_uN0RdNmXN5FGE30q3joTni6gprXM_GeyegfCPN4rcVqXKcD6cVPVW3wd_xe7xl6SbDSh83JvipY3VckKeWTQ06gokpmUjUSAWRx2_chYLxpdGY9WDNpNMc5b5l6xgsPsA',
                'is_featured' => true,
                'is_active' => true,
                'rating' => 4.8,
                'reviews_count' => 96,
            ],
            [
                'category_slug' => 'desktop',
                'name' => 'Intel Core i7 14700 14th Gen Gaming Desktop PC',
                'slug' => 'intel-core-i7-14700-14th-gen-gaming-desktop-pc',
                'short_description' => 'Intel Core i7-14700 20 Cores 28 Threads, RTX 4070 Super 12GB, 32GB DDR5, 1TB Gen4 SSD, 360mm Liquid Cooler.',
                'description' => 'Extreme beast for 4K gaming and heavy 3D rendering / video editing. Features Intel 14th Gen Core i7 14700 processor, NVIDIA GeForce RTX 4070 Super 12GB GDDR6X, 32GB DDR5 6000MHz RGB RAM, and 360mm ARGB Liquid Cooling.',
                'price' => 185399.00,
                'sale_price' => 170000.00,
                'stock' => 25,
                'sku' => 'ST-DSK-I7-14700',
                'image' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuBLzmb3oyNy40TWPEMAmNI3xgihe2_aBhYppW6dNKitZ05IHxxhg6lUK7sh6au_cJVQw7pR_mPNeCFjVD3W81ghXRijFgcifn-2_eTHniT65ZuZV1xM9GwayEOvL4pWhVWlzPc8BFRRJE4TQsYcahSVvGNfHa5hzSJr5QhMi0qi5GEOkd0-rpJTsnmkCwwxYjzSkWgg4KhXmazfrfvBVvQfih3ncxhS1P_QPkW2uR7bCxZqcpdTf9wNXA',
                'is_featured' => true,
                'is_active' => true,
                'rating' => 5.0,
                'reviews_count' => 74,
            ],
            [
                'category_slug' => 'gadget',
                'name' => 'Omron HEM-7121J Digital Blood Pressure Monitor',
                'slug' => 'omron-hem-7121j-digital-blood-pressure-monitor',
                'short_description' => 'IntelliSense Technology, One-Touch Operation, Hypertension Indicator, Memory Function.',
                'description' => 'Japan Quality Omron digital blood pressure monitor. Accurate and effortless measurement with IntelliSense technology that applies the right amount of pressure for fast, accurate and comfortable monitoring.',
                'price' => 4175.00,
                'sale_price' => 3410.00,
                'stock' => 80,
                'sku' => 'ST-OMR-7121J',
                'image' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuCIYs-1Otr7A7s4Aim8vCP7ebOtBMzhVzYbdMk_xFoKvAd7ZVfer1xCTa8zMaFCIDBAGQfhro3QsCv7C_3hgXqn7rxFeR-idW2Cu0Gvn0EdnXbrLuRvyI0S3NZLU2s3NDPPEEy1y3QnJeWxcm3Hz9EVyF18Qpsm-zxEMVKYmJ7v6WGH32b4_pzHdgM33yaCelFZqpbWiktaMF_tiUUlLxbaN8Fq5004l4yd0DQqIDfqDwrcT4Z7N7vELQ',
                'is_featured' => true,
                'is_active' => true,
                'rating' => 4.9,
                'reviews_count' => 210,
            ],
            [
                'category_slug' => 'tv',
                'name' => 'Haier 43P7 PRO 43" 4K HQLED Smart Google TV',
                'slug' => 'haier-43p7-pro-43-4k-hqled-smart-google-tv',
                'short_description' => '4K UHD 3840x2160, HQLED Display, Dolby Vision & Atmos, Google TV OS, Hands-free Voice.',
                'description' => 'Immerse in breathtaking cinematic quality. Haier 43P7 PRO features quantum dot HQLED panel with wide color gamut, MEMC motion clarity, Dolby Audio + Dolby Atmos, built-in Google Assistant, and Chromecast.',
                'price' => 61900.00,
                'sale_price' => 45900.00,
                'stock' => 30,
                'sku' => 'ST-HAI-43P7',
                'image' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuDhJI9zhIaLIBJMqX1jw9Mw--HMFwKTvjf2CwGHXvrQ2U32EfV4DHpwH3ENnPhnvhgqus6X6eDgpJaX4YJAUuBFxB4upwGKUS4HR2DEXb18bgLOo0G9C9fL8N03C7Hs3orlzOlCeh-w8rsLHXbRju0wcnsX9jvVCziwdL84WyHdx8_S2gSSCKu-c1dwIY2VA5cfWH-OaYBcmcDJFFSCET9USA0apMeMoJS3kI75cP8caJvoPL5ANoWBKw',
                'is_featured' => true,
                'is_active' => true,
                'rating' => 4.8,
                'reviews_count' => 62,
            ],
            [
                'category_slug' => 'power',
                'name' => 'Anker SOLIX C1000 Gen 2 2000W Portable Power Station',
                'slug' => 'anker-solix-c1000-gen-2-portable-power-station',
                'short_description' => '1056Wh Capacity, 2000W AC Output, SurgePad 2400W, HyperFlash 58-min Full Recharge, LiFePO4.',
                'description' => 'Reliable power everywhere. Built with ultra-durable LiFePO4 batteries lasting 3,000+ cycles (10 years), 100% full recharge in just 58 minutes, 11 versatile ports, and smart app control.',
                'price' => 82500.00,
                'sale_price' => 82500.00,
                'stock' => 15,
                'sku' => 'ST-ANK-SOLIX-C1000',
                'image' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuDFWuKzj04tgjGqD9_9gjB7DL1KgZYHwhvGxPipA1IZaroCDArAx7CtX7mLylqZyErwRzfmsek1yhb5kFj2C7yGCgZFe3CRk9jQ_8jwNdEQdr7kQpU7-ZbQy_RRmt0w9Ksug-qBH8iuoShst9QE8X9sr0GVE3ihOUrGy3zc6PwHoMnLXDzHInxGPnsqEHoWUIvCwLrb2ZrfXFP_xR3H_KYYiKMjDqEuiTcW45RYPRr9DXuUv4MR1T_Udg',
                'is_featured' => true,
                'is_active' => true,
                'rating' => 5.0,
                'reviews_count' => 45,
            ],
            [
                'category_slug' => 'power',
                'name' => 'Hithium HeroEE MaxPower 8 AIO 5kW Portable Power Station',
                'slug' => 'hithium-heroee-maxpower-8-aio-portable-power-station',
                'short_description' => '5120Wh Giant Capacity, 5000W Continuous Output, Solar MPPT Input, Industrial Grade Backup.',
                'description' => 'Massive backup power station designed for homes, data centers, outdoor shoots, and severe power outages. Delivers pure sine wave 5kW continuous power to run air conditioners, fridges, PCs and heavy appliances.',
                'price' => 275000.00,
                'sale_price' => 254000.00,
                'stock' => 10,
                'sku' => 'ST-HIT-HEROEE-8',
                'image' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuBcNK575PjB_S4keMaPCeCtdHJEqgf7VfTLL4CCeN3OawLTmLyItdgzfPqRJjvkZgMkE2tiA9RTqUntXz14gQtRg8DMOxGIwZwx-cEyAS2Ov6x7occXm7aC0K0f7bDke1p4otSPOCUV6wv7ezCHX5fZo_iLESmhQAN3VNEvoitxYLoblDp4IncPnWMwOY0UPKyoVtnEZ4H9v_twgSQuEwuiFf-oWPLcQf55bOZhMG3waOFvpLhg3cy6RQ',
                'is_featured' => true,
                'is_active' => true,
                'rating' => 4.9,
                'reviews_count' => 18,
            ],
            [
                'category_slug' => 'appliance',
                'name' => 'Pigeon PG352/00 8L Air Fryer',
                'slug' => 'pigeon-pg352-00-8l-air-fryer',
                'short_description' => '8L XL Family Capacity, 360° Rapid Air Circulation, Touch Screen Presets, Non-Stick Basket.',
                'description' => 'Enjoy 90% less oil crispy cooking for the whole family. Features digital LED touch panel, 8 versatile presets, temperature range from 80°C to 200°C, and auto shut-off safety protection.',
                'price' => 12500.00,
                'sale_price' => 9490.00,
                'stock' => 60,
                'sku' => 'ST-PIG-PG352',
                'image' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuCWfL4qyYCIKkDmAK_ko1hAWyHZbAZ8AQnXZy5LVQEt8ZL1zQZTYsvIFa_HahYQasb3w-3M0zFtolJADcjSz9aIQw_Eu15K3iSD3CFyGX1PLZnRhEWkKXimRQoo87RvtOsxRphyod1IYhQrM88oo-lXdpsZcX6yCzSYIo1Ld-5iJrEkmRdaMFxkVtxu2Wyow6vQGlcCkiGXYtK62usn8KDcLxNvP2dQdiUP93oTTkKE5M2osctma1hRJQ',
                'is_featured' => true,
                'is_active' => true,
                'rating' => 4.7,
                'reviews_count' => 84,
            ],
            [
                'category_slug' => 'desktop',
                'name' => 'MSI BZ09 Core i5-14400 DDR4 Mini Tower Brand PC',
                'slug' => 'msi-bz09-core-i5-14400-ddr4-mini-tower-brand-pc',
                'short_description' => 'Intel Core i5-14400 10-Core CPU, 16GB DDR4 RAM, 512GB NVMe SSD, WiFi 6 & Bluetooth, MSI Quality.',
                'description' => 'Compact and powerful corporate & home brand desktop by MSI. Features Intel 14th Gen Core i5-14400, military-grade components, silent cooling design, and 3-year official manufacturer warranty.',
                'price' => 68000.00,
                'sale_price' => 65500.00,
                'stock' => 35,
                'sku' => 'ST-MSI-BZ09-I5',
                'image' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuDDoqhLV2pYkYbYoCBvFVolJ7-4bE4-1aeXsq2g1dNpXFjMJ5zydGWSbmMDoOdFsV5KK5P2aHYTdVUgv4x5FZ2DER62ObjCVZI34yRKCAYSla0vjw5L91kOGfVl6KPRkIMRYGHbUo3v9SvdTiQO0m1bc1IWuDIka0e0ayHisSVYby4P3jDUPN54mbJYitkfLQaYrrFYu322sDnDGrkLv_pie6QRW5L1q3zTCGUeZgN8ra_TxpkrMHVW0A',
                'is_featured' => true,
                'is_active' => true,
                'rating' => 4.9,
                'reviews_count' => 52,
            ],
            [
                'category_slug' => 'monitor',
                'name' => 'AOC 25G4K 24.5" 420Hz FHD Fast IPS Gaming Monitor',
                'slug' => 'aoc-25g4k-24-5-420hz-fhd-fast-ips-gaming-monitor',
                'short_description' => '420Hz Ultra High Refresh Rate, 0.5ms MPRT, Fast IPS Panel, HDR10, G-Sync Compatible, Height Adjustable.',
                'description' => 'Built for competitive esports champions. Unmatched 420Hz refresh rate delivers silky smooth frames, with 0.5ms response time, 99% sRGB color gamut, and ergonomic pivot/height adjustable stand.',
                'price' => 32500.00,
                'sale_price' => 27999.00,
                'stock' => 40,
                'sku' => 'ST-AOC-25G4K',
                'image' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuCslp4Nhn1HFFyG12shypD6y9w2yKodlk--3JXA8nSOyjhFXprQVzbrAN5xy3kYFUSOYCdpoA9RB0HQzZmf-kfVdMxkIju6qyrQqcRYT1_J3l4PEuuMC5QGKZGosWHE8QfMgBwe6-6tbjqFKrOdo4zN_OrI-HoyabWKv4z-ieT_DP3BCBclw7P06OBQVNh9RtgguRUnaq2SJOWbJgksOUNSNO1jbW4oqFzLgbiEBDRSe_kWBly1fpsTRw',
                'is_featured' => true,
                'is_active' => true,
                'rating' => 5.0,
                'reviews_count' => 114,
            ],
            [
                'category_slug' => 'monitor',
                'name' => 'MSI Modern MD272UPSW 27" 60Hz 4K UHD Smart Monitor',
                'slug' => 'msi-modern-md272upsw-27-4k-uhd-smart-monitor',
                'short_description' => '27-inch 4K UHD 3840x2160 IPS, Type-C 65W Power Delivery, Smart Built-in OS, KVM Switch, White Aesthetic.',
                'description' => 'Stunning 4K resolution with sleek pearl white minimalist design. Includes Type-C single cable connection with 65W power delivery for laptops, built-in dual speakers, and EyesErgo eye-care technology.',
                'price' => 69100.00,
                'sale_price' => 60999.00,
                'stock' => 20,
                'sku' => 'ST-MSI-MD272',
                'image' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuBZXw5aU4TiRuwMZ1YN6AzQtlh7WsN-FlcsdZJCItBhwDmHv2oJpyFkxsn9bJvE-fxaA4ohHxl8rrZRx5QvTwpn5TbNJZiuz1T09tIq86BhVcb91EXKdlER2VTBHxFL-up_TdeBE24rtgQZNiYJR2i1X9TUGjBWa-kYwnRp3mZOhI5cQFm1Cj0IlQ9VZS3yhgT_DnNDPM3doHunBq-B4b0bii6i_lBS3hUAf9_alOEiHsWPKL-PzlQ0OA',
                'is_featured' => true,
                'is_active' => true,
                'rating' => 4.8,
                'reviews_count' => 43,
            ],
            [
                'category_slug' => 'appliance',
                'name' => 'Xiaomi H40 Robot Vacuum Cleaner',
                'slug' => 'xiaomi-h40-robot-vacuum-cleaner',
                'short_description' => '6000Pa Cyclone Suction, LDS Laser Navigation 360°, 2-in-1 Vacuum & Mopping, Smart App Control.',
                'description' => 'Autonomous whole-home deep cleaning. High-speed carpet boost, multi-floor mapping, obstacle avoidance sensors, and 5200mAh long-lasting battery with automatic recharge and resume.',
                'price' => 59500.00,
                'sale_price' => 46410.00,
                'stock' => 25,
                'sku' => 'ST-XIA-H40-VAC',
                'image' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuDNPieyGJqo8WPlcprW2sQC7EhudxmRHUfOx6Xs5noWlplC5Kn1KI5A7jlLfuBp9iH3Wc9wUT56_uGMj5yK7BdFgQRQxLaUBVJ3OaT7Sf-s6xWX2fWNDLCB_zyl-XNJ4xZWv_wDrcdHrvtNGKvjitoIziVFmYXSqd4dAp89M4byAItkxs_-yrsbfiLLMYnT9TPZcBNBBSfwc1gCZe6yuDboXvbT20K7ApnxvOtCls7XV-Q9DGdAH2v69Q',
                'is_featured' => true,
                'is_active' => true,
                'rating' => 4.9,
                'reviews_count' => 38,
            ],
            [
                'category_slug' => 'laptop',
                'name' => 'MSI Cyborg 15 Black Edition A13UC Core i5 13th Gen RTX 3050 15.6" FHD Laptop',
                'slug' => 'msi-cyborg-15-black-edition-a13uc-core-i5-rtx-3050-laptop',
                'short_description' => 'Core i5-13420H, RTX 3050 6GB GDDR6, 16GB DDR5 RAM, 512GB NVMe Gen4 SSD, 144Hz IPS Display.',
                'description' => 'Futuristic translucent mechanical styling meets Intel 13th Gen processing power and dedicated Ray-Tracing graphics. Perfect for gaming, programming, and university coursework.',
                'price' => 124000.00,
                'sale_price' => 124000.00,
                'stock' => 20,
                'sku' => 'ST-MSI-CYBORG-15',
                'image' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuDwwhe7B_CFLnyBk7P63X_7NwvAWKHG_w7UpXBQtx0QPYLhNTEM1W9g_c5L5Nz9g2wvWi9HvWPMf4IfVIKfQtQaPADP2smnX5NfbzuuE9ALlNQSnQcFPMwGpCXPE-DhIaa7XM5bu62dk-Tm-CZqePS2P2NH72zS4Abuk5f-2XhmPenqjJjxcktE1zWsCmnoqmCZaAdhV9ihnd1hkJF5tftB1cJB1c80aukoavLgk6-KLjze_j9aCMMt9A',
                'is_featured' => true,
                'is_active' => true,
                'rating' => 4.9,
                'reviews_count' => 77,
            ],
            [
                'category_slug' => 'laptop',
                'name' => 'Lenovo IdeaPad 1 15AMN7 Ryzen 5 7520U 15.6" FHD Laptop',
                'slug' => 'lenovo-ideapad-1-15amn7-ryzen-5-7520u-laptop',
                'short_description' => 'AMD Ryzen 5 7520U, 8GB LPDDR5 RAM, 512GB NVMe SSD, 15.6" Anti-Glare FHD, Cloud Grey Slim.',
                'description' => 'Ultra-slim lightweight laptop with all-day battery life. Features AMD Ryzen 7000 Series processor, Dolby Audio stereo speakers, privacy shutter HD webcam, and fast charging support.',
                'price' => 86000.00,
                'sale_price' => 81000.00,
                'stock' => 30,
                'sku' => 'ST-LEN-IP1-15AMN7',
                'image' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuAitVDX7vmieZ1oSaB3E3zvqf5vZi3fecjczSjQLvU5rj_Ya5QInCVbq_eEsK-BhQDYVRh31icVdTo1_M_q4YrLwc-tlz_sPTri4DoHvmGcFonM3LG8dP0o2e24nCS691BVvAJBkvokqzkX1aWLkgZnUhQZSViqzGHhjqudzr0kwirsGKwTQB-a1uNs1H3USRPuUHXHRD76zR6DHVBRufwPohDQeEDS2XO3cTaY2p6q-7SAIOq0elX5Ag',
                'is_featured' => true,
                'is_active' => true,
                'rating' => 4.8,
                'reviews_count' => 95,
            ],
            [
                'category_slug' => 'laptop',
                'name' => 'MSI Stealth A16 AI+ A3XWJG Ryzen AI 9 HX 370 RTX 5090 24GB Graphics 16" QHD+ OLED',
                'slug' => 'msi-stealth-a16-ai-plus-ryzen-ai-9-rtx-5090-oled-laptop',
                'short_description' => 'AMD Ryzen AI 9 HX 370 (50 TOPS NPU), RTX 5090 24GB, 64GB DDR5, 2TB Gen5 SSD, 240Hz OLED.',
                'description' => 'The most advanced AI gaming ultrabook in existence. Magnesium-aluminum unibody chassis, cutting-edge 50 TOPS AI processing, next-gen RTX 5090 flagship graphics, 240Hz OLED panel, and 99.9Wh max airplane-legal battery.',
                'price' => 670000.00,
                'sale_price' => 660000.00,
                'stock' => 5,
                'sku' => 'ST-MSI-STEALTH-A16',
                'image' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuDOMN1sqamHvT9eMscbstYAtbJ4EodDDnBk8_DPL6Hoq9HEZVBPGgzEYHSh67v0wRq0XLQb4dUMmdRf96tmVd_GfcoNL6oLafeFy9zWc31gIDvXYWQJt5kYEHzmn_ZnIEzFUBF12SGDFTIXyKhsHKfx067CY1ftm-gWjy7GuOE2LPli21yvILzDMk-GvyEH6EzFGbt1rCJqdbWz8xcdGp_L0OSZ8795Dmp6N8RU9UivA3CPAJgLQ04xmA',
                'is_featured' => true,
                'is_active' => true,
                'rating' => 5.0,
                'reviews_count' => 12,
            ],
            [
                'category_slug' => 'office-equipment',
                'name' => 'Optoma X400LVe XGA 4000 Lumens Professional Projector',
                'slug' => 'optoma-x400lve-xga-4000-lumens-projector',
                'short_description' => '4000 ANSI Lumens, 25,000:1 Contrast Ratio, 15,000h Lamp Life, HDMI & VGA, Built-in 10W Speaker.',
                'description' => 'Crystal-clear bright presentations even in daylight conference rooms and classrooms. Delivers vibrant sRGB colors, crisp text reproduction, and flexible ceiling or table installation.',
                'price' => 41000.00,
                'sale_price' => 36000.00,
                'stock' => 20,
                'sku' => 'ST-OPT-X400LVE',
                'image' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuARVYloj6rlp0-4O1wmRzNchVIpIwl24x3C1RBs5w7M055vQwnN-KrrExceDyQ_MnM0Z8MN4UZxO3z6b93toHCd5AJJ2p3-p_0ci6XiJAQdeiMCtnJeWZLSjLjWBxQhqV3DOH9QSdWd9wurbQlWDCElyf4XUFy6_4Vy-VHkEAHDZ3B2695qNfSa780pc1_yKnmcAdwZP-U6NgrFGRU_IOOxcDKsUMddcReA5_NgUXk3bIenNJGHqza8wg',
                'is_featured' => true,
                'is_active' => true,
                'rating' => 4.8,
                'reviews_count' => 34,
            ],
            [
                'category_slug' => 'camera',
                'name' => 'DJI Mini 5 Pro Fly More Combo Plus With RC2',
                'slug' => 'dji-mini-5-pro-fly-more-combo-plus-rc2',
                'short_description' => '4K 120fps HDR Video, Omnidirectional Obstacle Sensing, 45-min Flight Time, DJI RC2 Screen Remote.',
                'description' => 'Under 249g ultra-compact powerhouse drone. Features 1-inch CMOS sensor, true vertical shooting for social reels, 20km O4 video transmission, and 3x intelligent flight batteries in the Fly More Combo.',
                'price' => 140000.00,
                'sale_price' => 115000.00,
                'stock' => 15,
                'sku' => 'ST-DJI-MINI-5PRO',
                'image' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuDTyXCL8hmVj9n84pcd8HqXG8Toe-sRFCT4Pbey2-S0BbabVORS6U6mgkxNJHCNO6L9ubVsfeeKsxCgw90hJe3cgicCtfkAF126Zg8c3qhe0EJgaCvIHxlGNTYRdaJPd2yuT2LTVhyjJ676dIZRWYQgITFIyNvwQrPxy9Y9jkGASybyo2liAva6CqRHkHiOslEpR6GW1w9-4emYaOjS7XonTKkvB_he4oE2SU1xt45T_HDDJfHXDYb4aw',
                'is_featured' => true,
                'is_active' => true,
                'rating' => 5.0,
                'reviews_count' => 61,
            ],
            [
                'category_slug' => 'gadget',
                'name' => 'XINJI Stone Mini True Wireless Earbuds',
                'slug' => 'xinji-stone-mini-true-wireless-earbuds',
                'short_description' => 'Bluetooth 5.3, HD Stereo Bass, IPX5 Water Resistant, 24h Playtime with Case, Touch Control.',
                'description' => 'Ultra-compact featherlight TWS earbuds with powerful 13mm dynamic drivers, low-latency gaming mode, clear voice calling microphone, and comfortable ergonomic in-ear fit.',
                'price' => 1299.00,
                'sale_price' => 792.00,
                'stock' => 100,
                'sku' => 'ST-XIN-STONE-MINI',
                'image' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuAqzMoEBOjhrS9yOX3o0TTMnPWb5q_JSuQhq-VsyY-9rKdf-Vs4f1mzWWRAghHcibvml4h0olf99gQP0_R1V1PdUT1cc2ROKxEeGg51FEBVXZ-KRxIyCJFmwPZc4y8Em7_eN7QLOTIBcaqzLzAR1Dl0CPVjdBuWEMZfJn3mLi-Y9hlrrKqxHOOAVcJZsoh7WTxMll6r13mrHhosqQPRsI_xbqwVJ4v-o_Zqa0ZGcqOzELGEHK1Ni0TOpg',
                'is_featured' => true,
                'is_active' => true,
                'rating' => 4.9,
                'reviews_count' => 312,
            ],
            [
                'category_slug' => 'gaming',
                'name' => 'Sony PlayStation 5 Slim Gaming Console',
                'slug' => 'sony-playstation-5-slim-gaming-console',
                'short_description' => '1TB Custom SSD, Ultra HD Blu-Ray Disc Edition, Ray Tracing, 4K 120Hz Output, DualSense Haptics.',
                'description' => 'Experience lightning-fast loading with an ultra-high-speed 1TB SSD, deeper immersion with haptic feedback, adaptive triggers, and 3D Audio. Plays all your favourite PS5 and PS4 games in glorious 4K.',
                'price' => 105000.00,
                'sale_price' => 102000.00,
                'stock' => 25,
                'sku' => 'ST-SNY-PS5-SLIM',
                'image' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuCENcIjI_-LhAQRsNpBe2Qtq7h25Tv7ekp7UJWfe-1_YIL_ssne5FwtYq2_wNEgZ_MVANzYjk6DhJ5nwc81-H5LhTt_EIiUGWInigmWJQJzwRNBjnucor1EcOqb7ozurf3KLogO4fDCif4_rXgpvIspJtR7-b0nLv3DRPsexi4OJUz9r5yqlRvwNW1UTlDDT6fbcouSOIldbHzyiSlZAJirG8M550PVcI_n-i6tRiBP87C-h9APyvEIFw',
                'is_featured' => true,
                'is_active' => true,
                'rating' => 5.0,
                'reviews_count' => 180,
            ],
            [
                'category_slug' => 'office-equipment',
                'name' => 'APOLLO AP-800S Money Counting Machine',
                'slug' => 'apollo-ap-800s-money-counting-machine',
                'short_description' => 'Automatic Fake Note Detector (UV/MG/IR), 1000 Notes/Min Speed, Batch & Add Modes, External Display.',
                'description' => 'Heavy-duty commercial bank grade currency counting machine. Fast accurate sorting with advanced fake note detection for Bangladeshi Taka, US Dollar, Euro, and other global currencies.',
                'price' => 112000.00,
                'sale_price' => 105000.00,
                'stock' => 20,
                'sku' => 'ST-APL-AP800S',
                'image' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuCSDh5niqfi_wTuqm-gI3VYDU1cQToeT6fa2BCruFJbTtm3GWvD_bunq-EjrxkPFKFVvy04aEgkt0ZUMNSS00bwzLq0XYZqOMqr2ZR_pveaZ4D4vbXdpP_LG7o35MuJSUcvegXcVydGQswgKVkmr9qgPf9tz9xEENLi9r9VvRPd9ARbVcLs8NJHLZ2tq9jetKIdj0SHwDPZmJDicfpyqjFFmAAjU7IYZhuSjN7Yj_gpGYKeEBLCfq63gw',
                'is_featured' => true,
                'is_active' => true,
                'rating' => 4.8,
                'reviews_count' => 42,
            ],
        ];

        foreach ($products as $prodData) {
            $catSlug = $prodData['category_slug'];
            unset($prodData['category_slug']);

            $prodData['category_id'] = $categoryModels[$catSlug]->id ?? 1;
            $product = Product::create($prodData);

            // Verified Customer Reviews
            Review::create([
                'product_id' => $product->id,
                'user_name' => 'Tanvir Ahmed',
                'user_email' => 'tanvir@example.com',
                'rating' => 5,
                'title' => '১০০% অরিজিনাল প্রোডাক্ট এবং দ্রুত ডেলিভারি!',
                'comment' => 'SM Shop থেকে অর্ডার করেছিলাম, ঠিক সময়ে এবং অক্ষত অবস্থায় পেয়েছি। এদের সার্ভিস সবসময়ই সেরা।',
                'is_approved' => true,
                'created_at' => now()->subDays(rand(1, 15)),
            ]);

            Review::create([
                'product_id' => $product->id,
                'user_name' => 'Shakil Hossain',
                'user_email' => 'shakil@example.com',
                'rating' => 5,
                'title' => 'Best Tech Shop in Bangladesh',
                'comment' => 'Great product quality and official warranty support. Highly recommended!',
                'is_approved' => true,
                'created_at' => now()->subDays(rand(2, 25)),
            ]);
        }
    }
}