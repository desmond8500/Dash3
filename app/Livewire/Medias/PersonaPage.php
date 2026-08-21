<?php

namespace App\Livewire\Medias;

use App\Livewire\Forms\PersonaForm;
use App\Models\Persona;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class PersonaPage extends Component
{
    use WithPagination;
    use WithFileUploads;

    public $search = '';
    public $persona_id = '';
    public array $breadcrumbs;
    public PersonaForm $form;

    public function mount(int $persona_id)
    {
        $this->persona_id = $persona_id;
        $this->breadcrumbs = array(
            array('name' => 'Medias', 'route' => ''),
            array('name' => 'Personas', 'route' => '/personas'),
            array('name' => 'Persona', 'route' => 'persona'),
        );
    }

    public function render()
    {
        return view('livewire.medias.persona-page',[
            'persona' => Persona::find($this->persona_id),
        ]);
    }
}
