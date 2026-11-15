<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/** Note d'un projet personnel */
class MyprojectNote extends Model
{
    protected $fillable = ['myproject_id', 'title', 'content'];

    public function myproject(): BelongsTo
    {
        return $this->belongsTo(Myproject::class);
    }
}
