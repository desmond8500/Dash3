<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = [
        'user_id',
        'dashboard',
        'color',
        'color1',
        'color2',
        'color3',
        'year',
    ];
}
