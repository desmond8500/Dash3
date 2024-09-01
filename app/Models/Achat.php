<?php

namespace App\Models;

use App\Traits\dateTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Achat extends Model
{
    use HasFactory;
    use dateTrait;

    protected $fillable = [
        'provider_id',
        'name',
        'description',
        'date',
        'transaction_id',
        'status',
    ];

    public function provider(): BelongsTo
    {
        return $this->belongsTo(Provider::class);
    }

    public function rows(): HasMany
    {
        return $this->hasMany(AchatRow::class);
    }
    public function factures(): HasMany
    {
        return $this->hasMany(AchatFacture::class);
    }

    public function total()
    {
        $total = 0;
        foreach ($this->rows as $key => $row) {
            $total+= $row->prix*$row->quantite;
        }

        return $total;
    }

    public function tva()
    {
        $total = 0;
        foreach ($this->rows as $key => $row) {
            $total+= $row->prix*$row->tva*$row->quantite;
        }

        return $total;
    }

    public function ttc()
    {
        $total = 0;
        foreach ($this->rows as $key => $row) {
            $total+= ($row->prix + $row->prix*$row->tva)*$row->quantite;
        }

        return $total;
    }
}
