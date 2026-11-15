<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/** Lien de recherche d'un projet personnel (documentation, tutoriel, boutique…) */
class MyprojectLink extends Model
{
    protected $fillable = ['myproject_id', 'name', 'link', 'description'];

    public function myproject(): BelongsTo
    {
        return $this->belongsTo(Myproject::class);
    }
}
