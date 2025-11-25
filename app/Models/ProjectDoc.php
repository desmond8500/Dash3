<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectDoc extends Model
{
    protected $fillable = [
        'projet_id',
        'document_name',
        'document_path',
    ];

    public function project()
    {
        return $this->belongsTo(Projet::class);
    }
}
