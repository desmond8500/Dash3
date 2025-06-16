<?php

namespace App\Livewire\Erp;

use App\Models\Invoice;
use App\Models\InvoiceProposal;
use Livewire\Component;

class InvoiceProposalPage extends Component
{
    public $breadcrumbs;
    public $proposal_id;
    public $devis;

    function mount($proposal_id)
    {
        $this->proposal_id = $proposal_id;
        $proposal = InvoiceProposal::find($proposal_id);
        $this->devis = Invoice::find($proposal->invoice->id);
        $this->breadcrumbs = array(
            array('name' => 'Clients', 'route' => route('clients')),
            array('name' => 'Projets', 'route' => route('projets', ['client_id' => $proposal->invoice->projet->id])),
            array('name' => 'Devis', 'route' => route('invoice', ['invoice_id' => $proposal->invoice->id])),
            array('name' => 'Propositions de devis', 'route' => route('invoice_proposal', ['proposal_id' => $proposal->id])),
        );
    }

    public function render()
    {
        return view('livewire.erp.invoice-proposal-page');
    }
}
