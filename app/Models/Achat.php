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
        'journal_id',
        'transaction_id',
        'name',
        'description',
        'date',
        'status',
        'remise',
    ];

    public function journal(): BelongsTo
    {
        return $this->belongsTo(Journal::class);
    }

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
