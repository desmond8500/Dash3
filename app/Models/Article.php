<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory;

    protected $fillable = [
    'designation',
    'image',
    'reference',
    'description',
    'quantity',
    'priority_id',
    'brand_id',
    'provider_id',
    'price',
    ];
}
