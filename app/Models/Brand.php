<?php

namespace App\Models;

use App\Traits\searchTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use MohamedSaid\Notable\Traits\HasNotables;

class Brand extends Model
{
    use HasFactory;
    use searchTrait;
    // use HasNotables;

    protected $fillable = [
        'logo',
        'name',
        'description',
    ];


    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];

    public function links(): HasMany
    {
        return $this->hasMany(BrandLink::class);
    }

    public function notes(): HasMany
    {
        return $this->hasMany(BrandNotes::class);
    }

    public function article(): BelongsTo
    {
        return $this->belongsTo(Article::class, 'brand_id', 'id');
    }


}
