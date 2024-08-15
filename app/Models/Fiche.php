<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Fiche extends Model
{
    use HasFactory;

    protected $fillable = [
        'building_id',
        'user_id',
        'titre',
        'date',
        'phone',
        'email',
        'client',
        'type',
    ];

    public function building(): BelongsTo
    {
        return $this->belongsTo(Building::class);
    }
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
