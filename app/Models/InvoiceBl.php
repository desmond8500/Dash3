<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InvoiceBl extends Model
{
    use HasFactory;

    protected $fillable = [
        'invoice_id',
        'name',
        'date',
        'done',
        'todo',
        'type',
        'logo',
    ];

    public function invoice(): BelongsTo
    {
        return $this->belongsTo(Invoice::class);
    }
}
