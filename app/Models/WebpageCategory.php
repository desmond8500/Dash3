<?php

namespace App\Models;

use App\Traits\searchTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class WebpageCategory extends Model
{
    use searchTrait;

    protected $fillable = [
        'name',
        'description'
    ];

    public function webpages(): HasMany
    {
        return $this->hasMany(Webpage::class, 'webpage_category_id');
    }
}
