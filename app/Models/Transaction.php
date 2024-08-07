<?php

namespace App\Models;

use App\Traits\dateTrait;
use App\Traits\searchTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Transaction extends Model
{
    use HasFactory;
    use dateTrait;
    use searchTrait;

    protected $fillable = [
        'achat_id',
        'projet_id',
        'devis_id',
        'invoice_acompte_id',
        'invoice_spent_id',
        'objet',
        'type',
        'montant',
        'description',
        'date',
    ];

    public function achat(): HasOne{
        return $this->hasOne(Achat::class);
    }

    public function projet(): BelongsTo{
        // return $this->hasOne(Projet::class);
        return $this->belongsTo(Projet::class);
    }

    public function invoice(): BelongsTo{
        return $this->belongsTo(Projet::class);
        // return $this->hasOne(Invoice::class);
    }

    public function invoiceAcompte(): HasOne{
        return $this->hasOne(InvoiceAcompte::class);
    }

    public function invoiceSpent(): HasOne{
        return $this->hasOne(InvoiceSpent::class);
    }
}
