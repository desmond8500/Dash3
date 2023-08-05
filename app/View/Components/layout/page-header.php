<?php

namespace App\View\Components\layout;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class page-header extends Component
{
    public $breadcrumbs;

    public function __construct($breadcrumbs = [])
    {
        // $this->breadcrumbs = [];
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.layout.page-header');
    }
}
