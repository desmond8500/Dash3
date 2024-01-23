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
        'start_date',
        'end_date',
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
    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class);
    }
}
