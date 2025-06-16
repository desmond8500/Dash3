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
    public $invoice_id;
    public $logo;
    public $client_name;
    public $projet_name;
    public $description;
    public $footer;
    public $details;


    function store(){
        $this->validate();
        InvoiceProposal::create($this->all());
    }

    function set($model_id){
        $this->proposal = InvoiceProposal::find($model_id);
        $this->invoice_id = $this->proposal->invoice_id;
        $this->logo = $this->proposal->logo;
        $this->client_name = $this->proposal->client_name;
        $this->projet_name = $this->proposal->projet_name;
        $this->description = $this->proposal->description;
        $this->footer = $this->proposal->footer;
        $this->details = $this->proposal->details;
    }

    function update(){
        // $this->validate();
        $this->proposal->update($this->all());
    }

    function delete($model_id){
        $this->proposal = InvoiceProposal::find($model_id);
        $this->proposal->delete();
    }
}
