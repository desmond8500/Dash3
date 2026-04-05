<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attribut extends Model
{
    /** @use HasFactory<\Database\Factories\AttributFactory> */
    use HasFactory;

    protected $fillable = [
        'objet_id',
        'name',
        'value',
    ];

    public function objet()
    {
        return $this->belongsTo(Objet::class);
    }
}
