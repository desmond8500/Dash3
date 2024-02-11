<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Building extends Model
{
    use HasFactory;
    protected $fillable = [
        'projet_id',
        'name',
        'order',
        'description',
    ];

    public function stages(): HasMany
    {
        return $this->hasMany(Stage::class);
    }
    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class);
    }

    public function projet(): BelongsTo
    {
        return $this->belongsTo(Projet::class);
    }
}
