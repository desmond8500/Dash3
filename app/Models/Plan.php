<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/** Plan importé (image, PDF ou DWG) sur lequel on place les équipements */
class Plan extends Model
{
    protected $fillable = ['projet_id', 'building_id', 'name', 'file', 'mime', 'kind'];

    protected $appends = ['url'];

    public function getUrlAttribute(): string
    {
        return url($this->file);
    }

    public function projet(): BelongsTo
    {
        return $this->belongsTo(Projet::class);
    }

    public function building(): BelongsTo
    {
        return $this->belongsTo(Building::class);
    }

    public function markers(): HasMany
    {
        return $this->hasMany(PlanMarker::class);
    }
}
