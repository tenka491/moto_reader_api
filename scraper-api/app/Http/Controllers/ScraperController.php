<?php

namespace App\Http\Controllers;

use App\Models\ScrapedItem;
use App\Models\Site;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Symfony\Component\DomCrawler\Crawler;

class ScraperController extends Controller {
    public function index() {
        // Fetch all scraped items
        $items = ScrapedItem::all();
        return response()->json($items);
    }

    public function scrape($site_id)
    {
        if(!$site_id) {
            Log::error("site id was not passed.");
            return response()->json(['error' => 'Must send site id'], 400);
        }
        Log::debug("Testing log for site ID: {$site_id}");
        $site = Site::find($site_id);
        if (!$site) {
            Log::error("Site not found: {$id}");
            return response()->json(['error' => 'Site not found'], 404);
        }
        $articles = [];
        try {
            //code...
            if ($site->srcType === 'rss') {
                $articles = $this->scrapeRss($site);
            } else {
                $articles = $this->scrapeHtml($site);
            }

            foreach ($articles as $articleData) {
                $existingArticle = ScrapedItem::where('url', $articleData['url'])->first();
                if ($existingArticle) {
                    // Update the existing article
                    $existingArticle->update($articleData);
                } else {
                    // Create a new article
                    ScrapedItem::create($articleData);
                }
            }
            return response()->json(['articles' => $articles], 201);
        } catch (\Exception $e) {
            Log::error("Scrape failed for site {$site->id}: {$e->getMessage()}");
            return response()->json(['error' => 'Failed to scrape site'], 500);
        }


        // $feedSelector = $site->selectors->where('pageType', 'feed')->first();
        // $articleSelector = $site->selectors->where('pageType', 'article')->first();

        // // Step 1: Crawl the list page
        // $response = Http::get($site->url);

        // if ($response->failed()) {
        //     return response()->json(['error' => 'Failed to fetch URL'], 400);
        // }

        // $listCrawler = new Crawler($response->body());

        // // Extract article URLs based on selector type
        // $articleUrls = [];
        // if ($site->srcType === 'html') {
        //     $articleUrls = $listCrawler->filter($feedSelector->title)->links();
        //     $articleUrls = array_map(fn($link) => $link->getUri(), $articleUrls);

        // } elseif ($site->srcType === 'rss') {
        //     $xml = simplexml_load_string($response->body());
        //     $items = $xml->xpath('//item/link');
        //     $articleUrls = array_map('strval', $items);
        // }
        // if (empty($articleUrls)) {
        //     return response()->json($articleUrls, 404);
        // }
        // // Step 2: Scrape each article URL
        // $scrapedItems = [];
        // foreach ($articleUrls as $articleUrl) {
        //     $articleResponse = Http::get($articleUrl);
        //     $articleCrawler = new Crawler($articleResponse->body());

        //     // Basic scraping (customize selectors for article pages)
        //     try {
        //         $title = $articleCrawler->filter($articleSelector->title)->text();
        //         $author = $articleCrawler->filter($articleSelector->author)->text();
        //         $imgs = $articleCrawler->filter($articleSelector->image)->first();
        //         $firstImgSrc = $imgs->attr('src');
        //         $firstImgAlt = trim($imgs->attr('alt')) ?: 'No Alt';
        //         $siteIcon = $articleCrawler->filter($articleSelector->siteIcon)->attr('href') ?? 'No Icon';
        //     } catch (\Exception $e) {
        //         $title = 'Untitled'; // Fallback
        //     }

        //     $item = ScrapedItem::create([
        //         'siteId' => $site_id,
        //         'siteIcon' => $siteIcon,
        //         'siteDisplayName' => $site->displayName,
        //         'url' => $articleUrl,
        //         'title' => $title,
        //         'description' => '',
        //         'author' => $author,
        //         'imageSrc'=> $firstImgSrc,
        //         'imageAlt' => $firstImgAlt,
        //         'baseUrl' => $site->baseUrl
        //     ]);

        //     $scrapedItems[] = $item;
        // }

        // // Step 3: Return all scraped items
        // return response()->json($scrapedItems, 201);
    }

    private function scrapeHtml($site) {
        $feedSelector = $site->selectors->where('pageType', 'feed')->first();
        $articleSelector = $site->selectors->where('pageType', 'article')->first();

        $response = Http::get($site->url);
        $listCrawler = new Crawler($response->body());

        // Get list of urls from main articles listings page
        $articleUrls = [];
        $articleUrls = $listCrawler->filter($feedSelector->title)->links();
        $articleUrls = array_map(fn($link) => $link->getUri(), $articleUrls);

        $articles = [];
        // Try common article selectors (adjust based on sites)
        foreach ($articleUrls as $articleUrl) {
            # code...
            $articleResponse = Http::get($articleUrl);
            $articleCrawler = new Crawler($articleResponse->body());

            // Basic scraping (customize selectors for article pages)
            try {
                $title = $articleCrawler->filter($articleSelector->title)->text();
                $author = $articleCrawler->filter($articleSelector->author)->text();
                $imgs = $articleCrawler->filter($articleSelector->image)->first();
                $firstImgSrc = $imgs->attr('src');
                $firstImgAlt = trim($imgs->attr('alt')) ?: 'No Alt';
                $siteIcon = $articleCrawler->filter($articleSelector->siteIcon)->attr('href') ?? 'No Icon';
            } catch (\Exception $e) {
                $title = 'Untitled'; // Fallback
            }

            $articles[] = [
                'siteId' => $site->id,
                'siteIcon' => $siteIcon,
                'siteDisplayName' => $site->displayName,
                'url' => $articleUrl,
                'title' => $title,
                'description' => '',
                'author' => $author,
                'imageSrc'=> $firstImgSrc,
                'imageAlt' => $firstImgAlt,
                'baseUrl' => $site->baseUrl
            ];
        };

        return $articles;
    }

    private function scrapeRss($site) {
        $xml = simplexml_load_file($site->url);
        if ($xml === false) {
            throw new \Exception("Failed to load RSS feed");
        }

        $articles = [];
        foreach ($xml->channel->item as $item) {
            $articles[] = [
                'title' => (string) $item->title,
                'url' => (string) $item->link,
                'content' => (string) $item->description,
            ];
        }
        return $articles;
    }
}
