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

    public function priority()
    {
        if ($this->priority_id == 0) {
            return "Centrale 1";
        }
        if ($this->priority_id == 1) {
            return "Centrale 2";
        }
        if ($this->priority_id == 2) {
            return "Organe 1";
        }
        if ($this->priority_id == 3) {
            return "Organe 2";
        }
        if ($this->priority_id == 4) {
            return "Organe 3";
        }
        if ($this->priority_id == 5) {
            return "Cable";
        }
        if ($this->priority_id == 6) {
            return "Accessoires";
        }
        if ($this->priority_id == 7) {
            return "Forfait";
        }
    }
}
