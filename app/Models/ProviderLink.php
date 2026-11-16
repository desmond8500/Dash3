<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProviderLink extends Model
{
    protected $fillable = ['provider_id', 'name', 'url', 'description'];

    public function provider(): BelongsTo
    {
        return $this->belongsTo(Provider::class);
    }
}
