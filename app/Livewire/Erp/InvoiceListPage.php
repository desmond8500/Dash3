<?php

namespace App\Livewire\Erp;

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
            'invoices' => Invoice::orderByDesc('created_at')->search($this->search,'reference')->paginate(6)
        ]);
    }
}
