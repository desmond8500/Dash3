<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    protected $fillable = [
        'user_id',
        'client_id',
        'projet_id',
        'contact_id',
        'title',
        'description',
        'priority',
        'status',
        'deadline',
        'closed_at',
        'category',
    ];
}
