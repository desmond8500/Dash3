<?php

namespace App\Livewire\Forms;

use App\Models\Badge;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Rule;
use Livewire\Attributes\Validate;
use Livewire\Form;

class BadgeForm extends Form
{
    public Badge $badge;

    #[Rule('required')]
    public $projet_id;
    public $prenom;
    public $nom;
    public $fonction;
    public $service;
    public $direction;
    public $photo;
    public $matricule;
    public $adresse;

    function fix(){
        $this->prenom = ucfirst($this->prenom);
        $this->nom = ucfirst($this->nom);
        $this->fonction = ucfirst($this->fonction);
        $this->service = ucfirst($this->service);
        $this->direction = ucfirst($this->direction);
    }


    function store(){
        $this->validate();
        $badge = Badge::create($this->all());

        if ($this->photo) {
            $this->storeAvatar($badge, $this->photo);
        }

        $this->reset('prenom', 'nom', 'fonction', 'service', 'direction', 'photo');
    }

    function storeAvatar($client, $photo, $delete = false){
        if (!is_string($this->photo)) {
            $dir = "erp/clients/client->id/photo";
            if ($delete) {
                Storage::disk('public')->deleteDirectory($dir);
            }
            $name = $photo->getClientOriginalName();
            $photo->storeAs("public/$dir", $name);

            $client->photo = "storage/$dir/$name";
            $client->save();
        }
    }

    function set($model_id){
        $this->badge = Badge::find($model_id);

        $this->projet_id = $this->badge->projet_id;
        $this->prenom = $this->badge->prenom;
        $this->nom = $this->badge->nom;
        $this->fonction = $this->badge->fonction;
        $this->service = $this->badge->service;
        $this->direction = $this->badge->direction;
        $this->photo = $this->badge->photo;
        $this->matricule = $this->badge->matricule;
        $this->adresse = $this->badge->adresse;
    }

    function update(){
        $this->validate();
        $this->badge->update($this->all());

        if ($this->photo) {
            $this->storeAvatar($this->badge, $this->photo );
        }
    }

    function delete($id){
        $this->badge = Badge::find($id);
        $this->badge->delete();
    }
}
