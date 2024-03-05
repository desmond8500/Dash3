<?php

namespace App\Models;

use App\Traits\searchTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Provider extends Model
{
    use HasFactory;
    use searchTrait;

    protected $fillable = [
        'name',
        'logo',
        'address',
        'description',
    ];
}
