<?php

namespace App\Livewire\Forms;

use App\Models\Systeme;
use Livewire\Attributes\Validate;
use Livewire\Form;

class SystemeForm extends Form
{
    public Systeme $system;

    #[Validate('required')]
    public string $name;
    public string $description;
    public string $icon;

    function store()
    {
        $this->validate();

        $system = Systeme::create($this->all());

        $system->name = ucfirst($system->name);
        $system->description = ucfirst($system->description);
        $system->save();
    }

    function set(int $system_id)
    {
        $this->system = Systeme::find($system_id);
        $this->name = $this->system->name;

        $this->description = $this->system->description;
        $this->icon = $this->system->icon;
    }

    function update()
    {
        $this->validate();

        $this->system->update($this->all());

        $this->system->name = ucfirst($this->system->name);
        $this->system->description = ucfirst($this->system->description);
        $this->system->save();
    }

    function delete(int $id)
    {
        $system = Systeme::find($id);
        $system->delete();
    }
}
