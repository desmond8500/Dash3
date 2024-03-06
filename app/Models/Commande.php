<?php

namespace App\Models;

use App\Traits\searchTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Commande extends Model
{
    use HasFactory;
    use searchTrait;

    protected $fillable = [
        'article_id',
        'quantity',
    ];

    public function article(): BelongsTo
    {
        return $this->belongsTo(Article::class);
    }
}
