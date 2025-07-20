<?php

namespace App\Livewire\Erp;

use App\Http\Controllers\InvoiceController;
use App\Livewire\Forms\InvoiceForm;
use App\Models\Invoice;
use Livewire\Component;
use Livewire\WithPagination;

class InvoiceListPage extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $breadcrumbs;
    public $search;

    function mount(){
        $this->breadcrumbs = array(
            array('name' => 'ERP', 'route' => route('erp')),
            array('name' => 'Devis', 'route' => route('invoicelist')),
        );
    }

    public function render()
    {
        return view('livewire.erp.invoice-list-page',[
            'invoices' => Invoice::orderByDesc('created_at')->search($this->search,'reference')->paginate(16),
            'statuses' => InvoiceController::statut(),
        ]);
    }

    function update_status($invoice_id, $status){
        $invoice = Invoice::find($invoice_id);
        $invoice->statut = $status;
        $invoice->save();
    }

    public InvoiceForm $invoice_form;

    function edit($id)
    {
        $this->invoice_form->set($id);
        $this->dispatch('open-editInvoice');
    }

    function update_invoice()
    {
        $this->invoice_form->update();
        // $this->devis = Invoice::find($this->devis->id);
        $this->dispatch('close-editInvoice');
    }
}
