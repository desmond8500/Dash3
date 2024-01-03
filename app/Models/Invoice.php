<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Invoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'projet_id',
        'client_name',
        'projet_name',
        'reference',
        'description',
        'modalite',
        'note',
        'statut',
        'tax',
        'remise'
    ];

    public function projet(): BelongsTo
    {
        return $this->belongsTo(Projet::class);
    }

    public function sections(): HasMany
    {
        return $this->hasMany(InvoiceSection::class);
    }

}
