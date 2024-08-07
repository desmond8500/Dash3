<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Badge extends Model
{
    use HasFactory;

    protected $fillable = [
        'projet_id',
        'badge_modele_id',
        'prenom',
        'nom',
        'fonction',
        'service',
        'direction',
        'photo',
        'matricule',
        'adresse',
    ];


    public function projet(): BelongsTo
    {
        return $this->belongsTo(Projet::class);
    }
}
