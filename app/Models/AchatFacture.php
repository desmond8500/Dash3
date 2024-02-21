<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AchatFacture extends Model
{
    use HasFactory;

    protected $fillable = ['achat_id','folder'];

    public function achat(): BelongsTo
    {
        return $this->belongsTo(Achat::class);
    }
}
