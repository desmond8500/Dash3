<?php

namespace App\Models;

use App\Traits\searchTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Journal extends Model
{
    use HasFactory;
    use searchTrait;

    protected $fillable = [
        'user_id',
        'client_id',
        'projet_id',
        'devis_id',
        'title',
        'date',
        'description',
    ];
}
