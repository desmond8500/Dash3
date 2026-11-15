<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/** Ligne d'une section de CV : une expérience, une formation, une compétence… */
class CvItem extends Model
{
    protected $fillable = [
        'cv_section_id', 'title', 'subtitle', 'place',
        'start_date', 'end_date', 'current', 'description', 'level', 'order',
    ];

    protected $casts = [
        'current' => 'boolean',
        'level' => 'integer',
    ];

    public function section(): BelongsTo
    {
        return $this->belongsTo(CvSection::class, 'cv_section_id');
    }
}
