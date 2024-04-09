<?php

namespace App\View\Components\erp\projet;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class projetResume extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the view / contents that represent the component.T
     */
    public function render(): View|Closure|string
    {
        return view('components.erp.projet.projet-resume');
    }
}
