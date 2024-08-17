<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ArticleDocument extends Model
{
    use HasFactory;

    protected $fillable = [
        'article_id',
        'name',
        "folder"
    ];

    public function article(): BelongsTo
    {
        return $this->belongsTo(Article::class);
    }
}
