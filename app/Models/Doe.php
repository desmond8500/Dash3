<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Doe extends Model
{
    use HasFactory;
    protected $fillable = [
        'projet_id',
        'mo',
        'mo_adresse',
        'dmo',
        'dmo_adresse',
        'description',

    ];
}
