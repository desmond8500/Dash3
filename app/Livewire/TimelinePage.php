<?php

namespace App\Livewire;

use App\Models\Projet;
use Livewire\Component;

class TimelinePage extends Component
{
    public $projet_id;
    public $projet;
    public $breadcrumbs;

    public function mount($projet_id)
    {
        $this->projet = Projet::find($projet_id);

        $this->breadcrumbs = array(
            array('name' => 'Clients', 'route' => route('clients')),
            array('name' => $this->projet->client->name, 'route' => route('projets', ['client_id' => $this->projet->client->id])),
            array('name' => $this->projet->name, 'route' => route('projet', ['projet_id' => $this->projet->id])),
        );
    }

    public function render()
    {
        return view('livewire.timeline-page');
    }
}
