<?php

namespace App\Models;

use App\Traits\searchTrait;
use App\Traits\dateTrait;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Journal extends Model
{
    use HasFactory;
    use searchTrait;
    use dateTrait;

    protected $fillable = [
        'user_id',
        'client_id',
        'projet_id',
        'devis_id',
        'title',
        'date',
        'description',
        'type',
    ];

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    public function projet(): BelongsTo
    {
        return $this->belongsTo(Projet::class);
    }

    public function invoice(): BelongsTo
    {
        return $this->belongsTo(Invoice::class);
    }
    public function intervenants(): HasMany
    {
        return $this->hasMany(JournalIntervenant::class);
    }
    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class);
    }

}
