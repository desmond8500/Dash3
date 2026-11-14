<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/** Emplacement d'un équipement sur un plan (x, y entre 0 et 1) */
class PlanMarker extends Model
{
    protected $fillable = ['plan_id', 'equipement_id', 'page', 'x', 'y', 'label', 'icon', 'color'];

    protected $casts = [
        'x' => 'float',
        'y' => 'float',
        'page' => 'integer',
    ];

    public function plan(): BelongsTo
    {
        return $this->belongsTo(Plan::class);
    }

    public function equipement(): BelongsTo
    {
        return $this->belongsTo(Equipement::class);
    }
}
