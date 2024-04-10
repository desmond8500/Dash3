<?php

namespace App\Livewire\Forms;

use App\Models\Systeme;
use Livewire\Attributes\Validate;
use Livewire\Form;

class SystemeForm extends Form
{
    public Systeme $system;

    #[Validate('required')]
    public $name;
    public $description;

    function store()
    {
        $this->validate();

        $system = Systeme::create($this->all());

        $system->name = ucfirst($system->name);
        $system->description = ucfirst($system->description);
        $system->save();
    }

    function set($system_id)
    {
        $this->system = Systeme::find($system_id);
        $this->name = $this->system->name;

        $this->description = $this->system->description;
    }

    function update()
    {
        $this->validate();

        $this->system->update($this->all());

        $this->system->name = ucfirst($this->system->name);
        $this->system->description = ucfirst($this->system->description);
        $this->system->save();
    }

    function delete($id)
    {
        $system = Systeme::find($id);
        $system->delete();
    }
}
