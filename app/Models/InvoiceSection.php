<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class InvoiceSection extends Model
{
    use HasFactory;

    protected $fillable = [
        'invoice_id',
        'section',
        'ordre',
        'proposition',
        'status',
        'show',
    ];

    public function rows(): HasMany
    {
        return $this->hasMany(InvoiceRow::class, 'invoice_section_id', 'id');
    }
    public function invoiceRow(): HasMany
    {
        return $this->hasMany(InvoiceRow::class, 'invoice_section_id', 'id');
    }
    public function total()
    {
        $total = 1;
        foreach ($this->rows() as  $row) {
            $total += $row->quantite * $row->coef * $row->prix;
        }

        return $total;
    }


}
