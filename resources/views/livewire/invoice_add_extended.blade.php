<?php

use Livewire\Volt\Component;
use App\Livewire\Forms\InvoiceForm;
use App\Livewire\Forms\TimelineForm;
use App\Models\Projet;
use Livewire\WithPagination;
use App\Http\Controllers\ErpController;

new class extends Component {
    use WithPagination;
    public InvoiceForm $invoice_form;
    public $client_name;
    public $projet;
    public $projet_name;
    public TimelineForm $timeline_form;

    function mount($projet_id){
        $this->projet = Projet::find($projet_id);

        $this->projet_name = $this->projet->name;
        $this->client_name = $this->projet->client->name;
    }

       function ajouter(){
        $this->invoice_form->projet_id = $this->projet->id;
        $this->invoice_form->statut = 'Nouveau';
        $this->invoice_form->remise = 0;
        $this->invoice_form->tax = 0;
        $this->invoice_form->reference = ErpController::getInvoiceReference($this->projet);
        $this->dispatch('open-addInvoice');
        $this->dispatch('get-resume');

    }

    function store(){
        $invoice  = $this->invoice_form->store();
        $this->timeline_form->add_invoice($this->projet->id, $invoice->id);

        $this->dispatch('close-addInvoice');
        $this->dispatch('get-invoices');
    }
}; ?>

<div>
     <a class="btn btn-primary btn-pill" wire:click="ajouter()">
        <i class="ti ti-plus"></i>Devis
    </a>

    @component('components.modal', ["id"=>'addInvoice', 'title'=>'Ajouter un devis', 'method'=>'store'])
        <form class="row" wire:submit="store">
            @include('_form.invoice_form')
        </form>

        <script> window.addEventListener('open-addInvoice', event => { window.$('#addInvoice').modal('show'); }) </script>
        <script> window.addEventListener('close-addInvoice', event => { window.$('#addInvoice').modal('hide'); }) </script>
    @endcomponent
</div>
