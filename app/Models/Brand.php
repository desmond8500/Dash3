<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Brand extends Model
{
    use HasFactory;

    protected $fillable = [
        'logo',
        'name',
        'description',
    ];

    public function links(): HasMany
    {
        return $this->hasMany(BrandLink::class);
    }
}
