<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quantitatif extends Model
{
    use HasFactory;

    protected $fillable = [
        'buiding_id',
        'devis_id',
        'name',

    ];
}
