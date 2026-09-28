<?php

namespace App\Services;

use App\Models\Category;
use App\Models\Product;
use App\Models\Review;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class AiProductImporterService
{
    protected string $apiKey;
    protected string $companyName = 'SM Shop';

    public function __construct(?string $apiKey = null)
    {
        $this->apiKey = $apiKey ?: (config('services.gemini.api_key') ?: (env('GEMINI_API_KEY') ?: env('GOOGLE_API_KEY', '')));
    }

    /**
     * Purge all demo/existing products cleanly
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
     * Scrape product details & high-res images from any URL
     */
    public function scrapeUrl(string $url): array
    {
        try {
            $response = Http::withHeaders([
                'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/122.0.0.0 Safari/537.36',
                'Accept' => 'text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8',
                'Accept-Language' => 'en-US,en;q=0.9,bn;q=0.8',
            ])->timeout(25)->get($url);

            if (!$response->successful()) {
                return [
                    'success' => false,
                    'error' => "Failed to fetch URL. HTTP Status: " . $response->status(),
                ];
            }

            $html = $response->body();
            return $this->parseHtml($html, $url);
        } catch (\Throwable $e) {
            Log::error("Scraping error for {$url}: " . $e->getMessage());
            return [
                'success' => false,
                'error' => "Connection error: " . $e->getMessage(),
            ];
        }
    }

    /**
     * Parse HTML and extract JSON-LD, OpenGraph, Title, Images, and Specs
     */
    protected function parseHtml(string $html, string $sourceUrl): array
    {
        $parsed = [
            'success' => true,
            'source_url' => $sourceUrl,
            'raw_title' => '',
            'raw_price' => null,
            'raw_sale_price' => null,
            'raw_description' => '',
            'raw_specs' => [],
            'images' => [],
            'sub_links' => [], // For category / listing pages
        ];

        // 1. JSON-LD Schema Extraction
        if (preg_match_all('/<script type=["\']application\/ld\+json["\']>(.*?)<\/script>/is', $html, $matches)) {
            foreach ($matches[1] as $jsonStr) {
                $data = json_decode(trim($jsonStr), true);
                if ($data) {
                    if (isset($data['@type']) && (strtolower($data['@type']) === 'product' || (is_array($data['@type']) && in_array('Product', $data['@type'])))) {
                        $parsed['raw_title'] = $data['name'] ?? $parsed['raw_title'];
                        $parsed['raw_description'] = $data['description'] ?? $parsed['raw_description'];
                        if (!empty($data['image'])) {
                            if (is_array($data['image'])) {
                                foreach ($data['image'] as $img) {
                                    if (is_string($img) && filter_var($img, FILTER_VALIDATE_URL)) {
                                        $parsed['images'][] = $img;
                                    }
                                }
                            } elseif (is_string($data['image']) && filter_var($data['image'], FILTER_VALIDATE_URL)) {
                                $parsed['images'][] = $data['image'];
                            }
                        }
                        if (!empty($data['offers'])) {
                            $offers = is_array($data['offers']) && isset($data['offers'][0]) ? $data['offers'][0] : $data['offers'];
                            $parsed['raw_price'] = $offers['price'] ?? ($offers['lowPrice'] ?? null);
                        }
                    }
                }
            }
        }

        // 2. OpenGraph & Meta Tags
        if (empty($parsed['raw_title']) && preg_match('/<meta property=["\']og:title["\'] content=["\'](.*?)["\']/i', $html, $m)) {
            $parsed['raw_title'] = html_entity_decode($m[1]);
        }
        if (empty($parsed['raw_title']) && preg_match('/<title>(.*?)<\/title>/i', $html, $m)) {
            $parsed['raw_title'] = trim(html_entity_decode($m[1]));
        }

        if (empty($parsed['raw_description']) && preg_match('/<meta property=["\']og:description["\'] content=["\'](.*?)["\']/i', $html, $m)) {
            $parsed['raw_description'] = html_entity_decode($m[1]);
        }

        // OpenGraph Image
        if (preg_match_all('/<meta property=["\']og:image["\'] content=["\'](.*?)["\']/i', $html, $m)) {
            foreach ($m[1] as $img) {
                if ($this->isValidImageUrl($img)) {
                    $parsed['images'][] = $this->resolveUrl($img, $sourceUrl);
                }
            }
        }

        // 3. Extract High Quality Gallery Images
        // Match large img tags, data-zoom-image, data-src, zoom-image
        if (preg_match_all('/<(img|a)[^>]*(src|data-src|data-zoom-image|href)=["\']([^"\']+\.(jpg|jpeg|png|webp))["\'][^>]*>/i', $html, $imgMatches)) {
            foreach ($imgMatches[3] as $imgSrc) {
                $fullImgUrl = $this->resolveUrl($imgSrc, $sourceUrl);
                if ($this->isValidImageUrl($fullImgUrl) && !in_array($fullImgUrl, $parsed['images'])) {
                    $parsed['images'][] = $fullImgUrl;
                }
            }
        }

        // 4. Extract Price if not found
        if (empty($parsed['raw_price'])) {
            // Check for Bangladeshi Taka price (৳ or tk or price)
            if (preg_match('/(?:৳|Tk\.?|BDT|\$)\s*([\d,]+(?:\.\d{2})?)/i', $html, $pMatch)) {
                $parsed['raw_price'] = (float) str_replace(',', '', $pMatch[1]);
            }
        }

        // 5. Extract Text & Specifications Table
        if (preg_match('/<table[^>]*class=["\'][^"\']*(specification|specs|data-table|product-info)[^"\']*["\'][^>]*>(.*?)<\/table>/is', $html, $tableMatch)) {
            $parsed['raw_specs_html'] = strip_tags($tableMatch[0], '<table><tr><td><th><tbody>');
        }

        // If this page contains child product links (Listing / Category Page)
        if (preg_match_all('/<a[^>]+href=["\']([^"\']*(?:\/product\/|\/p\/|\/item\/|\.html)[^"\']*)["\']/i', $html, $subMatches)) {
            $subLinks = [];
            foreach ($subMatches[1] as $sub) {
                $fullSub = $this->resolveUrl($sub, $sourceUrl);
                if (filter_var($fullSub, FILTER_VALIDATE_URL) && !in_array($fullSub, $subLinks) && $fullSub !== $sourceUrl) {
                    $subLinks[] = $fullSub;
                }
            }
            $parsed['sub_links'] = array_slice($subLinks, 0, 20);
        }

        // Truncate raw HTML / Text context for AI prompt
        $cleanText = strip_tags($html);
        $cleanText = preg_replace('/\s+/', ' ', $cleanText);
        $parsed['page_text_snippet'] = Str::limit($cleanText, 4000);

        // Deduplicate and filter images
        $parsed['images'] = array_values(array_unique(array_filter($parsed['images'])));

        return $parsed;
    }

    /**
     * Send scraped data to Google Gemini AI to rewrite and brand for SM Shop
     */
    public function rewriteWithAi(array $scrapedData): array
    {
        $title = $scrapedData['raw_title'] ?? 'Tech Product';
        $snippet = $scrapedData['page_text_snippet'] ?? '';
        $specs = $scrapedData['raw_specs_html'] ?? '';
        $rawPrice = $scrapedData['raw_price'] ?? null;
        $images = $scrapedData['images'] ?? [];

        $prompt = <<<PROMPT
You are an expert E-Commerce Catalog Director and copywriter for "SM Shop" (SM Cloud IT), the leading Computer, Laptop, and Gadget Store in Bangladesh.

Task:
Analyze the following scraped product data and create a complete, high-converting product listing in STRICT JSON FORMAT tailored for SM Shop.

Scraped Product Title: {$title}
Scraped Estimated Price: {$rawPrice}
Scraped Specifications/Text Snippet:
{$snippet}

Rules:
1. "name": A clean, accurate, attractive product title (remove competitor store names like Star Tech, Ryans, Daraz, etc.).
2. "category_slug": Pick ONE best match from: [desktop, laptop, component, monitor, power, phone, tablet, office-equipment, camera, security, networking, software, server-storage, accessories, gadget, gaming, tv, appliance, fashion].
3. "price": Realistic price in Bangladeshi Taka (৳). If scraped price is {$rawPrice}, use it or approximate based on Bangladeshi market price (integer/float).
4. "sale_price": Optional special discount cash price in ৳ (e.g. 5-12% lower than price), or null.
5. "short_description": 3 to 5 bullet points with core technical specs (e.g. Processor, RAM, Display, Warranty).
6. "description": A comprehensive, beautifully formatted 3-4 paragraph product overview. Emphasize why to buy from "SM Shop" (official warranty, 100% genuine sealed box, 64-district express delivery, and dedicated customer support).
7. "sku": A distinct SKU code prefix like "SM-PROD-" + 4 digits.
8. "rating": A float between 4.7 and 5.0.
9. "reviews": An array of 2 realistic customer reviews:
   - Review 1: In Bengali praising product quality and SM Shop fast delivery.
   - Review 2: In English praising the official warranty and customer service of SM Shop.

OUTPUT REQUIREMENT:
Return ONLY a valid JSON object without any markdown wrapping (no ```json code blocks), matching this schema:
{
  "name": "...",
  "category_slug": "...",
  "price": 0,
  "sale_price": 0,
  "short_description": "...",
  "description": "...",
  "sku": "...",
  "rating": 4.9,
  "reviews": [
    {
      "user_name": "...",
      "rating": 5,
      "title": "...",
      "comment": "..."
    }
  ]
}
PROMPT;

        $aiResult = $this->callGemini($prompt);

        if (!$aiResult['success']) {
            Log::warning("Gemini AI failed, using intelligent rule-based rewriter: " . ($aiResult['error'] ?? 'Unknown error'));
            return $this->fallbackRuleBasedRewriter($scrapedData);
        }

        $json = $this->cleanJsonString($aiResult['content']);
        $decoded = json_decode($json, true);

        if (!$decoded || !isset($decoded['name'])) {
            Log::warning("Gemini output JSON parsing failed, using rule-based rewriter.");
            return $this->fallbackRuleBasedRewriter($scrapedData);
        }

        // Attach images
        $decoded['main_image'] = !empty($images[0]) ? $images[0] : 'https://images.unsplash.com/photo-1518611012118-696072aa579a?w=800';
        $decoded['gallery_images'] = array_slice($images, 1, 6);

        return [
            'success' => true,
            'data' => $decoded,
        ];
    }

    /**
     * Call Google Gemini API
     */
    protected function callGemini(string $prompt): array
    {
        $key = $this->apiKey;
        if (empty($key)) {
            return ['success' => false, 'error' => 'No Google API key configured.'];
        }

        // Try Gemini 1.5 Flash first, then Gemini 2.0 Flash
        $endpoints = [
            "https://generativelanguage.googleapis.com/v1beta/models/gemini-1.5-flash:generateContent?key={$key}",
            "https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateContent?key={$key}",
            "https://generativelanguage.googleapis.com/v1/models/gemini-1.5-flash:generateContent?key={$key}",
        ];

        foreach ($endpoints as $url) {
            try {
                $response = Http::withHeaders([
                    'Content-Type' => 'application/json',
                ])->timeout(30)->post($url, [
                    'contents' => [
                        [
                            'parts' => [
                                ['text' => $prompt]
                            ]
                        ]
                    ],
                    'generationConfig' => [
                        'temperature' => 0.4,
                        'maxOutputTokens' => 2048,
                    ]
                ]);

                if ($response->successful()) {
                    $data = $response->json();
                    $text = $data['candidates'][0]['content']['parts'][0]['text'] ?? '';
                    if (!empty($text)) {
                        return ['success' => true, 'content' => $text];
                    }
                } else {
                    Log::warning("Gemini endpoint {$url} failed: " . $response->body());
                }
            } catch (\Throwable $e) {
                Log::warning("Gemini endpoint exception: " . $e->getMessage());
            }
        }

        return ['success' => false, 'error' => 'Could not connect to Gemini API.'];
    }

    /**
     * Fallback Rule-Based Rewriter if Gemini API is unreachable
     */
    protected function fallbackRuleBasedRewriter(array $scrapedData): array
    {
        $rawTitle = $scrapedData['raw_title'] ?: 'Tech & Gadget Product';
        $cleanTitle = preg_replace('/\s*[-|]\s*(Star Tech|Ryans|Daraz|Pickaboo|Computer Mania).*$/i', '', $rawTitle);
        $cleanTitle = trim($cleanTitle);

        // Detect category from title
        $catSlug = 'gadget';
        $lower = strtolower($cleanTitle . ' ' . ($scrapedData['page_text_snippet'] ?? ''));
        if (str_contains($lower, 'laptop') || str_contains($lower, 'macbook') || str_contains($lower, 'notebook')) $catSlug = 'laptop';
        elseif (str_contains($lower, 'desktop') || str_contains($lower, 'ryzen 5') || str_contains($lower, 'core i5') || str_contains($lower, 'pc')) $catSlug = 'desktop';
        elseif (str_contains($lower, 'monitor') || str_contains($lower, 'display')) $catSlug = 'monitor';
        elseif (str_contains($lower, 'processor') || str_contains($lower, 'motherboard') || str_contains($lower, 'ram') || str_contains($lower, 'ssd') || str_contains($lower, 'gpu')) $catSlug = 'component';
        elseif (str_contains($lower, 'phone') || str_contains($lower, 'smartphone') || str_contains($lower, 'iphone') || str_contains($lower, 'samsung')) $catSlug = 'phone';
        elseif (str_contains($lower, 'camera') || str_contains($lower, 'dslr') || str_contains($lower, 'gimbal')) $catSlug = 'camera';
        elseif (str_contains($lower, 'router') || str_contains($lower, 'wifi') || str_contains($lower, 'switch')) $catSlug = 'networking';
        elseif (str_contains($lower, 'printer') || str_contains($lower, 'projector') || str_contains($lower, 'copier')) $catSlug = 'office-equipment';
        elseif (str_contains($lower, 'tv') || str_contains($lower, 'television')) $catSlug = 'tv';

        $price = $scrapedData['raw_price'] ? (float)$scrapedData['raw_price'] : 15000;
        $salePrice = round($price * 0.92);

        $images = $scrapedData['images'] ?? [];
        $mainImage = !empty($images[0]) ? $images[0] : 'https://images.unsplash.com/photo-1518611012118-696072aa579a?w=800';
        $gallery = array_slice($images, 1, 5);

        return [
            'success' => true,
            'data' => [
                'name' => $cleanTitle,
                'category_slug' => $catSlug,
                'price' => $price,
                'sale_price' => $salePrice,
                'short_description' => "100% Genuine {$cleanTitle} with official manufacturer warranty, high performance, and reliable build quality from SM Shop.",
                'description' => "Get the best price for {$cleanTitle} in Bangladesh only at SM Shop. We guarantee 100% authentic products with official warranty, super fast nationwide delivery to all 64 districts, and dedicated customer support.",
                'sku' => 'SM-' . strtoupper(substr($catSlug, 0, 3)) . '-' . rand(1000, 9999),
                'rating' => 4.9,
                'main_image' => $mainImage,
                'gallery_images' => $gallery,
                'reviews' => [
                    [
                        'user_name' => 'Tariqul Islam',
                        'rating' => 5,
                        'title' => '১০০% অরিজিনাল প্রোডাক্ট এবং দ্রুত ডেলিভারি!',
                        'comment' => 'SM Shop থেকে অর্ডার করেছিলাম, খুবই দ্রুত এবং অক্ষত প্যাকেজিং এ পেয়েছি। প্রোডাক্ট পারফরম্যান্স অসাধারণ।'
                    ],
                    [
                        'user_name' => 'Farhan Ahmed',
                        'rating' => 5,
                        'title' => 'Best Service from SM Shop',
                        'comment' => 'Authentic product with official warranty support. Highly recommended for computer and gadget lovers in BD.'
                    ]
                ]
            ]
        ];
    }

    /**
     * Save AI-structured product into Database
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
            'description' => $productData['description'] ?? null,
            'price' => (float) ($productData['price'] ?? 0),
            'sale_price' => !empty($productData['sale_price']) ? (float) $productData['sale_price'] : null,
            'stock' => rand(15, 60),
            'sku' => $productData['sku'] ?? ('SM-' . strtoupper(Str::random(6))),
            'image' => $productData['main_image'] ?? null,
            'gallery_images' => $productData['gallery_images'] ?? [],
            'is_featured' => true,
            'is_active' => true,
            'rating' => (float) ($productData['rating'] ?? 4.9),
            'reviews_count' => count($productData['reviews'] ?? []) ?: rand(15, 80),
        ]);

        // Insert Verified Customer Reviews
        if (!empty($productData['reviews'])) {
            foreach ($productData['reviews'] as $rev) {
                Review::create([
                    'product_id' => $product->id,
                    'user_name' => $rev['user_name'] ?? 'Verified Customer',
                    'user_email' => Str::slug($rev['user_name'] ?? 'customer') . '@example.com',
                    'rating' => $rev['rating'] ?? 5,
                    'title' => $rev['title'] ?? 'Great Product!',
                    'comment' => $rev['comment'] ?? 'Very satisfied with this purchase from SM Shop.',
                    'is_approved' => true,
                    'created_at' => now()->subDays(rand(1, 20)),
                ]);
            }
        }

        return $product;
    }

    /**
     * Process Single URL end-to-end: Scrape -> Rewrite -> Save
     */
    public function importFromUrl(string $url): array
    {
        $scraped = $this->scrapeUrl($url);
        if (!$scraped['success']) {
            return [
                'success' => false,
                'url' => $url,
                'error' => $scraped['error'] ?? 'Scraping failed.',
            ];
        }

        $rewritten = $this->rewriteWithAi($scraped);
        if (!$rewritten['success']) {
            return [
                'success' => false,
                'url' => $url,
                'error' => $rewritten['error'] ?? 'AI Processing failed.',
            ];
        }

        $product = $this->saveProduct($rewritten['data']);

        return [
            'success' => true,
            'url' => $url,
            'product_id' => $product->id,
            'name' => $product->name,
            'slug' => $product->slug,
            'price' => $product->price,
            'sale_price' => $product->sale_price,
            'category' => $product->category->name ?? 'N/A',
            'image_count' => 1 + count($product->gallery_images ?? []),
            'image' => $product->image,
            'product_url' => route('product.show', $product->slug),
            'sub_links' => $scraped['sub_links'] ?? [],
        ];
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
            $url = trim($url);
            if (empty($url) || !filter_var($url, FILTER_VALIDATE_URL)) {
                continue;
            }

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
     * Clean JSON string from markdown tags (```json ... ```)
     */
    protected function cleanJsonString(string $raw): string
    {
        $clean = trim($raw);
        $clean = preg_replace('/^```(?:json)?\s*/i', '', $clean);
        $clean = preg_replace('/\s*```$/i', '', $clean);
        return trim($clean);
    }

    /**
     * Helper to resolve relative URL to absolute URL
     */
    protected function resolveUrl(string $rel, string $base): string
    {
        if (str_starts_with($rel, '//')) {
            return 'https:' . $rel;
        }
        if (str_starts_with($rel, 'http://') || str_starts_with($rel, 'https://')) {
            return $rel;
        }
        $parse = parse_url($base);
        $host = ($parse['scheme'] ?? 'https') . '://' . ($parse['host'] ?? '');
        if (str_starts_with($rel, '/')) {
            return $host . $rel;
        }
        return $host . '/' . ltrim($rel, '/');
    }

    /**
     * Check if an image URL is valid and high-res
     */
    protected function isValidImageUrl(string $url): bool
    {
        if (empty($url) || !filter_var($url, FILTER_VALIDATE_URL)) {
            return false;
        }
        $lower = strtolower($url);
        // Exclude icons, avatars, flags, tracking gifs
        if (str_contains($lower, 'icon') || str_contains($lower, 'avatar') || str_contains($lower, 'logo') || str_contains($lower, 'flag') || str_contains($lower, '1x1') || str_contains($lower, 'spinner')) {
            return false;
        }
        return true;
    }
}
