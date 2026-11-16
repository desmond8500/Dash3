<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\Storage;

/**
 * Information temporaire partagée avec des techniciens.
 *
 * Elle expire à `expires_at`. Avec `expires_with_task`, la clôture de la
 * tâche liée ramène `expires_at` à « clôture + délai de grâce ».
 * L'auteur est prévenu avant l'expiration (commande tech:expire-shares).
 */
class TechShare extends Model
{
    public const CATEGORIES = ['info', 'materiel', 'acces', 'document'];

    protected $fillable = [
        'created_by',
        'category',
        'title',
        'content',
        'task_id',
        'projet_id',
        'article_id',
        'building_id',
        'file_path',
        'file_name',
        'expires_at',
        'expires_with_task',
        'expiry_notified_at',
        'expired_at',
    ];

    protected $casts = [
        'expires_at' => 'datetime',
        'expiry_notified_at' => 'datetime',
        'expired_at' => 'datetime',
        'expires_with_task' => 'boolean',
    ];

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
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

    public function building(): BelongsTo
    {
        return $this->belongsTo(Building::class);
    }

    public function technicians(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'tech_share_user')
            ->withPivot('read_at')
            ->withTimestamps();
    }

    /** Partages encore visibles par les techniciens. */
    public function scopeActive(Builder $query): Builder
    {
        return $query->whereNull('expired_at')
            ->where(function (Builder $q) {
                $q->whereNull('expires_at')->orWhere('expires_at', '>', now());
            });
    }

    public function scopeVisibleTo(Builder $query, User $user): Builder
    {
        return $query->whereHas('technicians', fn (Builder $q) => $q->where('users.id', $user->id));
    }

    public function isActive(): bool
    {
        return $this->expired_at === null
            && ($this->expires_at === null || $this->expires_at->isFuture());
    }

    /**
     * Expire immédiatement : le contenu et le fichier sont purgés,
     * seul le titre reste pour l'historique.
     */
    public function expireNow(): void
    {
        if (config('tech.purge_on_expiry', true)) {
            if ($this->file_path) {
                Storage::disk('local')->delete($this->file_path);
            }
            $this->content = null;
            $this->file_path = null;
            $this->file_name = null;
        }

        $this->expired_at = now();
        if ($this->expires_at === null || $this->expires_at->isFuture()) {
            $this->expires_at = now();
        }
        $this->save();
    }
}
