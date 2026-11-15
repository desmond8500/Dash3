<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/** Photo d'un journal, rattachée ou non à une section */
class JournalImage extends Model
{
    use HasFactory;

    protected $fillable = ['journal_id', 'journal_section_id', 'folder'];

    protected $appends = ['url'];

    public function getUrlAttribute(): string
    {
        return url($this->folder);
    }
}
