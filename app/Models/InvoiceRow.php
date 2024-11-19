<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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
        'priorite_id',
        'article_id',
    ];

    public function section(): BelongsTo {
        return $this->belongsTo(InvoiceSection::class);
    }
}
