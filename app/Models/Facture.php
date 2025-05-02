<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Facture extends Model
{
    protected $fillable = [
        'invoice_id',
        'folder',
        'status',
        'reference',
        'description',
        'montant',
        'date',
        'year',
        'month',
    ];

    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }
}
