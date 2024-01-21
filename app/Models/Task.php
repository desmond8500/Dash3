<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id',
        'projet_id',
        'devis_id',
        'level_id',
        'stage_id',
        'room_id',
        'name',
        'description',
        'priority_id',
        'statut_id',
    ];
}
