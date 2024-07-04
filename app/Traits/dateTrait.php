<?php

namespace App\Traits;

use Carbon\Carbon;

trait dateTrait {

    function formatDate($date=null)
    {
        if ($date) {
            return Carbon::parse($date)->format('d-m-Y');
        } else {
            return Carbon::parse($this->date)->format('d-m-Y');
        }
    }
}
