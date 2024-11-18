<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class JournalIntervenant extends Model
{
    use HasFactory;

    protected $fillable = [
        'journal_id',
        'contact_id',
        'team_id',
    ];


    public function journal(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function contacts(): HasMany
    {
        return $this->hasMany(Contact::class);
    }

    public function teams(): HasMany
    {
        return $this->hasMany(Team::class);
    }
}
