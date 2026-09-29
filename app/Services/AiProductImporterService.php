<?php

namespace App\Services;

use App\Models\Category;
use App\Models\Product;
use App\Models\Review;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class AiProductImporterService
{
    protected string $apiKey;
    protected string $companyName = 'SM Shop';

    public function __construct(?string $apiKey = null)
    {
        $this->apiKey = $this->resolveApiKey($apiKey);
    }

    /**
     * Resolve API key from multiple sources
     */
    public function resolveApiKey(?string $providedKey = null): string
    {
        if (!empty($providedKey)) {
            $this->saveApiKeyPermanently($providedKey);
            return trim($providedKey);
        }

        $configKey = config('services.gemini.api_key');
        if (!empty($configKey)) return trim($configKey);

        $envKey = env('GEMINI_API_KEY') ?: env('GOOGLE_API_KEY');
        if (!empty($envKey)) return trim($envKey);

        $filePath = storage_path('app/gemini_api_key.txt');
        if (File::exists($filePath)) {
            $saved = trim(File::get($filePath));
            if (!empty($saved)) return $saved;
        }

        return '';
    }

    /**
     * Permanently save API key to file and .env
     */
    public function saveApiKeyPermanently(string $key): void
    {
        $key = trim($key);
        if (empty($key)) return;

        try {
            $dir = storage_path('app');
            if (!File::isDirectory($dir)) {
                File::makeDirectory($dir, 0755, true, true);
            }
            File::put(storage_path('app/gemini_api_key.txt'), $key);

            $envPath = base_path('.env');
            if (File::exists($envPath) && File::isWritable($envPath)) {
                $envContent = File::get($envPath);
                if (str_contains($envContent, 'GEMINI_API_KEY=')) {
                    $envContent = preg_replace('/GEMINI_API_KEY=.*(\r?\n|$)/', "GEMINI_API_KEY={$key}\n", $envContent);
                } else {
                    $envContent .= "\nGEMINI_API_KEY={$key}\n";
                }
                File::put($envPath, $envContent);
            }
        } catch (\Throwable $e) {
            Log::warning("Could not auto-save API key: " . $e->getMessage());
        }
    }

    /**
     * Purge all products cleanly
     */
    public function purgeProducts(): int
    {
        \Illuminate\Support\Facades\Schema::disableForeignKeyConstraints();
        Review::truncate();
        if (class_exists(\App\Models\ProductVariant::class)) {
            \App\Models\ProductVariant::truncate();
        }
        $count = Product::count();
        Product::truncate();
        \Illuminate\Support\Facades\Schema::enableForeignKeyConstraints();

        return $count;
    }

    /**
     * Fetch HTML with modern browser headers
     */
    public function fetchHtml(string $url): array
    {
        try {
            $response = Http::withHeaders([
                'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Safari/537.36',
                'Accept' => 'text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8',
                'Accept-Language' => 'en-US,en;q=0.9,bn;q=0.8',
                'Accept-Encoding' => 'gzip, deflate',
                'Cache-Control' => 'no-cache',
                'Sec-Ch-Ua' => '"Chromium";v="130", "Google Chrome";v="130", "Not?A_Brand";v="99"',
                'Sec-Ch-Ua-Mobile' => '?0',
                'Sec-Ch-Ua-Platform' => '"Windows"',
                'Sec-Fetch-Dest' => 'document',
                'Sec-Fetch-Mode' => 'navigate',
                'Sec-Fetch-Site' => 'none',
                'Sec-Fetch-User' => '?1',
                'Upgrade-Insecure-Requests' => '1',
            ])->timeout(25)->withoutVerifying()->get($url);

            if (!$response->successful()) {
                return [
                    'success' => false,
                    'error' => "HTTP Status: " . $response->status(),
                ];
            }

            return [
                'success' => true,
                'html' => $response->body(),
            ];
        } catch (\Throwable $e) {
            return [
                'success' => false,
                'error' => $e->getMessage(),
            ];
        }
    }

    /**
     * Helper to clean and extract price number
     */
    protected function cleanPrice(string $raw): ?float
    {
        // Strip everything except digits and dot
        $cleaned = preg_replace('/[^\d.]/', '', str_replace(',', '', $raw));
        $val = (float) $cleaned;
        return $val > 0 ? $val : null;
    }

    /**
     * Extract EXACT product cards directly from Category Listing HTML
     */
    public function extractProductsFromListing(string $html, string $sourceUrl): array
    {
        $products = [];

        // 1. Star Tech Pattern (<div class="p-item">)
        if (preg_match_all('/<div[^>]*class=["\'][^"\']*p-item[^"\']*["\'][^>]*>(.*?)<\/div>\s*<\/div>/is', $html, $cards) && count($cards[0]) > 0) {
            foreach ($cards[0] as $cardHtml) {
                if (preg_match('/<h4[^>]*class=["\'][^"\']*p-item-name[^"\']*["\'][^>]*>.*?<a[^>]*href=["\']([^"\']+)["\'][^>]*>(.*?)<\/a>/is', $cardHtml, $tm)) {
                    $itemUrl = $this->resolveUrl($tm[1], $sourceUrl);
                    $title = trim(html_entity_decode(strip_tags($tm[2])));
                    $title = preg_replace('/\s*[-|]\s*(Star Tech|Techland|TechLandBD|Ryans|Daraz).*$/i', '', $title);

                    $price = null;
                    $salePrice = null;

                    if (preg_match('/<div[^>]*class=["\'][^"\']*p-item-price[^"\']*["\'][^>]*>(.*?)<\/div>/is', $cardHtml, $pm)) {
                        $priceArea = $pm[1];
                        if (preg_match('/<span[^>]*class=["\'][^"\']*price-old[^"\']*["\'][^>]*>([^<]+)<\/span>/i', $priceArea, $oldM)) {
                            $price = $this->cleanPrice($oldM[1]);
                        }
                        if (preg_match('/<span(?![^>]*class=["\'][^"\']*price-old)[^>]*>([^<]+)<\/span>/i', $priceArea, $curM)) {
                            $salePrice = $this->cleanPrice($curM[1]);
                        }
                        if (empty($salePrice) && preg_match('/([\d,]+)/', $priceArea, $pMatch)) {
                            $salePrice = $this->cleanPrice($pMatch[1]);
                        }
                    }
                    if (empty($price)) $price = $salePrice;

                    $imgUrl = '';
                    if (preg_match('/<div[^>]*class=["\'][^"\']*p-item-img[^"\']*["\'][^>]*>.*?<img[^>]*src=["\']([^"\']+)["\']/is', $cardHtml, $im)) {
                        $imgUrl = str_replace('228x228', '500x500', $im[1]);
                    }

                    $features = [];
                    if (preg_match_all('/<li[^>]*>(.*?)<\/li>/is', $cardHtml, $lm)) {
                        foreach ($lm[1] as $f) {
                            $fText = trim(html_entity_decode(strip_tags($f)));
                            if (!empty($fText)) $features[] = $fText;
                        }
                    }

                    if (!empty($title) && !empty($salePrice)) {
                        $products[] = [
                            'name' => $title,
                            'price' => $price,
                            'sale_price' => $salePrice,
                            'image' => $imgUrl,
                            'url' => $itemUrl,
                            'short_description' => implode(' • ', $features),
                            'category_slug' => $this->detectCategorySlug($title, $sourceUrl),
                        ];
                    }
                }
            }
        }

        // 2. OpenCart / TechLandBD / Daraz / Ryans Pattern
        if (empty($products) && preg_match_all('/<div[^>]*class=["\'][^"\']*(?:product-thumb|product-layout|card-product|product-card)[^"\']*["\'][^>]*>(.*?)<\/div>\s*<\/div>/is', $html, $cards2)) {
            foreach ($cards2[0] as $cardHtml) {
                if (preg_match('/<(?:h4|div|h3|h2)[^>]*class=["\'][^"\']*(?:name|caption|title)[^"\']*["\'][^>]*>.*?<a[^>]*href=["\']([^"\']+)["\'][^>]*>(.*?)<\/a>/is', $cardHtml, $tm)) {
                    $itemUrl = $this->resolveUrl($tm[1], $sourceUrl);
                    $title = trim(html_entity_decode(strip_tags($tm[2])));
                    $title = preg_replace('/\s*[-|]\s*(Star Tech|Techland|TechLandBD|Ryans|Daraz).*$/i', '', $title);

                    $price = null;
                    $salePrice = null;
                    if (preg_match('/<span[^>]*class=["\'][^"\']*(?:price-new|special)[^"\']*["\'][^>]*>([^<]+)<\/span>/i', $cardHtml, $sm)) {
                        $salePrice = $this->cleanPrice($sm[1]);
                    }
                    if (preg_match('/<span[^>]*class=["\'][^"\']*(?:price-old|regular)[^"\']*["\'][^>]*>([^<]+)<\/span>/i', $cardHtml, $om)) {
                        $price = $this->cleanPrice($om[1]);
                    }
                    if (empty($salePrice) && preg_match('/(?:Tk\.?|BDT|৳)\s*([\d,]+)/iu', $cardHtml, $gm)) {
                        $salePrice = $this->cleanPrice($gm[1]);
                    }
                    if (empty($price)) $price = $salePrice;

                    $imgUrl = '';
                    if (preg_match('/<img[^>]*src=["\']([^"\']+)["\']/is', $cardHtml, $im)) {
                        $imgUrl = $this->resolveUrl($im[1], $sourceUrl);
                    }

                    if (!empty($title) && !empty($salePrice)) {
                        $products[] = [
                            'name' => $title,
                            'price' => $price,
                            'sale_price' => $salePrice,
                            'image' => $imgUrl,
                            'url' => $itemUrl,
                            'short_description' => "100% Genuine {$title} with official warranty and nationwide delivery from {$this->companyName}.",
                            'category_slug' => $this->detectCategorySlug($title, $sourceUrl),
                        ];
                    }
                }
            }
        }

        return $products;
    }

    /**
     * Scrape EXACT Single Product Details (Title, Prices, Gallery Images, Specs)
     */
    public function scrapeExactProduct(string $html, string $sourceUrl): array
    {
        // 1. Exact Title
        $title = '';
        if (preg_match('/<h1[^>]*class=["\'][^"\']*(?:product-name|title|product-title|name)[^"\']*["\'][^>]*>(.*?)<\/h1>/is', $html, $h1)) {
            $title = trim(html_entity_decode(strip_tags($h1[1])));
        } elseif (preg_match('/<h1[^>]*>(.*?)<\/h1>/is', $html, $h1)) {
            $title = trim(html_entity_decode(strip_tags($h1[1])));
        } elseif (preg_match('/<meta property=["\']og:title["\'] content=["\'](.*?)["\']/i', $html, $m)) {
            $title = trim(html_entity_decode($m[1]));
        }

        $title = preg_replace('/\s*[-|]\s*(Star Tech|Techland|TechLandBD|Ryans|Daraz|Pickaboo|Computer Mania).*$/i', '', $title);
        $title = preg_replace('/\s*(Price in Bangladesh|Price in BD|Best Price).*$/i', '', $title);
        $title = trim($title);

        // 2. Exact Prices
        $cashPrice = null;
        $regularPrice = null;

        // StarTech table format
        if (preg_match('/<td[^>]*class=["\'][^"\']*product-price[^"\']*["\'][^>]*>([^<]+)<\/td>/is', $html, $priceTd)) {
            $cashPrice = $this->cleanPrice($priceTd[1]);
        }
        if (preg_match('/<td[^>]*class=["\'][^"\']*product-regular-price[^"\']*["\'][^>]*>([^<]+)<\/td>/is', $html, $regTd)) {
            $regularPrice = $this->cleanPrice($regTd[1]);
        }

        // Standard Ins/Del
        if (empty($cashPrice) && preg_match('/<ins[^>]*>([^<]+)<\/ins>/i', $html, $ins)) {
            $cashPrice = $this->cleanPrice($ins[1]);
        }
        if (empty($regularPrice) && preg_match('/<del[^>]*>([^<]+)<\/del>/i', $html, $del)) {
            $regularPrice = $this->cleanPrice($del[1]);
        }

        // OpenCart / TechLand new/old price
        if (empty($cashPrice) && preg_match('/<span[^>]*class=["\'][^"\']*(?:price-new|special)[^"\']*["\'][^>]*>([^<]+)<\/span>/i', $html, $sm)) {
            $cashPrice = $this->cleanPrice($sm[1]);
        }
        if (empty($regularPrice) && preg_match('/<span[^>]*class=["\'][^"\']*(?:price-old|regular)[^"\']*["\'][^>]*>([^<]+)<\/span>/i', $html, $om)) {
            $regularPrice = $this->cleanPrice($om[1]);
        }

        // Fallback generic price search
        if (empty($cashPrice) && preg_match('/(?:৳|Tk\.?|BDT|\$)\s*([\d,]+(?:\.\d{2})?)/iu', $html, $pMatch)) {
            $cashPrice = $this->cleanPrice($pMatch[1]);
        }

        if (empty($regularPrice)) $regularPrice = $cashPrice;
        if (empty($cashPrice)) $cashPrice = $regularPrice;

        // 3. Exact Main Image
        $mainImage = '';
        if (preg_match('/<img[^>]*class=["\'][^"\']*(?:main-img|product-image)[^"\']*["\'][^>]*src=["\']([^"\']+)["\']/is', $html, $mainM)) {
            $mainImage = $this->resolveUrl($mainM[1], $sourceUrl);
        } elseif (preg_match('/<meta property=["\']og:image["\'] content=["\'](.*?)["\']/i', $html, $ogM)) {
            $mainImage = $this->resolveUrl($ogM[1], $sourceUrl);
        }

        // 4. Exact Gallery Images (HD 500x500+)
        $gallery = [];

        // Find href links to full-size images
        if (preg_match_all('/<a[^>]*href=["\']([^"\']*(?:\.webp|\.jpg|\.png|\.jpeg))["\'][^>]*>/is', $html, $galLinks)) {
            foreach ($galLinks[1] as $g) {
                if (str_contains($g, 'catalog') && !str_contains($g, 'logo') && !str_contains($g, 'banner')) {
                    $resolved = $this->resolveUrl($g, $sourceUrl);
                    if ($resolved !== $mainImage && !in_array($resolved, $gallery) && $this->isValidImageUrl($resolved)) {
                        $gallery[] = $resolved;
                    }
                }
            }
        }

        // Also check thumbnail images and upgrade resolution
        if (preg_match_all('/<img[^>]*src=["\']([^"\']*(?:catalog)[^"\']*)["\']/is', $html, $galImgs)) {
            foreach ($galImgs[1] as $g) {
                if (!str_contains($g, 'logo') && !str_contains($g, 'banner') && !str_contains($g, 'icon')) {
                    // Upgrade thumbnail size
                    $upgraded = preg_replace('/-\d+x\d+/', '-500x500', $g);
                    $resolved = $this->resolveUrl($upgraded, $sourceUrl);
                    if ($resolved !== $mainImage && !in_array($resolved, $gallery) && $this->isValidImageUrl($resolved)) {
                        $gallery[] = $resolved;
                    }
                }
            }
        }

        // Limit gallery to top 8 clean images
        $gallery = array_slice($gallery, 0, 8);

        // 5. Exact Short Description / Key Features
        $shortDesc = '';
        if (preg_match('/<div[^>]*class=["\'][^"\']*(?:short-description|product-short-description)[^"\']*["\'][^>]*>(.*?)<\/div>/is', $html, $shortM)) {
            $shortDesc = trim(strip_tags($shortM[1], '<ul><li><p><br><b><strong>'));
        }

        // 6. Specifications Table
        $specsHtml = '';
        if (preg_match('/<table[^>]*class=["\'][^"\']*(?:data-table|specification|specs|product-info)[^"\']*["\'][^>]*>(.*?)<\/table>/is', $html, $tableM)) {
            $specsHtml = strip_tags($tableM[0], '<table><tr><td><th><tbody>');
        }

        $catSlug = $this->detectCategorySlug($title, $sourceUrl);

        // 7. Check if Gemini AI can enhance the description
        $finalDesc = "Get the best price for {$title} in Bangladesh only at {$this->companyName}. We guarantee 100% authentic products with official warranty, super fast nationwide delivery to all 64 districts, cash on delivery, and dedicated customer support." . (!empty($specsHtml) ? "<div class='mt-4'>{$specsHtml}</div>" : '');

        if (!empty($this->apiKey)) {
            $aiData = $this->generateWithGemini($title, $shortDesc, $specsHtml);
            if (!empty($aiData['description'])) {
                $finalDesc = $aiData['description'] . (!empty($specsHtml) ? "<div class='mt-4'>{$specsHtml}</div>" : '');
            }
            if (!empty($aiData['short_description'])) {
                $shortDesc = $aiData['short_description'];
            }
        }

        return [
            'name' => $title ?: 'Genuine Tech Product',
            'category_slug' => $catSlug,
            'price' => (float)$regularPrice,
            'sale_price' => (float)$cashPrice,
            'main_image' => $mainImage ?: 'https://images.unsplash.com/photo-1518611012118-696072aa579a?w=800',
            'gallery_images' => $gallery,
            'short_description' => $shortDesc ?: "100% Genuine {$title} with official warranty, high performance, and reliable build quality from {$this->companyName}.",
            'description' => $finalDesc,
            'sku' => 'SM-' . strtoupper(substr($catSlug, 0, 3)) . '-' . rand(1000, 9999),
            'rating' => 4.9,
            'reviews' => [
                [
                    'user_name' => 'Tariqul Islam',
                    'rating' => 5,
                    'title' => '১০০% অরিজিনাল প্রোডাক্ট এবং দ্রুত ডেলিভারি!',
                    'comment' => "{$this->companyName} থেকে অর্ডার করেছিলাম, খুবই দ্রুত এবং অক্ষত প্যাকেজিং এ পেয়েছি। প্রোডাক্ট পারফরম্যান্স অসাধারণ।"
                ],
                [
                    'user_name' => 'Farhan Ahmed',
                    'rating' => 5,
                    'title' => "Best Service from {$this->companyName}",
                    'comment' => "Authentic product with official warranty support. Highly recommended for computer and gadget lovers in BD."
                ]
            ]
        ];
    }

    /**
     * Optional Gemini AI Content Generation
     */
    protected function generateWithGemini(string $title, string $rawFeatures, string $specs): array
    {
        try {
            $prompt = "You are an eCommerce copywriter for '{$this->companyName}' (a leading electronics & computer retailer in Bangladesh).
Write a professional, compelling, and SEO-optimized product description for:
Product Name: {$title}
Features: " . strip_tags($rawFeatures) . "

Requirements:
1. Short Description: 2-3 sentences highlighting main specs and why to buy.
2. Main Description: Engaging 2-3 paragraphs highlighting build quality, performance, official warranty, and fast nationwide delivery from {$this->companyName}.
3. Return STRICTLY valid JSON with keys 'short_description' and 'description'. Do not include markdown code block markers.";

            $url = "https://generativelanguage.googleapis.com/v1beta/models/gemini-1.5-flash:generateContent?key={$this->apiKey}";

            $res = Http::withHeaders(['Content-Type' => 'application/json'])
                ->timeout(15)
                ->post($url, [
                    'contents' => [
                        [
                            'parts' => [
                                ['text' => $prompt]
                            ]
                        ]
                    ]
                ]);

            if ($res->successful()) {
                $json = $res->json();
                $text = $json['candidates'][0]['content']['parts'][0]['text'] ?? '';
                $text = trim(preg_replace('/^```(?:json)?|```$/m', '', $text));
                $parsed = json_decode($text, true);
                if (is_array($parsed) && !empty($parsed['description'])) {
                    return $parsed;
                }
            }
        } catch (\Throwable $e) {
            Log::info("Gemini generation skipped: " . $e->getMessage());
        }

        return [];
    }

    /**
     * Helper to detect category slug
     */
    protected function detectCategorySlug(string $title, string $url = ''): string
    {
        $lower = strtolower($title . ' ' . $url);
        if (str_contains($lower, 'laptop') || str_contains($lower, 'macbook') || str_contains($lower, 'notebook') || str_contains($lower, 'surface')) return 'laptop';
        if (str_contains($lower, 'desktop') || str_contains($lower, 'ryzen 5') || str_contains($lower, 'core i5') || str_contains($lower, 'pc')) return 'desktop';
        if (str_contains($lower, 'monitor') || str_contains($lower, 'display')) return 'monitor';
        if (str_contains($lower, 'processor') || str_contains($lower, 'motherboard') || str_contains($lower, 'ram') || str_contains($lower, 'ssd') || str_contains($lower, 'gpu') || str_contains($lower, 'graphics')) return 'component';
        if (str_contains($lower, 'phone') || str_contains($lower, 'smartphone') || str_contains($lower, 'iphone')) return 'phone';
        if (str_contains($lower, 'camera') || str_contains($lower, 'drone') || str_contains($lower, 'gimbal')) return 'camera';
        if (str_contains($lower, 'tv') || str_contains($lower, 'television')) return 'tv';
        if (str_contains($lower, 'power') || str_contains($lower, 'ups')) return 'power';
        if (str_contains($lower, 'watch') || str_contains($lower, 'earbuds') || str_contains($lower, 'headphone') || str_contains($lower, 'gadget')) return 'gadget';
        return 'gadget';
    }

    /**
     * Save structured product into Database
     */
    public function saveProduct(array $productData): Product
    {
        $catSlug = $productData['category_slug'] ?? 'gadget';
        $category = Category::firstOrCreate(
            ['slug' => $catSlug],
            [
                'name' => ucwords(str_replace('-', ' ', $catSlug)),
                'is_active' => true,
            ]
        );

        $name = $productData['name'];
        $baseSlug = Str::slug($name);
        $slug = $baseSlug;
        $counter = 1;
        while (Product::where('slug', $slug)->exists()) {
            $slug = $baseSlug . '-' . $counter++;
        }

        $product = Product::create([
            'category_id' => $category->id,
            'name' => $name,
            'slug' => $slug,
            'short_description' => $productData['short_description'] ?? null,
            'description' => $productData['description'] ?? ("100% Genuine {$name} with official warranty and fast delivery from {$this->companyName}."),
            'price' => (float) ($productData['price'] ?? 0),
            'sale_price' => !empty($productData['sale_price']) ? (float) $productData['sale_price'] : null,
            'stock' => rand(15, 60),
            'sku' => $productData['sku'] ?? ('SM-' . strtoupper(Str::random(6))),
            'image' => $productData['main_image'] ?? ($productData['image'] ?? null),
            'gallery_images' => $productData['gallery_images'] ?? [],
            'is_featured' => true,
            'is_active' => true,
            'rating' => (float) ($productData['rating'] ?? 4.9),
            'reviews_count' => count($productData['reviews'] ?? []) ?: rand(15, 80),
        ]);

        if (!empty($productData['reviews'])) {
            foreach ($productData['reviews'] as $rev) {
                Review::create([
                    'product_id' => $product->id,
                    'user_name' => $rev['user_name'] ?? 'Verified Customer',
                    'user_email' => Str::slug($rev['user_name'] ?? 'customer') . '@example.com',
                    'rating' => $rev['rating'] ?? 5,
                    'title' => $rev['title'] ?? 'Great Product!',
                    'comment' => $rev['comment'] ?? "Very satisfied with this purchase from {$this->companyName}.",
                    'is_approved' => true,
                    'created_at' => now()->subDays(rand(1, 20)),
                ]);
            }
        }

        return $product;
    }

    /**
     * Process Single URL / Direct HTML end-to-end
     */
    public function importFromUrl(string $url, ?string $rawHtml = null): array
    {
        $html = $rawHtml;
        if (empty($html)) {
            $fetched = $this->fetchHtml($url);
            if (!$fetched['success']) {
                return [
                    'success' => false,
                    'url' => $url,
                    'error' => "Could not scrape {$url} (" . $fetched['error'] . "). If blocked by Cloudflare, please use the 'Paste HTML' tab.",
                ];
            }
            $html = $fetched['html'];
        }

        // Check if listing page
        $cards = $this->extractProductsFromListing($html, $url);
        if (count($cards) >= 2) {
            // Bulk save all exact products from this category listing!
            $savedProducts = [];
            foreach ($cards as $card) {
                $p = $this->saveProduct($card);
                $savedProducts[] = [
                    'name' => $p->name,
                    'price' => $p->price,
                    'sale_price' => $p->sale_price,
                    'image' => $p->image,
                    'product_url' => route('product.show', $p->slug),
                ];
            }

            return [
                'success' => true,
                'is_listing' => true,
                'count' => count($savedProducts),
                'name' => "Category Listing: " . count($savedProducts) . " exact products imported",
                'price' => $savedProducts[0]['price'] ?? 0,
                'sale_price' => $savedProducts[0]['sale_price'] ?? 0,
                'image_count' => count($savedProducts),
                'product_url' => route('shop.index'),
                'products' => $savedProducts,
            ];
        }

        // Single Product
        $exactProduct = $this->scrapeExactProduct($html, $url);
        $product = $this->saveProduct($exactProduct);

        return [
            'success' => true,
            'url' => $url,
            'product_id' => $product->id,
            'name' => $product->name,
            'slug' => $product->slug,
            'price' => $product->price,
            'sale_price' => $product->sale_price,
            'effective_price' => $product->effective_price,
            'category' => $product->category->name ?? 'N/A',
            'image_count' => 1 + count($product->gallery_images ?? []),
            'image' => $product->image,
            'product_url' => route('product.show', $product->slug),
            'is_listing' => false,
        ];
    }

    /**
     * Extract product links from category page
     */
    public function extractProductUrlsFromPage(string $url, ?string $rawHtml = null): array
    {
        $html = $rawHtml;
        if (empty($html)) {
            $res = $this->fetchHtml($url);
            if (!$res['success']) return [];
            $html = $res['html'];
        }

        $cards = $this->extractProductsFromListing($html, $url);
        if (!empty($cards)) {
            return array_map(fn($c) => $c['url'], $cards);
        }

        // Fallback href regex
        $links = [];
        if (preg_match_all('/<a[^>]*href=["\']([^"\']+)["\']/i', $html, $matches)) {
            foreach ($matches[1] as $href) {
                $full = $this->resolveUrl($href, $url);
                if (
                    !str_contains($full, '#') &&
                    !str_contains($full, 'javascript:') &&
                    !str_contains($full, '/cart') &&
                    !str_contains($full, '/checkout') &&
                    !str_contains($full, '/account') &&
                    !str_contains($full, '/login') &&
                    !str_contains($full, '/register')
                ) {
                    if (!in_array($full, $links)) {
                        $links[] = $full;
                    }
                }
            }
        }

        return array_slice($links, 0, 30);
    }

    /**
     * Bulk Process multiple URLs
     */
    public function bulkImport(array $urls, bool $purgeFirst = false): array
    {
        if ($purgeFirst) {
            $this->purgeProducts();
        }

        $results = [
            'total' => count($urls),
            'imported' => 0,
            'failed' => 0,
            'products' => [],
            'errors' => [],
        ];

        foreach ($urls as $url) {
            $res = $this->importFromUrl($url);
            if ($res['success']) {
                $results['imported']++;
                $results['products'][] = $res;
            } else {
                $results['failed']++;
                $results['errors'][] = [
                    'url' => $url,
                    'error' => $res['error'],
                ];
            }
        }

        return $results;
    }

    /**
     * Resolve relative URL
     */
    protected function resolveUrl(string $rel, string $base): string
    {
        if (str_starts_with($rel, '//')) return 'https:' . $rel;
        if (str_starts_with($rel, 'http://') || str_starts_with($rel, 'https://')) return $rel;
        $parse = parse_url($base);
        $host = ($parse['scheme'] ?? 'https') . '://' . ($parse['host'] ?? '');
        if (str_starts_with($rel, '/')) return $host . $rel;
        return $host . '/' . ltrim($rel, '/');
    }

    /**
     * Check if valid image URL
     */
    protected function isValidImageUrl(string $url): bool
    {
        if (empty($url) || !filter_var($url, FILTER_VALIDATE_URL)) return false;
        $lower = strtolower($url);
        if (
            str_contains($lower, 'icon') ||
            str_contains($lower, 'avatar') ||
            str_contains($lower, 'logo') ||
            str_contains($lower, 'flag') ||
            str_contains($lower, '1x1') ||
            str_contains($lower, 'spinner')
        ) {
            return false;
        }
        return true;
    }
}
