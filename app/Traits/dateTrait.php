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
    function fullDate($date=null)
    {
        if ($date) {
            return Carbon::parse($date)->locale('fr_FR')->format('d-F-Y');
        } else {
            return Carbon::parse($this->date)->locale('fr_FR')->format('d-F-Y');
        }
    }
}
