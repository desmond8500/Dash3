<?php

namespace App\Livewire\Erp;

use App\Livewire\Forms\PvForm;
use App\Models\Invoice;
use App\Models\Pv;
use Livewire\Component;

class PvPage extends Component
{
    public $invoice_id;
    public $breadcrumbs;

    public function mount($invoice_id)
    {
        $this->invoice_id = $invoice_id;
        $devis = Invoice::find($invoice_id);



        $this->breadcrumbs = array(
            array('name' => 'Clients', 'route' => route('clients')),
            array('name' => $devis->projet->client->name, 'route' => route('clients', ['client_id' => $devis->projet->client->id])),
            array('name' => $devis->projet->name, 'route' => route('projet', ['projet_id' => $devis->projet->id])),
            array('name' => "Devis", 'route' => route('invoice', ['invoice_id' => $devis->id])),
        );
    }
    public function render()
    {
        return view('livewire.erp.pv-page',[
            'pv' => Pv::where('invoice_id', $this->invoice_id)->first()
        ]);
    }

    public PvForm $pv_form;



}
