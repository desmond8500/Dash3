<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class QuantitatifRow extends Model
{
    use HasFactory;

    protected $fillable = [
        'quantitatif_id',
        'article_id',
        'quantite',
        'description'
    ];

    public function quantitatif(): BelongsTo
    {
        return $this->belongsTo(Quantitatif::class);
    }

    public function article(): BelongsTo
    {
        return $this->belongsTo(Article::class);
    }

    public function devices(): HasMany
    {
        return $this->hasMany(Device::class);
    }
}
