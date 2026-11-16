<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BadgeModele extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'css',
        'file',
        'client_id',
        'orientation',
        'color',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function badges()
    {
        return $this->hasMany(Badge::class);
    }
}
