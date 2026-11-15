<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CV extends Model
{
    /** @use HasFactory<\Database\Factories\CVFactory> */
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'title',
        'fullname',
        'summary',
        'photo',
        'phone',
        'email',
        'address',
        'website',
        'accent_color',
        'font',
        'layout',
        'show_photo',
    ];

    protected $casts = [
        'show_photo' => 'boolean',
    ];

    protected $appends = ['photo_url'];

    public function getPhotoUrlAttribute(): ?string
    {
        return $this->photo ? url($this->photo) : null;
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function sections(): HasMany
    {
        return $this->hasMany(CvSection::class, 'c_v_id')->orderBy('order')->orderBy('id');
    }
}
