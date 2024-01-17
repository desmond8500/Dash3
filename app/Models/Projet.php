<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Projet extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id',
        'name',
        'description',
    ];

    public function client(): BelongsTo {
        return $this->belongsTo(Client::class);
    }

    public function devis(): HasMany {
        return $this->hasMany(Invoice::class);
    }

    public function buildings(): HasMany
    {
        return $this->hasMany(Building::class);
    }
}
