<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class JournalSection extends Model
{
    protected $fillable = [
        'journal_id',
        'name',
        'description',
        'order',
    ];

    public function journal(): BelongsTo
    {
        return $this->belongsTo(Journal::class);
    }

    public function tasks()
    {
        return $this->hasMany(Task::class, 'journal_section_id');
    }

    public function images()
    {
        return $this->hasMany(JournalImage::class)->latest();
    }

    public function invoice(): BelongsTo
    {
        return $this->belongsTo(Invoice::class);
    }
}
