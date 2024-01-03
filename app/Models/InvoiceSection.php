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
        'ordre'
    ];

    public function rows(): HasMany
    {
        return $this->hasMany(InvoiceRow::class, 'invoice_section_id', 'id');
    }

    /**
     * Get all of the comments for the InvoiceSection
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class, 'foreign_key', 'local_key');
    }
}
