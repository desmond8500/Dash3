<?php

namespace App\Livewire\Erp;

use App\Models\Invoice;
use App\Models\TaskStatus;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\WithFileUploads;
use Livewire\WithPagination;

class InvoicesPage extends Component
{
    use WithPagination;
    use WithFileUploads;

    protected $paginationTheme = 'bootstrap';
    public $search = '';
    public $breadcrumbs;

    public function mount()
    {
        $this->breadcrumbs = array(
            array('name' => 'Devis', 'route' => route('invoices')),
        );
    }

    public function render()
    {
        return view('livewire.erp.invoices-page',[
            'invoices' => $this->filter_invoices(),
            'statuses' => TaskStatus::all(),
        ]);
    }


    public $filter;

    function filter_invoices(){
        if ($this->filter) {
            return Invoice::where('statut', $this->filter)->search($this->search, 'reference')->paginate(18);
        } else {
            return Invoice::search($this->search, 'reference')->paginate(18);
        }

    }
}
