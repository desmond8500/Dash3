<?php

namespace App\Livewire\Erp;

use App\Livewire\Forms\TeamForm;
use App\Models\Team;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class TeamPage extends Component
{

    use WithPagination;
    use WithFileUploads;

    public $search = '';
    public $breadcrumbs;
    public TeamForm $team_form;

    function mount()
    {
        $this->breadcrumbs = array(
            array('name' => 'Equipe', 'route' => route('team')),
        );
    }

    public function render()
    {
        return view('livewire.erp.team-page',[
            'equipe' => Team::paginate(5),
        ]);
    }

    function store(){
        $this->team_form->store();
        $this->dispatch('close-adTeam');
    }

    function edit($id){
        $this->dispatch('open-editTeam');
        $this->team_form->set($id);
    }

    function update(){
        $this->team_form->update();
        $this->dispatch('close-editTeam');
    }

    function delete($id){
        $this->team_form->delete($id);
    }
}
