<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProviderDocument extends Model
{
    protected $fillable = ['provider_id', 'name', 'category', 'path'];

    public function provider(): BelongsTo
    {
        return $this->belongsTo(Provider::class);
    }
}
