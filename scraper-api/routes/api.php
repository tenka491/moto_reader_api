<?php

use App\Http\Controllers\ScraperController;
use Illuminate\Http\Request;

Route::get('/items', [ScraperController::class, 'index']);
Route::get('/scrape', [ScraperController::class, 'scrape']);
Route::get('/scrape/{site_id}', [ScraperController::class, 'scrape']);
