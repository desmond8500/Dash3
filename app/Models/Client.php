<?php

namespace App\Models;

use App\Traits\searchTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Client extends Model
{
    use HasFactory;
    use searchTrait;

    protected $fillable = [
        'name',
        'description',
        'address',
        'avatar',
        'status',
        'type',
        'favorite',
    ];

    public function projets(): HasMany
    {
        return $this->hasMany(Projet::class);
    }
    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class);
    }
}
