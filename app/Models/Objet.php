<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Objet extends Model
{
    /** @use HasFactory<\Database\Factories\ObjetFactory> */
    use HasFactory;

    protected $fillable = [
        'installation_id',
        'parent_id',
        'article_id',
        'name',
        'description',
        'type',
        'attributs',
    ];

    protected $casts = [
        'attributs' => 'array',
    ];

    public function installation()
    {
        return $this->belongsTo(Installation::class);
    }

    public function parent()
    {
        return $this->belongsTo(Objet::class, 'parent_id');
    }
}
