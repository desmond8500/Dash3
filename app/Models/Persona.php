<?php

namespace App\Models;

use App\Traits\searchTrait;
use Illuminate\Database\Eloquent\Model;

class Persona extends Model
{
    use searchTrait;

    public $fillable = [
        'firstname',
        'lastname',
        'avatar',
        'description',
    ];
}
