<?php

namespace App\Livewire\Form;

use App\Http\Controllers\ErpController;
use App\Livewire\Forms\InvoiceForm;
use App\Models\Invoice;
use App\Models\Projet;
use Livewire\Attributes\Validate;
use Livewire\Component;

class InvoiceAdd extends Component
{
    public InvoiceForm $invoice_form;
    public $client_name;
    public $projet;
    public $projet_name;

    function mount($projet_id){
        $this->projet = Projet::find($projet_id);

        $this->projet_name = $this->projet->name;
        $this->client_name = $this->projet->client->name;
    }

    public function render()
    {
        return view('livewire.form.invoice-add');
    }

    function ajouter(){
        $this->invoice_form->projet_id = $this->projet->id;
        $this->invoice_form->statut = 'Nouveau';
        $this->invoice_form->remise = 0;
        $this->invoice_form->tax = 0;
        $this->invoice_form->reference = ErpController::getInvoiceReference($this->projet);
        $this->dispatch('open-addInvoice');
    }

    function store(){
        // $this->validate();
        $this->invoice_form->store();
        // Invoice::firstOrCreate([
        //     'projet_id' => $this->projet->id,
        //     'client_name' => $this->client_name,
        //     'projet_name' => $this->projet_name,
        //     'reference' => $this->reference,
        //     'description' => $this->description,
        //     'modalite' => $this->modalite,
        //     'note' => $this->note,
        //     'statut' => $this->statut,
        //     'tax' => $this->tax,
        //     'remise' => $this->remise,
        // ]);

        $this->dispatch('close-addInvoice');
        $this->dispatch('get-invoices');
    }
}
