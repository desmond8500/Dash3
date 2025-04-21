<?php

namespace App\Livewire\Form;

use App\Livewire\Forms\QuantitatifForm;
use App\Models\Building;
use App\Models\Invoice;
use App\Models\Quantitatif;
use Livewire\Component;

class QuantitatifAdd extends Component
{
    public $building;

    function mount($building_id)
    {
        $this->building = Building::find($building_id);
    }

    public function render()
    {
        return view('livewire.form.quantitatif-add',[
            'invoices' => Invoice::where('projet_id', $this->building->projet->id)->get(),
        ]);
    }

    public $selectedInvoice;
    function selectInvoice($invoice_id)
    {
        $this->selectedInvoice = Invoice::find($invoice_id);
        $this->quantitatif_name = $this->selectedInvoice->description;
    }

    public $quantitatif_name;
    public QuantitatifForm $q_row;
    public $message = '';

    function quantitatif_store()
    {
        $invoice = Invoice::find($this->selectedInvoice->id);
        $quantitatif = Quantitatif::create([
            'building_id' => $this->building->id,
            'devis_id' => $invoice->id,
            'name' => $this->quantitatif_name,
        ]);
        $this->message = 'Quantitatif créé';

        $this->q_row->create_articles($invoice->rows, $quantitatif);
        $this->dispatch('get-quantitatif');
    }


}
