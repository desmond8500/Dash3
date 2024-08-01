<?php

namespace App\Livewire\Settings;

use App\Livewire\Forms\PermissionForm;
use App\Livewire\Forms\RoleForm;
use Livewire\Component;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class Permissions extends Component
{
    public PermissionForm $permission_form;
    public RoleForm $role_form;

    public function render()
    {
        return view('livewire.settings.permissions',[
            'permissions' => Permission::all(),
            'roles' => Role::all(),
        ]);
    }

    public $form_permission = false;
    public $form_role = false;

    // Permission
    function permission_store(){
        $this->permission_form->store();
        $this->dispatch('open-addPermission');
    }
    function permission_edit($permission_id){
        $this->permission_form->set($permission_id);
        $this->dispatch('open-editPermission');
    }
    function permission_update(){
        $this->permission_form->update();
        $this->dispatch('close-editPermission');
    }
    function permission_delete($permission_id){
        $this->permission_form->delete($permission_id);
    }

    // Role
    function role_store(){
        $this->role_form->store();
        $this->dispatch('open-addRole');
    }
    function role_edit($role_id){
        $this->role_form->set($role_id);
        $this->dispatch('open-editRole');
    }
    function role_update(){
        $this->role_form->update();
        $this->dispatch('close-editRole');
    }
    function role_delete($role_id){
        $this->role_form->delete($role_id);
    }
}
