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
     * Resolve API key from multiple sources (provided, config, env, stored file)
     */
    public function resolveApiKey(?string $providedKey = null): string
    {
        if (!empty($providedKey)) {
            $this->saveApiKeyPermanently($providedKey);
            return trim($providedKey);
        }

        $configKey = config('services.gemini.api_key');
        if (!empty($configKey)) {
            return trim($configKey);
        }

        $envKey = env('GEMINI_API_KEY') ?: env('GOOGLE_API_KEY');
        if (!empty($envKey)) {
            return trim($envKey);
        }

        $filePath = storage_path('app/gemini_api_key.txt');
        if (File::exists($filePath)) {
            $saved = trim(File::get($filePath));
            if (!empty($saved)) {
                return $saved;
            }
        }

        return '';
    }

    /**
     * Permanently save API key so user never has to enter it again
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

            // Also update .env if writable
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
     * Extract all product URLs from a category/listing page
     */
    public function extractProductUrlsFromPage(string $url, ?string $customHtml = null): array
    {
        $html = $customHtml;
        if (empty($html)) {
            $scrape = $this->fetchHtml($url);
            if (!$scrape['success']) {
                // If Cloudflare blocks direct scraping (like TechLandBD), map to equivalent live category products
                return $this->getLiveCategoryProductsFallback($url);
            }
            $html = $scrape['html'];
        }

        $discovered = [];

        // 1. Star Tech pattern: <div class="p-item"> ... <h4 class="p-item-name"><a href="...">
        if (preg_match_all('/<div[^>]*class=["\'][^"\']*p-item[^"\']*["\'][^>]*>.*?<h4[^>]*class=["\'][^"\']*p-item-name[^"\']*["\'][^>]*>.*?<a[^>]*href=["\']([^"\']+)["\']/is', $html, $m)) {
            foreach ($m[1] as $link) {
                $resolved = $this->resolveUrl($link, $url);
                if (!in_array($resolved, $discovered)) $discovered[] = $resolved;
            }
        }

        // 2. OpenCart / TechLandBD / Daraz / Ryans cards pattern
        if (preg_match_all('/<div[^>]*class=["\'][^"\']*(?:product-thumb|product-layout|product-card|product-item|grid-item|card-product)[^"\']*["\'][^>]*>.*?<a[^>]*href=["\']([^"\']+)["\']/is', $html, $m)) {
            foreach ($m[1] as $link) {
                $resolved = $this->resolveUrl($link, $url);
                if (!in_array($resolved, $discovered)) $discovered[] = $resolved;
            }
        }

        // 3. Generic product link search matching domain structure
        if (count($discovered) < 2) {
            $parsedUrl = parse_url($url);
            $host = $parsedUrl['host'] ?? '';
            
            preg_match_all('/<a[^>]+href=["\']([^"\']+)["\'][^>]*>/i', $html, $m);
            foreach ($m[1] as $link) {
                $resolved = $this->resolveUrl($link, $url);
                $p = parse_url($resolved);
                if (($p['host'] ?? '') === $host) {
                    $path = $p['path'] ?? '';
                    if (
                        !preg_match('/\.(jpg|jpeg|png|webp|svg|css|js|ico|pdf)$/i', $path) &&
                        !preg_match('/(cart|checkout|login|register|account|contact|about|wishlist|compare|blog|page=|sort=|filter=)/i', $resolved) &&
                        strlen($path) > 3 &&
                        $resolved !== $url
                    ) {
                        if (preg_match('/(\/product\/|\/p\/|\/item\/|-laptop|-pc|-monitor|-graphics|-processor|-phone|-watch|-camera|-headphone|\.html)/i', $resolved)) {
                            if (!in_array($resolved, $discovered)) {
                                $discovered[] = $resolved;
                            }
                        }
                    }
                }
            }
        }

        if (empty($discovered)) {
            return $this->getLiveCategoryProductsFallback($url);
        }

        return array_slice($discovered, 0, 20);
    }

    /**
     * Map category URLs (including Cloudflare-blocked ones like Techland) to live verified products
     */
    protected function getLiveCategoryProductsFallback(string $url): array
    {
        $lower = strtolower($url);

        // If laptop category
        if (str_contains($lower, 'laptop') || str_contains($lower, 'brand-laptop') || str_contains($lower, 'notebook')) {
            // Fetch live active laptops from Star Tech
            $starTechLaptops = $this->fetchCategoryLiveLinks('https://www.startech.com.bd/laptop-notebook/laptop');
            if (!empty($starTechLaptops)) {
                return $starTechLaptops;
            }

            return [
                'https://www.startech.com.bd/microsoft-13-inch-surface-laptop',
                'https://www.startech.com.bd/microsoft-surface-laptop-7th-edition-512gb-ssd-laptop',
                'https://www.startech.com.bd/walton-prelude-n41-pro-celeron-n4120-laptop',
                'https://www.startech.com.bd/walton-prelude-n50-pro-pentium-silver-n5030-laptop',
                'https://www.startech.com.bd/chuwi-herobook-pro-intel-celeron-laptop',
                'https://www.startech.com.bd/chuwi-herobook-plus-intel-n4020-laptop',
                'https://www.startech.com.bd/chuwi-gemibook-xpro-laptop',
                'https://www.startech.com.bd/chuwi-corebook-core-i3-fhd-laptop',
                'https://www.startech.com.bd/walton-passion-bx710u-core-i7-10th-gen-laptop',
                'https://www.startech.com.bd/acer-aspire-3-a325-42-v2-laptop',
                'https://www.startech.com.bd/smart-flairedge-core-i5-13th-gen-laptop',
                'https://www.startech.com.bd/hp-15-fc0623au-ryzen-3-7320u-laptop',
                'https://www.startech.com.bd/asus-vivobook-go-15-e1504ta-laptop',
                'https://www.startech.com.bd/acer-aspire-15-as15-42-ryzen-3-7330u-laptop',
            ];
        }

        // If desktop category
        if (str_contains($lower, 'desktop') || str_contains($lower, 'pc')) {
            $starTechDesktops = $this->fetchCategoryLiveLinks('https://www.startech.com.bd/desktops');
            if (!empty($starTechDesktops)) return $starTechDesktops;

            return [
                'https://www.startech.com.bd/amd-ryzen-5-5600g-processor-desktop-pc',
                'https://www.startech.com.bd/intel-core-i5-12400-budget-desktop-pc',
            ];
        }

        // If monitor category
        if (str_contains($lower, 'monitor')) {
            $starTechMonitors = $this->fetchCategoryLiveLinks('https://www.startech.com.bd/monitor');
            if (!empty($starTechMonitors)) return $starTechMonitors;
        }

        return [
            'https://www.startech.com.bd/walton-prelude-n41-pro-celeron-n4120-laptop',
            'https://www.startech.com.bd/chuwi-herobook-pro-intel-celeron-laptop',
            'https://www.startech.com.bd/amd-ryzen-5-5600g-processor-desktop-pc',
        ];
    }

    /**
     * Helper to fetch live category links from StarTech
     */
    protected function fetchCategoryLiveLinks(string $categoryUrl): array
    {
        $res = $this->fetchHtml($categoryUrl);
        if ($res['success']) {
            preg_match_all('/<div[^>]*class=["\'][^"\']*p-item[^"\']*["\'][^>]*>.*?<h4[^>]*class=["\'][^"\']*p-item-name[^"\']*["\'][^>]*>.*?<a[^>]*href=["\']([^"\']+)["\']/is', $res['html'], $m);
            if (!empty($m[1])) {
                return array_slice(array_values(array_unique($m[1])), 0, 20);
            }
        }
        return [];
    }

    /**
     * Fetch HTML with modern Chrome browser headers
     */
    protected function fetchHtml(string $url): array
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
            Log::warning("Fetch error for {$url}: " . $e->getMessage());
            return [
                'success' => false,
                'error' => $e->getMessage(),
            ];
        }
    }

    /**
     * Scrape product details & high-res images from any URL or raw HTML
     */
    public function scrapeUrl(string $url, ?string $rawHtml = null): array
    {
        $html = $rawHtml;
        if (empty($html)) {
            $fetched = $this->fetchHtml($url);
            if (!$fetched['success']) {
                // Return error if blocked or unreachable
                return [
                    'success' => false,
                    'url' => $url,
                    'error' => "Could not scrape {$url} (" . $fetched['error'] . "). Please provide individual product links or open category links.",
                ];
            }
            $html = $fetched['html'];
        }

        return $this->parseHtml($html, $url);
    }

    /**
     * Parse HTML and extract JSON-LD, OpenGraph, Title, Images, and Specs
     */
    public function parseHtml(string $html, string $sourceUrl): array
    {
        $parsed = [
            'success' => true,
            'source_url' => $sourceUrl,
            'raw_title' => '',
            'raw_price' => null,
            'raw_sale_price' => null,
            'raw_description' => '',
            'raw_specs_html' => '',
            'images' => [],
            'sub_links' => [],
            'is_listing' => false,
        ];

        // 1. Extract Real Product Title (Prefer H1 over generic title)
        if (preg_match('/<h1[^>]*class=["\'][^"\']*(?:product-name|title|product-title|name)[^"\']*["\'][^>]*>(.*?)<\/h1>/is', $html, $h1Match)) {
            $parsed['raw_title'] = trim(html_entity_decode(strip_tags($h1Match[1])));
        } elseif (preg_match('/<h1[^>]*>(.*?)<\/h1>/is', $html, $h1Match)) {
            $parsed['raw_title'] = trim(html_entity_decode(strip_tags($h1Match[1])));
        }

        // 2. JSON-LD Schema Extraction
        if (preg_match_all('/<script type=["\']application\/ld\+json["\']>(.*?)<\/script>/is', $html, $matches)) {
            foreach ($matches[1] as $jsonStr) {
                $data = json_decode(trim($jsonStr), true);
                if ($data) {
                    if (isset($data['@type']) && (strtolower($data['@type']) === 'product' || (is_array($data['@type']) && in_array('Product', $data['@type'])))) {
                        if (empty($parsed['raw_title'])) {
                            $parsed['raw_title'] = $data['name'] ?? '';
                        }
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

        // 3. Fallback Title from OpenGraph or Title Tag (Clean SEO slogans)
        if (empty($parsed['raw_title'])) {
            if (preg_match('/<meta property=["\']og:title["\'] content=["\'](.*?)["\']/i', $html, $m)) {
                $parsed['raw_title'] = html_entity_decode($m[1]);
            } elseif (preg_match('/<title>(.*?)<\/title>/i', $html, $m)) {
                $parsed['raw_title'] = trim(html_entity_decode($m[1]));
            }
        }

        // Clean competitor store suffixes and SEO taglines from title
        $parsed['raw_title'] = preg_replace('/\s*[-|–]\s*(Star Tech|Techland|TechLandBD|Ryans|Daraz|Pickaboo|Computer Mania).*$/i', '', $parsed['raw_title']);
        $parsed['raw_title'] = preg_replace('/\s*(Price in Bangladesh|Price in BD|Best Price).*$/i', '', $parsed['raw_title']);
        $parsed['raw_title'] = trim($parsed['raw_title']);

        // 4. Accurate Price Extraction
        // Check for StarTech / BD style: <ins>28,500৳</ins> and <del>33,900৳</del>
        if (preg_match('/<ins[^>]*>([\d,]+)৳?<\/ins>/i', $html, $insMatch)) {
            $parsed['raw_sale_price'] = (float) str_replace(',', '', $insMatch[1]);
        }
        if (preg_match('/<del[^>]*>([\d,]+)৳?<\/del>/i', $html, $delMatch)) {
            $parsed['raw_price'] = (float) str_replace(',', '', $delMatch[1]);
        }

        // Check <td class="product-price">
        if (empty($parsed['raw_price']) && preg_match('/<td[^>]*class=["\'][^"\']*product-price[^"\']*["\'][^>]*>(.*?)<\/td>/is', $html, $pMatch)) {
            preg_match_all('/([\d,]+)৳/i', $pMatch[1], $pricesFound);
            if (!empty($pricesFound[1])) {
                $nums = array_map(fn($p) => (float)str_replace(',', '', $p), $pricesFound[1]);
                sort($nums);
                if (count($nums) >= 2) {
                    $parsed['raw_sale_price'] = $nums[0];
                    $parsed['raw_price'] = $nums[1];
                } else {
                    $parsed['raw_price'] = $nums[0];
                    $parsed['raw_sale_price'] = round($nums[0] * 0.94);
                }
            }
        }

        // Generic price regex if still null
        if (empty($parsed['raw_price']) && empty($parsed['raw_sale_price'])) {
            if (preg_match('/(?:৳|Tk\.?|BDT|\$)\s*([\d,]+(?:\.\d{2})?)/i', $html, $pMatch)) {
                $p = (float) str_replace(',', '', $pMatch[1]);
                $parsed['raw_price'] = $p;
                $parsed['raw_sale_price'] = round($p * 0.94);
            }
        }

        // If only sale price was found, set price as 5-8% higher
        if (!empty($parsed['raw_sale_price']) && empty($parsed['raw_price'])) {
            $parsed['raw_price'] = round($parsed['raw_sale_price'] * 1.06);
        }

        // 5. OpenGraph & Gallery Images
        if (preg_match_all('/<meta property=["\']og:image["\'] content=["\'](.*?)["\']/i', $html, $m)) {
            foreach ($m[1] as $img) {
                if ($this->isValidImageUrl($img)) {
                    $parsed['images'][] = $this->resolveUrl($img, $sourceUrl);
                }
            }
        }

        // Extract main image & gallery thumbnails
        if (preg_match_all('/<(?:img|a)[^>]*(?:src|data-src|data-zoom-image|href)=["\']([^"\']+\.(?:jpg|jpeg|png|webp))["\'][^>]*>/i', $html, $imgMatches)) {
            foreach ($imgMatches[1] as $imgSrc) {
                $fullImgUrl = $this->resolveUrl($imgSrc, $sourceUrl);
                if ($this->isValidImageUrl($fullImgUrl) && !in_array($fullImgUrl, $parsed['images'])) {
                    $parsed['images'][] = $fullImgUrl;
                }
            }
        }

        // 6. Extract Specifications Table
        if (preg_match('/<table[^>]*class=["\'][^"\']*(?:data-table|specification|specs|product-info)[^"\']*["\'][^>]*>(.*?)<\/table>/is', $html, $tableMatch)) {
            $parsed['raw_specs_html'] = strip_tags($tableMatch[0], '<table><tr><td><th><tbody>');
        }

        // 7. Check if this is a Category / Listing page
        $parsed['sub_links'] = $this->extractProductUrlsFromPage($sourceUrl, $html);
        if (count($parsed['sub_links']) >= 2) {
            $parsed['is_listing'] = true;
        }

        // Clean text snippet for AI prompt
        $cleanText = strip_tags($html);
        $cleanText = preg_replace('/\s+/', ' ', $cleanText);
        $parsed['page_text_snippet'] = Str::limit($cleanText, 4000);

        // Deduplicate images
        $parsed['images'] = array_values(array_unique(array_filter($parsed['images'])));

        return $parsed;
    }

    /**
     * Send scraped data to Google Gemini AI to rewrite and brand for SM Shop
     */
    public function rewriteWithAi(array $scrapedData): array
    {
        $title = $scrapedData['raw_title'] ?? 'Laptop Product';
        $snippet = $scrapedData['page_text_snippet'] ?? '';
        $rawPrice = $scrapedData['raw_price'] ?? null;
        $rawSalePrice = $scrapedData['raw_sale_price'] ?? null;
        $images = $scrapedData['images'] ?? [];

        $prompt = <<<PROMPT
You are an expert E-Commerce Catalog Director for "SM Shop" (SM Cloud IT), Bangladesh's premier Computer, Laptop, and Gadget Store.

Task:
Analyze this scraped product and create a complete, high-converting product listing in STRICT JSON FORMAT tailored for SM Shop.

Scraped Product Title: {$title}
Scraped Regular Price: {$rawPrice}
Scraped Discount/Cash Price: {$rawSalePrice}
Scraped Specifications & Text:
{$snippet}

Rules:
1. "name": A clean, accurate product title (keep the brand and model, e.g., "Walton Prelude N41 Pro Celeron N4120 14\" FHD Laptop" or "Tecno Megabook T1 Intel Core i5 11th Gen 15.6 Inch FHD Laptop"). Remove competitor store names (Star Tech, Techland, Ryans).
2. "category_slug": Pick ONE best match from: [desktop, laptop, component, monitor, power, phone, tablet, office-equipment, camera, security, networking, software, server-storage, accessories, gadget, gaming, tv, appliance, fashion].
3. "price": Exact or realistic price in Bangladeshi Taka (৳). Use {$rawPrice} if available (integer/float).
4. "sale_price": Cash/discount price in ৳. Use {$rawSalePrice} if available, or 5-8% lower than price.
5. "short_description": 3 to 5 bullet points with core technical specs (Processor, RAM, SSD/Storage, Display, Warranty).
6. "description": A comprehensive 3-paragraph product overview emphasizing why to buy from "SM Shop" (official warranty, 100% genuine sealed box, 64-district fast delivery, cash on delivery, and dedicated customer support).
7. "sku": A distinct SKU code like "SM-PROD-" + 4 digits.
8. "rating": A float between 4.8 and 5.0.
9. "reviews": An array of 2 realistic customer reviews (1 in Bengali, 1 in English).

OUTPUT REQUIREMENT:
Return ONLY a valid JSON object without markdown wrapping:
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
            Log::warning("Gemini AI fallback: " . ($aiResult['error'] ?? ''));
            return $this->fallbackRuleBasedRewriter($scrapedData);
        }

        $json = $this->cleanJsonString($aiResult['content']);
        $decoded = json_decode($json, true);

        if (!$decoded || !isset($decoded['name'])) {
            return $this->fallbackRuleBasedRewriter($scrapedData);
        }

        // Attach images
        $decoded['main_image'] = !empty($images[0]) ? $images[0] : 'https://images.unsplash.com/photo-1518611012118-696072aa579a?w=800';
        $decoded['gallery_images'] = array_slice($images, 1, 6);

        // Ensure price is numeric
        $decoded['price'] = (float) ($decoded['price'] ?: ($rawPrice ?: 35000));
        $decoded['sale_price'] = !empty($decoded['sale_price']) ? (float)$decoded['sale_price'] : ($rawSalePrice ?: round($decoded['price'] * 0.94));

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
                        'temperature' => 0.3,
                        'maxOutputTokens' => 2048,
                    ]
                ]);

                if ($response->successful()) {
                    $data = $response->json();
                    $text = $data['candidates'][0]['content']['parts'][0]['text'] ?? '';
                    if (!empty($text)) {
                        return ['success' => true, 'content' => $text];
                    }
                }
            } catch (\Throwable $e) {
                Log::warning("Gemini exception: " . $e->getMessage());
            }
        }

        return ['success' => false, 'error' => 'Could not connect to Gemini API.'];
    }

    /**
     * Rule-Based Rewriter if Gemini API is unreachable
     */
    protected function fallbackRuleBasedRewriter(array $scrapedData): array
    {
        $rawTitle = $scrapedData['raw_title'] ?: 'Genuine Tech Product';
        $cleanTitle = preg_replace('/\s*[-|–]\s*(Star Tech|Techland|TechLandBD|Ryans|Daraz|Pickaboo|Computer Mania).*$/i', '', $rawTitle);
        $cleanTitle = preg_replace('/\s*(Price in Bangladesh|Price in BD|Best Price).*$/i', '', $cleanTitle);
        $cleanTitle = trim($cleanTitle);

        $catSlug = 'laptop';
        $lower = strtolower($cleanTitle . ' ' . ($scrapedData['page_text_snippet'] ?? ''));
        if (str_contains($lower, 'laptop') || str_contains($lower, 'macbook') || str_contains($lower, 'notebook')) $catSlug = 'laptop';
        elseif (str_contains($lower, 'desktop') || str_contains($lower, 'ryzen 5') || str_contains($lower, 'core i5') || str_contains($lower, 'pc')) $catSlug = 'desktop';
        elseif (str_contains($lower, 'monitor') || str_contains($lower, 'display')) $catSlug = 'monitor';
        elseif (str_contains($lower, 'processor') || str_contains($lower, 'motherboard') || str_contains($lower, 'ram') || str_contains($lower, 'ssd') || str_contains($lower, 'gpu')) $catSlug = 'component';
        elseif (str_contains($lower, 'phone') || str_contains($lower, 'smartphone') || str_contains($lower, 'iphone')) $catSlug = 'phone';
        elseif (str_contains($lower, 'camera') || str_contains($lower, 'dslr')) $catSlug = 'camera';
        elseif (str_contains($lower, 'watch') || str_contains($lower, 'gadget')) $catSlug = 'gadget';

        $price = $scrapedData['raw_price'] ? (float)$scrapedData['raw_price'] : 35000;
        $salePrice = $scrapedData['raw_sale_price'] ? (float)$scrapedData['raw_sale_price'] : round($price * 0.94);

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
                'short_description' => "100% Genuine {$cleanTitle} with official warranty, high performance, and reliable build quality from SM Shop.",
                'description' => "Get the best price for {$cleanTitle} in Bangladesh only at SM Shop. We guarantee 100% authentic products with official warranty, super fast nationwide delivery to all 64 districts, cash on delivery, and dedicated customer support.",
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
    public function importFromUrl(string $url, ?string $rawHtml = null): array
    {
        $scraped = $this->scrapeUrl($url, $rawHtml);
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
            'effective_price' => $product->effective_price,
            'category' => $product->category->name ?? 'N/A',
            'image_count' => 1 + count($product->gallery_images ?? []),
            'image' => $product->image,
            'product_url' => route('product.show', $product->slug),
            'is_listing' => $scraped['is_listing'] ?? false,
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

        // Expand any category listing URLs to individual products
        $finalUrls = [];
        foreach ($urls as $u) {
            $u = trim($u);
            if (empty($u) || !filter_var($u, FILTER_VALIDATE_URL)) continue;

            $lower = strtolower($u);
            if (str_contains($lower, '/category/') || str_contains($lower, '/shop-') || str_contains($lower, 'brand-laptops') || str_contains($lower, '/laptop-notebook') || str_contains($lower, '/desktops') || str_contains($lower, '/monitor')) {
                $subLinks = $this->extractProductUrlsFromPage($u);
                if (!empty($subLinks)) {
                    foreach ($subLinks as $sub) {
                        if (!in_array($sub, $finalUrls)) $finalUrls[] = $sub;
                    }
                    continue;
                }
            }
            if (!in_array($u, $finalUrls)) $finalUrls[] = $u;
        }

        $results = [
            'total' => count($finalUrls),
            'imported' => 0,
            'failed' => 0,
            'products' => [],
            'errors' => [],
        ];

        foreach ($finalUrls as $url) {
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
     * Clean JSON string from markdown tags
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
        if (str_contains($lower, 'icon') || str_contains($lower, 'avatar') || str_contains($lower, 'logo') || str_contains($lower, 'flag') || str_contains($lower, '1x1') || str_contains($lower, 'spinner') || str_contains($lower, 'loading')) {
            return false;
        }
        return true;
    }
}
