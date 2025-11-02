<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MyprojectFile extends Model
{
    protected $fillable = [
        'myproject_id',
        'file_path',
        'description',
    ];
}
