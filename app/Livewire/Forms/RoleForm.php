<?php

namespace App\Livewire\Forms;

use Livewire\Attributes\Rule;
use Livewire\Attributes\Validate;
use Livewire\Form;
use Spatie\Permission\Models\Role;

class RoleForm extends Form
{
    public Role $permission;

    #[Rule('required')]
    public $name;

    function fix()
    {
        $this->name = ucfirst($this->name);
    }

    function store()
    {
        $this->validate();
        Role::create($this->all());
    }

    function set($model_id)
    {
        $this->permission = Role::find($model_id);
        $this->name = $this->permission->name;
    }

    function update()
    {
        $this->validate();
        $this->permission->update($this->all());
    }

    function delete($id)
    {
        $this->permission = Role::find($id);
        $this->permission->delete();
    }
}
