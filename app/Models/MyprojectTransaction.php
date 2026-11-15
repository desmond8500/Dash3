<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/** Ligne de budget d'un projet personnel : achat prévisionnel ou dépense */
class MyprojectTransaction extends Model
{
    public const PREVISION = 'prevision';
    public const DEPENSE = 'depense';

    protected $fillable = [
        'myproject_id',
        'name',
        'amount',
        'quantity',
        'transaction_date',
        'description',
        'type',
        'status',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'quantity' => 'integer',
        'transaction_date' => 'date',
    ];

    public function myproject(): BelongsTo
    {
        return $this->belongsTo(Myproject::class);
    }

    /** Montant de la ligne : prix unitaire × quantité */
    public function total(): float
    {
        return (float) $this->amount * max(1, (int) $this->quantity);
    }
}
