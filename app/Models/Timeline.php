<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Timeline extends Model
{
    /** @use HasFactory<\Database\Factories\TimelineFactory> */
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'description',
        'client_id',
        'projet_id',
        'invoice_id',
        'task_id',
        'systeme_id',
        'article_id',
        'provider_id',
        'brand_id',
        'achat_id',
        'building_id',
        'stage_id',
        'room_id',
        'journal_id',
    ];
}
