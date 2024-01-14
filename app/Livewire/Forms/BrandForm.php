<?php

namespace App\Livewire\Forms;

use Livewire\Attributes\Validate;
use Livewire\Form;

class BrandForm extends Form
{
    #[Validate('required')]
    public $name;
    public $logo;
}
