<?php

namespace App\Http\Controllers;

use App\Models\ScrapedItem;
use Illuminate\Support\Facades\Http;
use Symfony\Component\DomCrawler\Crawler;

class ScraperController extends Controller {
    public function index() {
        // Fetch all scraped items
        $items = ScrapedItem::all();
        return response()->json($items);
    }
    // TODO: Add Scrapper and really scrape a site

    public function scrape() {
        $response = Http::get('https://www.motorcyclenews.com/news/2025/march/trident-mcs-go-fund-me-after-fire-damage/');
        $crawler = new Crawler($response->body());


        $title = $crawler->filter('h1')->text(); // Adjust selector
        // $price = (float)$crawler->filter('.price')->text();
        // $url = $title->filter;

        $item = ScrapedItem::create([
            'title' => $title,
            // 'price' => $price,
            // 'url' => $url,
        ]);

        return response()->json($item, 201);
    }
}
// namespace App\Http\Controllers;

// use Illuminate\Http\Request;

// class ScraperController extends Controller
// {
//     /**
//      * Display a listing of the resource.
//      */
//     public function index()
//     {
//         //
//     }

//     /**
//      * Store a newly created resource in storage.
//      */
//     public function store(Request $request)
//     {
//         //
//     }

//     /**
//      * Display the specified resource.
//      */
//     public function show(string $id)
//     {
//         //
//     }

//     /**
//      * Update the specified resource in storage.
//      */
//     public function update(Request $request, string $id)
//     {
//         //
//     }

//     /**
//      * Remove the specified resource from storage.
//      */
//     public function destroy(string $id)
//     {
//         //
//     }
// }
