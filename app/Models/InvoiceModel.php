<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InvoiceModel extends Model
{
    use HasFactory;

    protected $fillable = [
        'invoice_system_id',
        'name',
        'description',
    ];

    public function system(): BelongsTo
    {
        return $this->belongsTo(InvoiceSystem::class, 'invoice_system_id');
    }

    public function rows()
    {
        return $this->hasMany(InvoiceModelRow::class, 'invoice_model_id');
    }
}
