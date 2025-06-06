<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Forfait extends Model
{
    /** @use HasFactory<\Database\Factories\ForfaitFactory> */
    use HasFactory;

    protected $fillable = [
        'designation',
        'description',
        'price',
    ];
}
