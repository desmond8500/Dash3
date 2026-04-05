<?php

namespace App\Livewire\Erp;

use App\Models\Systeme;
use Livewire\Component;

class Installations extends Component
{
    public $projet_id;
    public $type;
    public $description;

    public function render()
    {
        return view('livewire.erp.installations', [
            'installations' => \App\Models\Installation::where('projet_id', $this->projet_id)->get(),
            'systems' => Systeme::all(),
        ]);
    }

    function store(){
        $this->validate([
            'type' => 'required',
            'description' => 'required',
        ]);

        \App\Models\Installation::create([
            'projet_id' => $this->projet_id,
            'type' => $this->type,
            'description' => $this->description,
        ]);

        $this->type = "";
        $this->description = "";
        $this->dispatch('close-addInstallation');
    }

    function edit($id){
        $installation = \App\Models\Installation::find($id);
        $this->type = $installation->type;
        $this->description = $installation->description;

        $this->dispatch('open-editInstallation', ['id' => $id]);
    }

    function update($id){
        $this->validate([
            'type' => 'required',
            'description' => 'required',
        ]);

        $installation = \App\Models\Installation::find($id);
        $installation->update([
            'type' => $this->type,
            'description' => $this->description,
        ]);

        $this->type = "";
        $this->description = "";
        $this->dispatch('close-editInstallation');
    }

    function delete($id){
        $installation = \App\Models\Installation::find($id);
        $installation->delete();
    }

    public $attribut_name;
    public $attribut_value;
    public $selected_objet;

    function add_attribut($objet_id){
        $objet = \App\Models\Objet::find($objet_id);
        $this->selected_objet = $objet;
        $this->dispatch('open-addAttribut');
    }
    function store_attribut(){
        $attributs = $this->selected_objet->attributs;
        $attributs[] = ['name' => $this->attribut_name, 'value' => $this->attribut_value];
        $this->selected_objet->update(['attributs' => $attributs]);
        $this->dispatch('close-addAttribut');
    }
}
