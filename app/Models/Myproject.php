<?php

namespace App\Models;

use App\Traits\searchTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

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

    public function photos(): HasMany
    {
        return $this->hasMany(MyprojectPhoto::class);
    }
    public function files(): HasMany
    {
        return $this->hasMany(MyprojectFile::class);
    }

    public function transactions(): HasMany
    {
        return $this->hasMany(MyprojectTransaction::class);
    }

}
