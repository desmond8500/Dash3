<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Installation extends Model
{
    protected $fillable = [
        'projet_id',
        'type',
        'description',
    ];

    public function projet()
    {
        return $this->belongsTo(Projet::class);
    }

    public function systeme()
    {
        return $this->belongsTo(Systeme::class, 'type', 'id');
    }

    public function objets()
    {
        return $this->hasMany(Objet::class);
    }
}
