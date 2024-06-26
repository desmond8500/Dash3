<?php

namespace App\Livewire\Erp;

use App\Livewire\Forms\ProjetNoteForm as FormsProjetNoteForm;
use App\Models\ProjetNote;
use Livewire\Component;
use ProjetNoteForm;

class ProjetNotes extends Component
{
    public $projet_id;

    function mount($projet_id){
        $this->projet_id = $projet_id;
        $this->projet_note_form->projet_id = $projet_id;
    }

    public function render()
    {
        return view('livewire.erp.projet-notes',[
            'notes' => $this->getNotes(),
        ]);
    }

    function getNotes(){
        return ProjetNote::where('projet_id', $this->projet_id)->paginate(10);
    }

    public FormsProjetNoteForm $projet_note_form;

    function store(){
        $this->projet_note_form->store();
        $this->dispatch('close-addProjetNote');
    }

    function edit($note_id){
        $this->projet_note_form->set($note_id);
        $this->dispatch('open-editProjetNote');
    }

    function update(){
        $this->projet_note_form->update();
        $this->dispatch('close-editProjetNote');
    }

    function delete($id){
        $this->projet_note_form->delete($id);
    }
}
