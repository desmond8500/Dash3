<?php

namespace App\Models;

use App\Models\Item;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BuildingItem extends Model
{
    protected $fillable = ['building_id', 'item_id', 'parent_id', 'name'];

    public function item(): BelongsTo
    {
        return $this->belongsTo(Item::class, 'foreign_key', 'other_key');
    }
}
