<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MyprojectPhoto extends Model
{
    protected $fillable = [
        'myproject_id',
        'photo_path',
        'caption',
    ];
}
