<?php

namespace App\Livewire\Forms;

use App\Models\Persona as ModelsPersona;
use Livewire\Attributes\Rule;
use Livewire\Form;

class PersonaForm extends Form
{
    public ModelsPersona $persona;

    #[Rule('required')]
    public string $fistname;
    public string $lastname;
    public string $description;
    public string $avatar;

    function fix(){
        $this->fistname = ucfirst($this->fistname);
        $this->lastname = ucfirst($this->lastname);
    }

    function store(){
        $this->validate();
        ModelsPersona::create($this->all());
    }

    function set(int $persona_id){
        $this->persona = ModelsPersona::find($persona_id);
        $this->fistname = $this->persona->fistname;
        $this->lastname = $this->persona->lastname;
        $this->description = $this->persona->description;
    }

    function update(){
        $this->validate();
        $this->persona->update($this->all());
    }

    function delete(int $persona_id){
        $this->persona = ModelsPersona::find($persona_id);

        // unlink(this->persona->path);
        // rmdir(dirname(this->persona->path));

        $this->persona->delete();
    }
}
