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
        'priorite_id',
        'article_id',
        'designation',
        'coef',
        'reference',
        'quantite',
        'prix',
        'bought',
    ];

    public function section(): BelongsTo {
        return $this->belongsTo(InvoiceSection::class);
    }

    public function article(): BelongsTo
    {
        return $this->belongsTo(Article::class);
    }
}
