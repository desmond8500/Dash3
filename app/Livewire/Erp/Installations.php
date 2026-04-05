<?php

namespace App\Livewire\Erp;

use App\Models\Attribut;
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
            'equipements' => \App\Http\Controllers\ObjetController::Equipements_list(),
            'videos' => \App\Http\Controllers\ObjetController::video(),
            'incendies' => \App\Http\Controllers\ObjetController::incendie(),
            'access' => \App\Http\Controllers\ObjetController::access(),
            'alarmes' => \App\Http\Controllers\ObjetController::alarme(),
            'reseaux' => \App\Http\Controllers\ObjetController::reseaux(),
            'disks' => \App\Http\Controllers\ObjetController::disks(),
            'sublist' => \App\Http\Controllers\ObjetController::sublist('camera'),
        ]);
    }

    function store(){
        $this->validate([
            'type' => 'required',
            'description' => 'required',
        ]);

        \App\Models\Installation::create([
            'projet_id' => $this->projet_id,
            'type' => ucfirst($this->type),
            'description' => $this->description,
        ]);

        $this->type = "";
        $this->description = "";
        $this->dispatch('close-addInstallation');
    }
    public $installation_id;
    function edit($id){
        $installation = \App\Models\Installation::find($id);
        $this->type = ucfirst($installation->type);
        $this->description = $installation->description;
        $this->installation_id = $installation->id;

        $this->dispatch('open-editInstallation', ['id' => $id]);
    }

    function update(){
        $this->validate([
            'type' => 'required',
            'description' => 'required',
        ]);

        $installation = \App\Models\Installation::find($this->installation_id);
        $installation->update([
            'type' => ucfirst($this->type),
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
        Attribut::create([
            'objet_id' => $this->selected_objet->id,
            'name' => ucfirst($this->attribut_name),
            'value' => $this->attribut_value,
        ]);

        $this->dispatch('close-addAttribut');
    }

    public $attribut_id;
    function edit_attribut($attribut_id){
        $attribut = Attribut::find($attribut_id);
        $this->attribut_id = $attribut->id;
        $this->attribut_name = ucfirst($attribut->name);
        $this->attribut_value = $attribut->value;
        $this->dispatch('open-editAttribut');
    }

    function update_attribut(){
        $attribut = Attribut::find($this->attribut_id);
        $attribut->update([
            'name' => ucfirst($this->attribut_name),
            'value' => $this->attribut_value,
        ]);

        $this->dispatch('close-editAttribut');
    }
}
