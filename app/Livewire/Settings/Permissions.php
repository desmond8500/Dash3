<?php

namespace App\Livewire\Settings;

use Livewire\Component;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class Permissions extends Component
{
    public function render()
    {
        return view('livewire.settings.permissions',[
            'permissions' => Permission::all(),
            'roles' => Role::all(),
        ]);
    }
}
