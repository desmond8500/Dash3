<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ArticleDependence extends Model
{
    protected $fillable = [
        'article_id',
        'dependence_id',
        'quantity',
    ];

    public function article()
    {
        return $this->belongsTo(Article::class);
    }

    public function dependence()
    {
        return $this->belongsTo(Article::class, 'dependence_id');
    }
}
