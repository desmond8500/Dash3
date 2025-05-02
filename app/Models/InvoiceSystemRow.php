<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InvoiceSystemRow extends Model
{
    protected $fillable = [
        'invoice_model_id',
        'article_id',
        'quantite',
        'coef',
        'priorite_id',
    ];

    public function invoice_system(): BelongsTo
    {
        return $this->belongsTo(InvoiceModel::class);
    }
}
