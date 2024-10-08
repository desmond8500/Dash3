<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ArticleLink extends Model
{
    use HasFactory;

    protected $fillable = [
        'article_id',
        'name',
        "link"
    ];

    public function article(): BelongsTo
    {
        return $this->belongsTo(Article::class);
    }
}
