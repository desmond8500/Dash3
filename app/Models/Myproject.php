<?php

namespace App\Models;

use App\Traits\searchTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Myproject extends Model
{
    /** @use HasFactory<\Database\Factories\MyprojectFactory> */
    use HasFactory;
    use searchTrait;

    protected $fillable = [
        'user_id',
        'name',
        'logo',
        'favorite',
        'description',
    ];


    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
