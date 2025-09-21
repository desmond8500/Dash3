<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Webpage extends Model
{
    protected $fillable = [
        'webpage_category_id',
        'logo',
        'name',
        'url',
        'description',
        'favorite',
    ];

    public function categories(): BelongsTo
    {
        return $this->belongsTo(WebpageCategory::class, 'webpage_category_id');
    }
}
