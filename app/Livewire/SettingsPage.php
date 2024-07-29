<?php

namespace App\Livewire;

use App\Livewire\Forms\StatusForm;
use App\Models\TaskStatus;
use Livewire\Component;

class SettingsPage extends Component
{
    public function render()
    {
        return view('livewire.settings-page',[
            'user' => auth()->user(),
        ]);
    }

    public $tab = 0;

    // TACHES
    // Task Status
    public StatusForm $status_form;
    function status_add(){
        $this->status_form->level = TaskStatus::count()+1;
        $this->dispatch('open-addStatus');
    }
    function status_store(){
        $this->status_form->store();
    }
    function status_edit($status_id){
        $this->dispatch('open-editStatus');
        $this->status_form->set($status_id);
    }
    function status_update(){
        $this->status_form->update();
        $this->dispatch('close-editStatus');
    }
    function status_delete(){
        $this->status_form->delete();
        $this->dispatch('close-editStatus');
    }
}
