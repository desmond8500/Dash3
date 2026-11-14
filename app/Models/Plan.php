<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/** Plan importé (image, PDF ou DWG) sur lequel on place les équipements */
class Plan extends Model
{
    protected $fillable = [
        'projet_id', 'building_id', 'name', 'file', 'mime', 'kind',
        'converted_file', 'conversion_status', 'conversion_error',
    ];

    protected $appends = ['url', 'pdf_url', 'viewable'];

    public function getUrlAttribute(): string
    {
        return url($this->file);
    }

    /** PDF converti (plans DWG) */
    public function getPdfUrlAttribute(): ?string
    {
        return $this->converted_file ? url($this->converted_file) : null;
    }

    /** Le plan peut être affiché et annoté (image, PDF, ou DWG converti) */
    public function getViewableAttribute(): bool
    {
        return $this->kind !== 'dwg' || $this->conversion_status === 'done';
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
