<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Device extends Model
{
    protected $fillable = [
        'quantitatif_row_id',
        'article_id',
        'designation',
        'reference',
        'type',
        'icon',
        'description'
    ];

    public function quantitatifRow()
    {
        return $this->belongsTo(QuantitatifRow::class);
    }

    public function article()
    {
        return $this->belongsTo(Article::class);
    }
}
