<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/** Équipement d'un système : de base (parent_id null) ou secondaire (rattaché à un équipement de base) */
class Equipement extends Model
{
    protected $fillable = [
        'installation_systeme_id', 'parent_id', 'article_id',
        'name', 'type', 'modele', 'caracteristiques', 'description', 'order',
    ];

    protected $casts = [
        'caracteristiques' => 'array',
    ];

    public function systeme(): BelongsTo
    {
        return $this->belongsTo(InstallationSysteme::class, 'installation_systeme_id');
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(Equipement::class, 'parent_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(Equipement::class, 'parent_id')->orderBy('order')->orderBy('id');
    }

    public function article(): BelongsTo
    {
        return $this->belongsTo(Article::class);
    }
}
