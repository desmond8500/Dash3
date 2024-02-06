<?php

namespace App\Livewire\Forms;

use App\Models\Building;
use Livewire\Attributes\Validate;
use Livewire\Form;

class BuildingForm extends Form
{
    public ?Building $building;
    #[Validate('required')]
    public $projet_id;
    #[Validate('required')]
    public $name;
    #[Validate('numeric')]
    public $order;
    public $description;

    function set($building_id)
    {
        $this->building = Building::find($building_id);

        $this->projet_id = $this->building->projet_id;
        $this->name = $this->building->name;
        $this->order = $this->building->order;
        $this->description = $this->building->description;
    }

    function store(){
        $this->validate();

        Building::create($this->all());
    }

    function update()
    {
        $this->validate();

        $this->building->update($this->all());
    }

    function delete()
    {
        $this->building->delete();
    }
}
