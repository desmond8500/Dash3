<?php

namespace App\Traits;

trait searchTrait {
    /**
     * @param String $name
     *
     */

    public function scopeSearch($query, $search, $name = "name")
    {
        return $query->where($name, 'like', '%' . $search . '%')->orderBy($name);
    }

    public function scopeArticleSearch($query, $search)
    {
        return $query->where('designation', 'like', '%' . $search . '%')->orWhere('reference', 'like', '%' . $search . '%');
    }
}
