<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/** Rapport d'intervention rédigé par un technicien (éventuellement hors ligne). */
class TechReport extends Model
{
    public const STATUSES = ['submitted', 'validated', 'rejected'];

    protected $fillable = [
        'client_uuid',
        'user_id',
        'task_id',
        'projet_id',
        'title',
        'content',
        'status',
        'latitude',
        'longitude',
        'reported_at',
        'reviewed_by',
        'review_note',
        'reviewed_at',
    ];

    protected $casts = [
        'reported_at' => 'datetime',
        'reviewed_at' => 'datetime',
        'latitude' => 'float',
        'longitude' => 'float',
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

    public function reviewer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }

    public function photos(): HasMany
    {
        return $this->hasMany(TechReportPhoto::class);
    }
}
