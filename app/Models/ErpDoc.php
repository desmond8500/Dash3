<?php

namespace App\Models;

use App\Traits\searchTrait;
use Illuminate\Database\Eloquent\Model;

class ErpDoc extends Model
{
    use searchTrait;

    protected $fillable = [
        'name',
        'type',
        'path',
        'extension',
    ];
}
