<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/** Icône d'équipement : liée aux articles par un tag, affichée sur les plans */
class Icon extends Model
{
    protected $fillable = ['name', 'tag', 'tabler', 'image', 'color'];

    protected $appends = ['image_url'];

    public function getImageUrlAttribute(): ?string
    {
        return $this->image ? url($this->image) : null;
    }

    /** Icône correspondant au premier tag de l'article qui en a une */
    public static function forArticle(?Article $article): ?self
    {
        if (! $article) return null;
        $tags = $article->tags->pluck('name')->map(fn ($t) => mb_strtolower($t))->all();
        if (! $tags) return null;

        return static::all()->first(fn ($i) => $i->tag && in_array(mb_strtolower($i->tag), $tags, true));
    }
}
