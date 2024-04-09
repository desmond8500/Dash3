<?php

namespace App\Livewire\Forms;

use App\Models\Stage;
use Livewire\Attributes\Validate;
use Livewire\Form;

class StageForm extends Form
{
    public Stage $stage;

    #[Validate('required')]
    public $building_id;
    #[Validate('required')]
    public $name;
    #[Validate('numeric')]
    public $order;
    public $description;

    function set($stage_id){
        $this->stage = Stage::find($stage_id);

        $this->building_id = $this->stage->building_id;
        $this->name = $this->stage->name;
        $this->order = $this->stage->order;
        $this->description = $this->stage->description;
    }

    function store()
    {
        $this->validate();
        $stage = Stage::create($this->all());
        $stage->name = ucfirst($stage->name);
        $stage->save();
    }

    function update(){
        $this->validate();
        $this->stage->update($this->all());

        $this->stage->name = ucfirst($this->stage->name);
        $this->stage->save();
    }

    function delete(){
        $this->stage->delete();
    }
}
