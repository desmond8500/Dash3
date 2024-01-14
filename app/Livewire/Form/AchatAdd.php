<?php

namespace App\Livewire\Form;

use App\Models\Achat;
use App\Models\Provider;
use Livewire\Attributes\Validate;
use Livewire\Component;

class AchatAdd extends Component
{
    public function render() {
        return view('livewire.form.achat-add',[
            'providers' => Provider::all(),
        ]);
    }

    #[Validate('required')]
    public $name;
    public $provider_id;
    public $description;
    #[Validate('required')]
    public $date;

    function store(){
        $this->validate();
        Achat::firstOrCreate([
            'name' => $this->name,
            'provider_id' => $this->provider_id,
            'date' => $this->date,
            'description' => $this->description,
        ]);

        $this->dispatch('close-addAchat');
    }

}

