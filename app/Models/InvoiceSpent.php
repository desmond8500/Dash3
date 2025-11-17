<?php

namespace App\Models;

use App\Traits\dateTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InvoiceSpent extends Model
{
    use HasFactory;
    use dateTrait;

    protected $fillable = [
        'invoice_id',
        'name',
        'description',
        'montant',
        'status',
        'date',
        'file',
    ];

    public function invoice(): BelongsTo
    {
        return $this->belongsTo(Invoice::class);
    }


}
