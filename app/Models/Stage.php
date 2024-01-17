<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Stage extends Model
{
    use HasFactory;

    protected $fillable = [
        'building_id',
        'name',
        'order',
        'description',
    ];

    public function rooms(): HasMany
    {
        return $this->hasMany(Room::class);
    }
}
