<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InvoiceProposal extends Model
{
    protected $fillable = [
        'invoice_id',
        'logo',
        'client_name',
        'projet_name',
        'description',
        'footer',
        'details',
    ];

    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }
}
