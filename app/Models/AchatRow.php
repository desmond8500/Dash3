<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AchatRow extends Model
{
    use HasFactory;

    protected $fillable = [
        'achat_id',
        'article_id',
        'designation',
        'reference',
        'quantite',
        'prix',
        'tva',
    ];

    public function achat(): BelongsTo
    {
        return $this->belongsTo(Achat::class);
    }
    public function article(): BelongsTo
    {
        return $this->belongsTo(Article::class);
    }
}
