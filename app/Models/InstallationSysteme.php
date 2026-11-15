<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/** Système installé dans un bâtiment (vidéosurveillance, alarme, incendie…) */
class InstallationSysteme extends Model
{
    protected $fillable = ['projet_id', 'building_id', 'systeme_id', 'name', 'description', 'order'];

    public function projet(): BelongsTo
    {
        return $this->belongsTo(Projet::class);
    }

    public function building(): BelongsTo
    {
        return $this->belongsTo(Building::class);
    }

    public function systeme(): BelongsTo
    {
        return $this->belongsTo(Systeme::class);
    }

    /** Tous les équipements du système */
    public function equipements(): HasMany
    {
        return $this->hasMany(Equipement::class)->orderBy('order')->orderBy('id');
    }

    /** Équipements de base (sans parent) avec leurs équipements secondaires */
    public function baseEquipements(): HasMany
    {
        return $this->hasMany(Equipement::class)->whereNull('parent_id')->orderBy('order')->orderBy('id');
    }
}
