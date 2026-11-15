<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/** Section d'un CV : expériences, formations, compétences, langues ou section libre */
class CvSection extends Model
{
    public const TYPES = ['experience', 'formation', 'competence', 'langue', 'libre'];

    protected $fillable = ['c_v_id', 'name', 'type', 'order'];

    public function cv(): BelongsTo
    {
        return $this->belongsTo(CV::class, 'c_v_id');
    }

    public function items(): HasMany
    {
        return $this->hasMany(CvItem::class, 'cv_section_id')->orderBy('order')->orderBy('id');
    }
}
