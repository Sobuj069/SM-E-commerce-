<?php

namespace App\Console\Commands;

use App\Services\AiProductImporterService;
use Illuminate\Console\Command;

class AiImportProductsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'product:ai-import 
                            {urls?* : Product or category web URLs to scrape and import}
                            {--file= : Path to text file containing URLs (one per line)}
                            {--purge : Purge demo products before importing}
                            {--key= : Google Gemini API Key}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Scrape any e-commerce product URL, extract all images, and use Google Gemini AI to rewrite and import into SM Shop';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $this->info("==========================================================");
        $this->info("🤖 SM Shop AI Bulk Product Importer & Content Rewriter");
        $this->info("==========================================================");

        $urls = $this->argument('urls') ?: [];
        $file = $this->option('file');
        $purge = $this->option('purge');
        $apiKey = $this->option('key') ?: config('services.gemini.api_key');

        if ($file && file_exists($file)) {
            $fileLines = file($file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
            $urls = array_merge($urls, $fileLines);
        }

        if (empty($urls)) {
            $input = $this->ask("Please enter product URL(s) to import (separated by commas or spaces)");
            if (!empty($input)) {
                $urls = preg_split('/[\s,]+/', $input, -1, PREG_SPLIT_NO_EMPTY);
            }
        }

        if (empty($urls)) {
            $this->error("No valid URLs provided to import.");
            return Command::FAILURE;
        }

        $importer = new AiProductImporterService($apiKey);

        if ($purge || $this->confirm("Do you want to purge all demo/existing products first?", false)) {
            $this->warn("Purging old demo products from database...");
            $cleared = $importer->purgeProducts();
            $this->info("Cleared {$cleared} old products.");
        }

        $this->info("Starting AI import for " . count($urls) . " URL(s)...");
        $progressBar = $this->output->createProgressBar(count($urls));
        $progressBar->start();

        $successCount = 0;
        $failedCount = 0;

        foreach ($urls as $url) {
            $url = trim($url);
            if (empty($url)) continue;

            $res = $importer->importFromUrl($url);
            if ($res['success']) {
                $successCount++;
                $this->newLine();
                $this->info("✓ [IMPORTED] {$res['name']} ({$res['price']}৳) - {$res['image_count']} image(s)");
            } else {
                $failedCount++;
                $this->newLine();
                $this->error("✗ [FAILED] {$url} - Error: " . ($res['error'] ?? 'Unknown error'));
            }
            $progressBar->advance();
        }

        $progressBar->finish();
        $this->newLine(2);

        $this->info("==========================================================");
        $this->info("🎉 Import Finished! Success: {$successCount}, Failed: {$failedCount}");
        $this->info("==========================================================");

        return Command::SUCCESS;
    }
}
