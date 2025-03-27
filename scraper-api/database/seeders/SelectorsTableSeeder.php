<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Site;
use App\Models\Selector;

class SelectorsTableSeeder extends Seeder
{
    public function run(): void
    {
        // Fetch existing sites (from SitesTableSeeder)
        $sites = Site::all();

        if ($sites->isEmpty()) {
            echo "No sites found. Run SitesTableSeeder first.\n";
            return;
        }

        $selectors = [
            // Site 1: Example News (html)
            [
                'site_id' => $sites[0]->id,
                'pageType' => 'feed',
                'article' => '.article-landing__article',
                'title' => '.article-listing__article__heading > a',
                'postDescription' => 'p:last',
                'image' => '.thumbnail',
                'author' => 'article-landing__article__info__author',
                'publishedDate' => '.article-landing__article__info__date',
                'siteIcon' => '[rel="shortcut icon"]'
            ],
            [
                'site_id' => $sites[0]->id,
                'pageType' => 'article',
                'article' => 'article',
                'title' => 'h1',
                'postDescription' => 'p:last',
                'image' => 'article > img',
                'author' => '.author-info__name > a',
                'publishedDate' => '.article__dates__date',
                'siteIcon' => '[rel="shortcut icon"]'
            ],
            // Site 2: Example Blog RSS (rss)
            [
                'site_id' => $sites[1]->id,
                'pageType' => 'feed',
                'article' => '.flex-feature .container',
                'title' => '.feature-listing > .headline',
                'postDescription' => '.subtitle',
                'image' => '',
                'author' => '',
                'publishedDate' => '',
                'siteIcon' => '', // Common for RSS
            ],
            // Site 3: Tech Articles (html)
            [
                'site_id' => $sites[2]->id,
                'pageType' => 'feed',
                'article' => 'article.text_wrapper',
                'title' => '.text .main-column-text > h3 > a',
                'postDescription' => '.main-column-text-wrapper > p',
                'image' => 'a.lazyloaded',
                'author' => '',
                'publishedDate' => '',
                'siteIcon' => ''
            ],
        ];

        foreach ($selectors as $selector) {
            Selector::create($selector);
        }
    }
}
