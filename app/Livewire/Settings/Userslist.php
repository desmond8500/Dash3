<?php

namespace App\Livewire\Settings;

use App\Models\User;
use Livewire\Component;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class Userslist extends Component
{
    public $search;
    public $selected;

    public function render()
    {
        return view('livewire.settings.userslist',[
            'users' => User::search($this->search, 'firstname')
                ->search($this->search, 'lasttname')
                ->search($this->search, 'email')
                ->paginate(5)
                ,
            'permissions' => Permission::all(),
            'roles' => Role::all(),
        ]);
    }

    function select_user($user_id){
        $this->selected = User::find($user_id);
    }

    // Roles
    function add_role($role_name)
    {
        $this->selected->assignRole($role_name);
    }
    function delete_role($role_name)
    {
        $this->selected->removeRole($role_name);
    }

    // Permissions
    function add_permission($permission_name)
    {
        $this->selected->givePermissionTo($permission_name);
    }
    function delete_permission($permission_name)
    {
        $this->selected->revokePermissionTo($permission_name);
    }
}
