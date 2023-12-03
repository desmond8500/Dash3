<?php

namespace App\Livewire\Form;

use App\Models\Invoice;
use App\Models\Projet;
use Livewire\Attributes\Validate;
use Livewire\Component;

class InvoiceAdd extends Component
{
    public $client_name;
    public $projet;
    public $projet_name;

    #[Validate('required')]
    public $reference;
    public $description;
    public $modalite;
    public $note;
    public $statut;
    public $tax;
    public $remise;

    function mount($projet_id){
        $this->projet = Projet::find($projet_id);

        $this->projet_name = $this->projet->name;
        $this->client_name = $this->projet->client->name;

        $count = Invoice::count();
        if ($count) {
            $this->reference = substr(strtoupper($this->projet->client->name), 0, 3) . "-" . sprintf("%03d", Invoice::latest()->first()->id + 1) . '-' . date('y');
        } else {
            $this->reference = substr(strtoupper($this->projet->client->name), 0, 3) . "-" . sprintf("%03d", 1) . '-' . date('y');
        }

    }

    public function render()
    {
        return view('livewire.form.invoice-add');
    }

    function store(){
        Invoice::firstOrCreate([
            'projet_id' => $this->projet->id,
            'client_name' => $this->client_name,
            'projet_name' => $this->projet_name,
            'reference' => $this->reference,
            'description' => $this->description,
            'modalite' => $this->modalite,
            'note' => $this->note,
            'statut' => $this->statut,
            'tax' => $this->tax,
            'remise' => $this->remise,
        ]);
    }
}
