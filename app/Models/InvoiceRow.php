<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class InvoiceRow extends Model
{
    use HasFactory;
    protected $fillable = [
        'invoice_section_id',
        'designation',
        'coef',
        'reference',
        'quantite',
        'prix',
        'priorite',
    ];

    public function section(): BelongsTo {
        return $this->belongsTo(InvoiceSection::class);
    }
}
