<?php

namespace App\Livewire\Forms;

use App\Models\InvoiceProposal;
use Livewire\Attributes\Rule;
use Livewire\Attributes\Validate;
use Livewire\Form;

class InvoiceProposalForm extends Form
{
    public InvoiceProposal $proposal;

    #[Rule('required')]
    public int $invoice_id;
    public mixed $logo;
    public int $client_name = 0;
    public int $projet_name = 0;
    public int $description = 0;
    public bool $footer = false;
    public bool $details = false;
    public string $company_name = '';


    function store(){
        $this->validate();
        InvoiceProposal::create($this->all());
    }

    function set(int $model_id){
        $this->proposal = InvoiceProposal::find($model_id);
        $this->invoice_id = $this->proposal->invoice_id;
        $this->logo = $this->proposal->logo;
        $this->client_name = $this->proposal->client_name;
        $this->projet_name = $this->proposal->projet_name;
        $this->description = $this->proposal->description;
        $this->footer = $this->proposal->footer;
        $this->details = $this->proposal->details;
        $this->company_name = $this->proposal->company_name;
    }

    function update(){
        // $this->validate();
        $this->proposal->update($this->all());
    }

    function delete(int $model_id){
        $this->proposal = InvoiceProposal::find($model_id);
        $this->proposal->delete();
    }
}
