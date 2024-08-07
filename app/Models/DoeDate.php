<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DoeDate extends Model
{
    use HasFactory;

    protected $fillable = [
        'doe_id',
        'date',
        'realise',
        'approuve',
        'observation',
    ];
}
