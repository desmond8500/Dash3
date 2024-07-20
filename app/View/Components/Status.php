<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Status extends Component
{
    /**
     * Create a new component instance.
     */

    public $status;
    public function __construct($status)
    {
        $this->status = $status. 'dfdhgfdh' ;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        if($this->status=='Nouveau')
            $color = 'blue';
        elseif($this->status=='En cours')
            $color = 'orange';
        elseif($this->status=='En pause')
            $color = 'secondary';
        elseif($this->status=='Terminé')
            $color = 'green';
        elseif($this->status=='Cloturé')
            $color = 'teal';
        else
            $color = 'blue';

        return view('components.status');
    }
}
