<?php

namespace App\Models;

use App\Traits\searchTrait;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use searchTrait;

    protected $fillable = ['name', 'description', 'tag', 'unit', 'type', 'data'];
}
