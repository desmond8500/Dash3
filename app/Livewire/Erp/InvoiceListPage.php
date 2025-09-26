<?php

namespace App\Livewire\Erp;

use App\Http\Controllers\InvoiceController;
use App\Livewire\Forms\InvoiceForm;
use App\Models\Invoice;
use Livewire\Attributes\Session;
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
            'invoices' => $this->get_invoices(),
            'statuses' => InvoiceController::statut(),
        ]);
    }

    #[Session()]
    public $statut;
    function get_invoices(){
        if ($this->statut) {
            return Invoice::orderByDesc('created_at')->where('statut', $this->statut)->search($this->search,'reference')->paginate(16);
        } else {
            return Invoice::orderByDesc('created_at')->search($this->search,'reference')->paginate(16);
        }

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
