<?php

namespace App\Livewire\Forms;

use App\Models\Building;
use Livewire\Attributes\Validate;
use Livewire\Form;

class BuildingForm extends Form
{
    #[Validate('required')]
    public $projet_id;
    #[Validate('required')]
    public $name;
    #[Validate('numeric')]
    public $order;
    public $description;

    function store(){
        $this->validate();

        Building::create($this->all());
    }
}
