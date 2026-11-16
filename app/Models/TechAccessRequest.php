<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Demande d'accès à une information. Acceptée, elle crée un TechShare
 * temporaire destiné au demandeur (accès limité dans le temps).
 */
class TechAccessRequest extends Model
{
    public const STATUSES = ['pending', 'approved', 'rejected'];

    protected $fillable = [
        'client_uuid',
        'user_id',
        'subject',
        'reason',
        'task_id',
        'projet_id',
        'article_id',
        'status',
        'decided_by',
        'decided_at',
        'response',
        'tech_share_id',
    ];

    protected $casts = [
        'decided_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function task(): BelongsTo
    {
        return $this->belongsTo(Task::class);
    }

    public function projet(): BelongsTo
    {
        return $this->belongsTo(Projet::class);
    }

    public function article(): BelongsTo
    {
        return $this->belongsTo(Article::class);
    }

    public function decider(): BelongsTo
    {
        return $this->belongsTo(User::class, 'decided_by');
    }

    public function share(): BelongsTo
    {
        return $this->belongsTo(TechShare::class, 'tech_share_id');
    }
}
