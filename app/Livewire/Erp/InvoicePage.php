<?php

namespace App\Livewire\Erp;

use App\Livewire\Forms\InvoiceForm;
use App\Models\Invoice;
use App\Models\InvoiceRow;
use App\Models\InvoiceSection;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class InvoicePage extends Component
{
    use WithPagination;
    use WithFileUploads;

    protected $paginationTheme = 'bootstrap';
    public $search ='';
    public $breadcrumbs;
    public $devis, $devis_id;

    public function mount($invoice_id){
        $this->devis = Invoice::find($invoice_id);

        $this->breadcrumbs = array(
            array('name' => 'Clients', 'route' => route('clients')),
            array('name' => $this->devis->projet->client->name, 'route' => route('clients', ['client_id' => $this->devis->projet->client->id])),
            array('name' => $this->devis->projet->name, 'route' => route('projet', ['projet_id' => $this->devis->projet->id])),
            array('name' => "Devis", 'route' => route('invoice', ['invoice_id' => $this->devis->id])),
        );

        $this->ordre = InvoiceSection::where('invoice_id', $this->devis->id)->count()+1;
    }

    function ProjetSearch() {
        // return ::where('client_id', $this->client_id)->where('name', 'like', '%' . $this->search . '%')->paginate(10);
    }

    public function render()
    {
        return view('livewire.erp.invoice-page',[
            'sections' => $this->getSections()
        ]);
    }

    #[On('invoice-section-reload') ]
    function getSections() {
        return InvoiceSection::where('invoice_id', $this->devis->id)->get();
    }

    // Row
    function deleteRow($id){
        $row = InvoiceRow::find($id);
        $row->delete();
    }

    // Section
    public $section, $ordre;

    function sectionStore(){
        InvoiceSection::create([
            'invoice_id' => $this->devis->id,
            'section'    => $this->section,
            'ordre'      => $this->ordre,
        ]);
        $this->ordre++;
        $this->dispatch('close-addSection');
    }

    public InvoiceForm $invoice_form;

    function edit($id){
        $this->invoice_form->set($id);
        $this->dispatch('open-editInvoice');
    }

    function update_invoice()
    {
        $this->invoice_form->update();
        $this->devis = Invoice::find($this->devis->id);
        $this->dispatch('close-editInvoice');
    }


}
