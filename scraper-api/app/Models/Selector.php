<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Selector extends Model
{
    protected $fillable = ['site_id', 'article', 'title', 'postDescription', 'image', 'author', 'publishedDate', 'siteIcon']; // Add your columns here

    public function site(): BelongsTo
    {
        return $this->belongsTo(Site::class, 'site_id');
    }
}
