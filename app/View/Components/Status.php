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
        if($this->status=='Nouveau' || $this->status == 1){
            $color = 'blue';
            $status = 'Nouveau';
        }
        elseif($this->status=='En cours' || $this->status == 2){
            $color = 'orange';
            $status = 'En cours';
        }
        elseif($this->status=='En pause' || $this->status == 3){
            $color = 'secondary';
            $status = 'En pause';
        }
        elseif($this->status=='Terminé' || $this->status == 4){
            $color = 'green';
            $status = 'Terminé';
        }
        elseif($this->status=='Cloturé' || $this->status == 5){
            $color = 'teal';
            $status = 'Cloturé';
        }
        else{
            $color = 'blue';
            $status = 'Nouveau';
        }

        return view('components.status',[
            'color' => $color,
            // 'status' => $status
        ]);
    }
}
