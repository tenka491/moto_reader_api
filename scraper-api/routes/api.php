<?php

use App\Http\Controllers\ScraperController;
use Illuminate\Http\Request;

Route::get('/items', [ScraperController::class, 'index']);
Route::get('/scrape', [ScraperController::class, 'scrape']);
