<?php

namespace App\Livewire\Erp;

use App\Livewire\Forms\EmailForm;
use App\Livewire\Forms\PhoneForm;
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
    public PhoneForm $phone_form;
    public EmailForm $email_form;

    function mount()
    {
        $this->breadcrumbs = array(
            array('name' => 'Equipe', 'route' => route('team')),
        );
    }

    public function render()
    {
        return view('livewire.erp.team-page',[
            'equipe' => Team::paginate(18),
        ]);
    }

    function store(){
        $team = $this->team_form->store();
        $this->dispatch('close-addTeam');
        if ($this->email_form->email) {
            $this->email_form->team_id = $team->id;
            $this->email_form->store();
        }
        if ($this->phone_form->phone) {
            $this->phone_form->team_id = $team->id;
            $this->phone_form->store();
        }
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
