<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Site extends Model
{
    protected $fillable = ['url', 'srcType', 'displayName', 'baseUrl'];

    public function selectors(): HasMany
    {
        return $this->hasMany(Selector::class, 'site_id');
    }
}
