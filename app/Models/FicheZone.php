<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FicheZone extends Model
{
    use HasFactory;

    protected $fillable = [
        'fiche_id',
        'order',
        'equipement',
        'code',
        'name',
        'number',
    ];
}
