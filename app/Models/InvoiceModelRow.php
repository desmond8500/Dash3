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

    public function priority()
    {
        if ($this->priorite_id == 0) {
            return "Centrale 1";
        }
        if ($this->priorite_id == 1) {
            return "Centrale 2";
        }
        if ($this->priorite_id == 2) {
            return "Organe 1";
        }
        if ($this->priorite_id == 3) {
            return "Organe 2";
        }
        if ($this->priorite_id == 4) {
            return "Organe 3";
        }
        if ($this->priorite_id == 5) {
            return "Cable";
        }
        if ($this->priorite_id == 6) {
            return "Accessoires";
        }
        if ($this->priorite_id == 7) {
            return "Forfait";
        }
    }

}
