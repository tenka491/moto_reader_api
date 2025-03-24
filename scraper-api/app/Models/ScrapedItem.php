<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ScrapedItem extends Model
{
    //
    protected $fillable = ['siteId', 'siteIcon', 'siteDisplayName', 'title', 'description', 'url', 'author', 'imageSrc', 'imageAlt'];
}
