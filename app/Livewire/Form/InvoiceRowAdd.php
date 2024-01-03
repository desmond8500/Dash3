<?php

namespace App\Livewire\Form;

use App\Http\Controllers\ErpController;
use App\Models\InvoiceRow;
use Livewire\Attributes\Validate;
use Livewire\Component;

class InvoiceRowAdd extends Component
{
    #[Validate('required')]
    public $invoice_section_id;
    #[Validate('required')]
    public $designation;
    #[Validate('required')]
    public $coef = 1;
    #[Validate('required')]
    public $reference;
    #[Validate('required')]
    public $quantite = 1;
    #[Validate('required')]
    public $prix = 0;
    #[Validate('required')]
    public $priorite = 1;

    function mount($id)  {
        $this->invoice_section_id = $id;
    }

    public function render()
    {
        return view('livewire.form.invoice-row-add',[
            'priorites' => ErpController::getPriority()
        ]);
    }

    function addArticle($id){
        $this->invoice_section_id = $id;
        $this->dispatch('open-invoiceRowAdd');
    }

    function store() {
        $this->validate();

        InvoiceRow::create([
            'invoice_section_id' => $this->invoice_section_id,
            'designation' => $this->designation,
            // 'designation' => $this->invoice_section_id,
            'coef' => $this->coef,
            'reference' => $this->reference,
            'quantite' => $this->quantite,
            'prix' => $this->prix,
            'priorite' => $this->priorite,
        ]);

        $this->dispatch('close-invoiceRowAdd');
        $this->dispatch('invoice-section-reload');
    }
}
