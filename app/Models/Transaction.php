<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'achat_id',
        'projet_id',
        'devis_id',
        'objet',
        'type',
        'montant',
        'description',
        'date',
    ];
}
