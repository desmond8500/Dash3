<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class InvoiceModelRow extends Model
{
    protected $fillable = [
        'invoice_model_id',
        'article_id',
        'designation',
        'coef',
        'reference',
        'quantite',
        'prix',
        'priorite_id',
    ];

    public function invoice_model(): BelongsTo
    {
        return $this->belongsTo(InvoiceModel::class);
    }

    public function article(): HasOne
    {
        return $this->hasOne(Article::class, 'id', 'article_id');
    }

}
