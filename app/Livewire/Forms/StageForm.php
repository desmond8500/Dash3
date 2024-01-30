<?php

namespace App\Livewire\Forms;

use App\Models\Stage;
use Livewire\Attributes\Validate;
use Livewire\Form;

class StageForm extends Form
{
    #[Validate('required')]
    public $building_id;
    #[Validate('required')]
    public $name;
    #[Validate('numeric')]
    public $order;
    public $description;

    function store()
    {
        $this->validate();

        Stage::create($this->all());
    }
}
