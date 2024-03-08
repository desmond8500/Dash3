<?php

namespace App\Models;

use App\Traits\searchTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Invoice extends Model
{
    use HasFactory;
    use searchTrait;

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
        'remise',
        'favorite',
    ];

    public function projet(): BelongsTo
    {
        return $this->belongsTo(Projet::class);
    }

    public function sections(): HasMany
    {
        return $this->hasMany(InvoiceSection::class);
    }

    public function acomptes(): HasMany
    {
        return $this->hasMany(InvoiceAcompte::class);
    }

    public function documents(): HasMany
    {
        return $this->hasMany(InvoiceAcompte::class);
    }

    public function spents(): HasMany
    {
        return $this->hasMany(InvoiceSpent::class);
    }

}
