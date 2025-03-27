<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Site;

class SitesTableSeeder extends Seeder
{
    public function run(): void
    {
        $sites = [
            [
                'url' => 'https://www.motorcyclenews.com/news/',
                'srcType' => 'html',
                'displayName' => 'Motorcycle News',
                'baseUrl' => 'https://www.motorcyclenews.com',
            ],
            [
                'url' => 'https://www.motorcyclistonline.com/motorcycle-news/',
                'srcType' => 'rss',
                'displayName' => 'Motorcyclist Online',
                'baseUrl' => 'https://www.motorcyclistonline.com',
            ],
            [
                'url' => 'https://blog.motorcycle.com/',
                'srcType' => 'rss',
                'displayName' => 'Motorcycle.com',
                'baseUrl' => '',
            ],
            [
                'url' => 'https://www.asphaltandrubber.com/feed/',
                'srcType' => 'rss',
                'displayName' => 'Asphalt and Rubber',
                'baseUrl' => '',
            ],
        ];

        foreach ($sites as $site) {
            Site::create($site);
        }
    }
}
