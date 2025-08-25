<?php

namespace App\Livewire\Erp;

use App\Livewire\Forms\InvoiceSpentForm;
use App\Models\Invoice;
use App\Models\InvoiceSpent as ModelsInvoiceSpent;
use App\Traits\dateTrait;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class InvoiceSpent extends Component
{
    use WithPagination;


    protected $paginationTheme = 'bootstrap';
    public $search = '';

    public function mount($invoice_id)
    {
        $this->invoice = Invoice::find($invoice_id);
    }

    #[On('get_invoice_spent')]
    function getSearch()
    {
        return $this->invoice->spents;
    }

    public function render()
    {
        return view('livewire.erp.invoice-spent',[
            'spents' => $this->getSearch(),
        ]);
    }

    public $invoice;
    public InvoiceSpentForm $spent_form;

    function store()
    {
        $this->spent_form->store($this->invoice->id);
        $this->dispatch('close-add-invoiceSpent');
    }

    function edit($id)
    {
        $this->spent_form->set($id);
        $this->dispatch('open-edit-invoiceSpent');
    }

    function update()
    {
        $this->spent_form->update();
        $this->dispatch('close-edit-invoiceSpent');
    }

    function delete($id)
    {
        $this->spent_form->delete($id);
    }
}
