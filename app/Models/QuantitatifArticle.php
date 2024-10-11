<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuantitatifArticle extends Model
{
    use HasFactory;

    protected $fillable = [
        'quantitatif_row_id',
        'article_id',
        'description',
        'room_id',
    ];
}
