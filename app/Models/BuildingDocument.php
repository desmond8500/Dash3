<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BuildingDocument extends Model
{
    use HasFactory;

    protected $fillable = [
        'building_id',
        'name',
        'folder',
        'link',
        'description'
    ];
}
