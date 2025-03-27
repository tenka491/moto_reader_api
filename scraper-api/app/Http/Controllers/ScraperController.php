<?php

namespace App\Http\Controllers;

use App\Models\ScrapedItem;
use App\Models\Site;
use Illuminate\Support\Facades\Http;
use Symfony\Component\DomCrawler\Crawler;

class ScraperController extends Controller {
    public function index() {
        // Fetch all scraped items
        $items = ScrapedItem::all();
        return response()->json($items);
    }

    public function scrape($site_id)
    {
        // Fetch site with selectors
        $site = Site::with('selectors')->findOrFail($site_id);
        $feedSelector = $site->selectors->where('pageType', 'feed')->first();
        $articleSelector = $site->selectors->where('pageType', 'article')->first();

        // Step 1: Crawl the list page
        $response = Http::get($site->url);

        if ($response->failed()) {
            return response()->json(['error' => 'Failed to fetch URL'], 400);
        }

        $listCrawler = new Crawler($response->body());

        // Extract article URLs based on selector type
        $articleUrls = [];
        if ($site->srcType === 'html') {
            $articleUrls = $listCrawler->filter($feedSelector->title)->links();
            $articleUrls = array_map(fn($link) => $link->getUri(), $articleUrls);

        } elseif ($site->srcType === 'rss') {
            $xml = simplexml_load_string($response->body());
            $items = $xml->xpath('//item/link');
            $articleUrls = array_map('strval', $items);
        }
        if (empty($articleUrls)) {
            return response()->json($articleUrls, 404);
        }
        // // Step 2: Scrape each article URL
        $scrapedItems = [];
        foreach ($articleUrls as $articleUrl) {
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

            $item = ScrapedItem::create([
                'siteId' => $site_id,
                'siteIcon' => $siteIcon,
                'siteDisplayName' => $site->displayName,
                'url' => $articleUrl,
                'title' => $title,
                'description' => '',
                'author' => $author,
                'imageSrc'=> $firstImgSrc,
                'imageAlt' => $firstImgAlt,
                'baseUrl' => $site->baseUrl
            ]);

            $scrapedItems[] = $item;
        }

        // // Step 3: Return all scraped items
        return response()->json($scrapedItems, 201);
    }
}
