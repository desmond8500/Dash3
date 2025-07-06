<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Te7aHoudini\LaravelTrix\Traits\HasTrixRichText;

class Test extends Model
{
    use HasTrixRichText;

    protected $fillable = [
        'name',
        'description',
    ];
}
