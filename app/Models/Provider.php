<?php

namespace App\Models;

use App\Traits\searchTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Provider extends Model
{
    use HasFactory;
    use searchTrait;


    protected $fillable = [
        'name',
        'logo',
        'address',
        'description',
        'email',
        'phone',
        'website',
        'latitude',
        'longitude',
    ];

    protected $hidden = ['created_at','updated_at','deleted_at'];

    public function documents(): HasMany
    {
        return $this->hasMany(ProviderDocument::class)->latest();
    }

    public function links(): HasMany
    {
        return $this->hasMany(ProviderLink::class)->orderBy('name');
    }

    public function article(): HasMany
    {
        return $this->hasMany(Article::class);
    }
}
