<?php

namespace App\Livewire\Erp;

use App\Livewire\Forms\InvoiceSpentForm;
use App\Models\Invoice;
use App\Models\InvoiceSpent as ModelsInvoiceSpent;
use App\Traits\dateTrait;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class InvoiceSpent extends Component
{
    use WithPagination;
    use WithFileUploads;


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

    public $file;
    public $spent_id;

    function add_file($spent_id){
        $this->spent_id = $spent_id;
        $this->dispatch('open-add-invoiceSpentFile');
    }

    function store_file()
    {
        $spent = ModelsInvoiceSpent::find($this->spent_id);

        $dir = "erp/clients/".$spent->invoice->projet->client->id."/".$spent->invoice->projet->id."/".$spent->invoice->id."/".$spent->id."/files";

        $name = $this->file->getClientOriginalName();
        $this->file->storeAs("public/$dir", $name);

        $spent->file = "storage/$dir/$name";
        $spent->save();

        $this->dispatch('close-add-invoiceSpentFile');
    }
    function delete_file($spent_id)
    {
        $spent = ModelsInvoiceSpent::find($spent_id);
        unlink($spent->file);
        $spent->file = null;
        $spent->save();
    }


}
