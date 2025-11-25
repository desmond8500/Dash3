<?php

namespace App\Livewire\Forms;

use App\Models\Projet;
use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;
use Livewire\Attributes\Rule;
use Livewire\Attributes\Validate;
use Livewire\Form;

class projetForm extends Form
{
    public Projet $projet;

    #[Rule('required')]
    public $name;
    #[Rule('required')]
    public $client_id;
    public $description;
    public $start_date;
    public $end_date;
    public $favorite = 0;


    function set($projet_id){
        $this->projet = Projet::find($projet_id);

        $this->client_id = $this->projet->client_id;
        $this->name = $this->projet->name;
        $this->description = $this->projet->description;
        $this->start_date = $this->projet->start_date;
        $this->end_date = $this->projet->end_date;
        $this->favorite = $this->projet->favorite;
    }

    function store(){
        $this->validate();
        $projet = Projet::create($this->all());
        $projet->name = ucfirst($projet->name);
        $projet->description = ucfirst($projet->description);
        $projet->save();
    }

    function update() {
        $this->projet->update($this->all());
        $this->projet->name = ucfirst($this->projet->name);
        $this->projet->description = ucfirst($this->projet->description);
        $this->projet->save();
    }

    function delete() {

    }

    function favorite()
    {
        if ($this->favorite) {
            $this->favorite = 0;
            $message = 'Le projet a été ajouté aux favoris';
        } else {
            $this->favorite = 1;
            $message = 'Le projet a été supprimé des favoris';
        }
        $this->projet->update($this->only('favorite'));

        LivewireAlert::text($message)
            ->position('top-end')
            ->toast()
            ->success()
            ->show();

        return $this->favorite;
    }
}
