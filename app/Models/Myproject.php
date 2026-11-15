<?php

namespace App\Models;

use App\Traits\searchTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Myproject extends Model
{
    /** @use HasFactory<\Database\Factories\MyprojectFactory> */
    use HasFactory;
    use searchTrait;

    protected $fillable = [
        'user_id',
        'name',
        'logo',
        'favorite',
        'description',
    ];


    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function photos(): HasMany
    {
        return $this->hasMany(MyprojectPhoto::class);
    }
    public function files(): HasMany
    {
        return $this->hasMany(MyprojectFile::class);
    }

    public function transactions(): HasMany
    {
        return $this->hasMany(MyprojectTransaction::class);
    }

    /** Liens de recherche (documentation, tutoriels, boutiques…) */
    public function links(): HasMany
    {
        return $this->hasMany(MyprojectLink::class);
    }

    public function notes(): HasMany
    {
        return $this->hasMany(MyprojectNote::class)->latest();
    }

    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class, 'myproject_id');
    }

    /** Total des achats prévisionnels */
    public function previsionsTotal(): float
    {
        return (float) $this->transactions
            ->where('type', MyprojectTransaction::PREVISION)
            ->sum(fn ($t) => $t->total());
    }

    /** Total des dépenses effectuées */
    public function depensesTotal(): float
    {
        return (float) $this->transactions
            ->where('type', MyprojectTransaction::DEPENSE)
            ->sum(fn ($t) => $t->total());
    }
}
