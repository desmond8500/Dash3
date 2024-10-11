<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BuildingQuantitatif extends Model
{
    use HasFactory;

    protected $fillable = [
        'building_id',
        'name',
        'description',
    ];
}
