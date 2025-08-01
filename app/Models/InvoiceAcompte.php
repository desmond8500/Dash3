<?php

namespace App\Models;

use App\Traits\dateTrait;
use App\Traits\searchTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InvoiceAcompte extends Model
{
    use HasFactory;
    use searchTrait;
    use dateTrait;


    protected $fillable = [
        'invoice_id',
        'name',
        'description',
        'montant',
        'statut',
        'date',
        'transaction_id',
        'show',
    ];

    public function invoice(): BelongsTo
    {
        return $this->belongsTo(Invoice::class);
    }
}
