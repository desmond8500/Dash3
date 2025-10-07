<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class schema extends Model
{
    protected $fillable = ['name', 'description', 'building_id', 'type', 'data'];


    public function buildingItem(): HasMany
    {
        return $this->hasMany(BuildingItem::class);
    }

    public function building(): BelongsTo
    {
        return $this->belongsTo(Building::class);
    }

    public function schemaLists(): HasMany
    {
        return $this->hasMany(SchemaList::class);
    }
}
