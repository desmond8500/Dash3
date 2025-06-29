<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Tags\HasTags;

class Images extends Model
{
    use HasTags;

    protected $fillable = [
        'name',
        'path',
        'size',
        'type',
    ];


}
