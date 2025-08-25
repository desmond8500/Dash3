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

        $building = Building::create($this->all());
        $building->name = ucfirst($building->name);
        $building->description = ucfirst($building->description);
        $building->save();
        $this->reset('name','description');
    }

    function update()
    {
        $this->validate();

        $this->building->update($this->all());
        $this->building->name = ucfirst($this->building->name);
        $this->building->description = ucfirst($this->building->description);
        $this->building->save();
    }

    function delete()
    {
        if ($this->building->stages()->count() > 0) {
            return "Vous ne pouvez pas supprimer ce batiment car il contient des niveaux.";
        } else {
            $this->building->delete();
            return "Success";
        }

    }
}
