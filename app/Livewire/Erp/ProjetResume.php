<?php

namespace App\Livewire\Erp;

use App\Http\Controllers\InvoiceController;
use App\Livewire\Forms\InvoiceForm;
use App\Livewire\Forms\projetForm;
use App\Models\Building;
use App\Models\Invoice;
use App\Models\Projet;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class ProjetResume extends Component
{
    use WithPagination;
    public $projet_id;
    public $invoice_search;

    function mount($projet_id){
        $this->projet_id = $projet_id;
        $this->projetForm->set($projet_id);
    }

    #[On('get-invoices')]
    public function render()
    {
        return view('livewire.erp.projet-resume',[
            'projet' => Projet::find($this->projet_id),
            'invoices' => Invoice::where('projet_id', $this->projet_id)
                ->search($this->invoice_search,'reference')
                ->paginate(5),
            'buildings' => Building::where('projet_id', $this->projet_id)->get(),
            'statuses' => InvoiceController::statut(),
        ]);
    }

    // Projets
    public projetForm $projetForm;
    public InvoiceForm $invoiceForm;

    function favorite()
    {
        $this->projetForm->favorite();
    }

    function edit()
    {
        $this->projetForm->set($this->projet_id);
        $this->dispatch('open-editProjet');
    }

    function update()
    {
        $this->projetForm->update();
        $this->dispatch('close-editProjet');
    }

    function update_status($invoice_id, $status)
    {
        $invoice = Invoice::find($invoice_id);
        $invoice->statut = $status;
        $invoice->save();
    }

    // Invoice
    public InvoiceForm $invoice_form;

    function editInvoice($id)
    {
        $this->invoice_form->set($id);
        $this->dispatch('open-editInvoice');
    }

    function update_invoice()
    {
        $this->invoice_form->update();
        $this->dispatch('close-editInvoice');
    }
    function delete_invoice($id)
    {
        $this->invoice_form->set($id);
        $message = $this->invoice_form->delete();

        if ($message == 'error') {
            $this->js("alert('Ce devis contient des sections, veuillez les supprimer avant ')");
        }

        $this->dispatch('close-editInvoice');
    }

    function toggleInvoiceFavorite()
    {
        $this->invoice_form->favorite();
    }

    function dupliquer($invoice_id){
        $this->invoiceForm->replicate($invoice_id);
    }
}
