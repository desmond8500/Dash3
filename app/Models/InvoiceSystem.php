<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class InvoiceSystem extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
    ];

    public function models(): HasMany
    {
        return $this->hasMany(InvoiceModel::class, 'invoice_system_id');
    }
}
