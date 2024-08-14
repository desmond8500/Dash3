<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Quantitatif extends Model
{
    use HasFactory;

    protected $fillable = [
        'building_id',
        'devis_id',
        'name',
    ];

    /**
     * Get all of the rows for the Quantitatif
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function rows(): HasMany
    {
        return $this->hasMany(QuantitatifRow::class);
    }
}
