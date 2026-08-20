<?php

namespace App\Livewire\Medias;

use App\Livewire\Forms\PersonaForm;
use App\Models\Persona;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class PersonasPage extends Component
{
    use WithPagination;
    use WithFileUploads;

    public $search = '';
    public array $breadcrumbs;
    public PersonaForm $form;

    public function mount()
    {
        $this->breadcrumbs = array(
            array('name' => 'Medias', 'route' => ''),
            array('name' => 'Images', 'route' => ''),
        );
    }

    public function render()
    {
        return view('livewire.medias.personas-page',[
            'personas' => Persona::get()
        ]);
    }

    function store(){
        $this->form->store() ;
        $this->dispatch('close-addPersona');
    }

    function edit(int $id){
        $this->form->set($id);
        $this->dispatch('open-editPersona');
    }

    function update(){
        $this->form->update();
        $this->dispatch('close-editPersona');
    }

    function delete(int $id){
        $this->form->delete($id);
    }
}
