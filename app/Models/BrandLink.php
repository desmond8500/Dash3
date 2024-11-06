<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BrandLink extends Model
{
    use HasFactory;

    protected $fillable = [
        'brand_id',
        'name',
        'link',
        'folder',
        'description',
    ];

    public function brand(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
