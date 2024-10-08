<?php

namespace App\Models;

use App\Traits\dateTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Fiche extends Model
{
    use HasFactory;
    use dateTrait;

    protected $fillable = [
        'building_id',
        'user_id',
        'titre',
        'date',
        'phone',
        'email',
        'client',
        'type',
        'systeme',
    ];

    public function building(): BelongsTo
    {
        return $this->belongsTo(Building::class);
    }
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function zones(): HasMany
    {
        return $this->hasMany(FicheZone::class);
    }
}
