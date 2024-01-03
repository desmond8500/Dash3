<?php

namespace App\Livewire\Form;

use App\Http\Controllers\ErpController;
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
    #[Validate('required')]
    public $description;
    public $modalite;
    public $note;
    public $statut = 'Proforma';
    public $tax = '0';
    public $remise = '0';

    function mount($projet_id){
        $this->projet = Projet::find($projet_id);

        $this->projet_name = $this->projet->name;
        $this->client_name = $this->projet->client->name;

        $this->reference = ErpController::getInvoiceReference($this->projet);
    }

    public function render()
    {
        return view('livewire.form.invoice-add');
    }

    function store(){
        $this->validate();
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

        $this->dispatch('close-addInvoice');
        $this->dispatch('invoice-added');
    }
}
