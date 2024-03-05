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
}
