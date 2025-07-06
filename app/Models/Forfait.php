<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Forfait extends Model
{
    /** @use HasFactory<\Database\Factories\ForfaitFactory> */
    use HasFactory;

    protected $fillable = [
        'client_id',
        'designation',
        'description',
        'price',
    ];

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }
}
