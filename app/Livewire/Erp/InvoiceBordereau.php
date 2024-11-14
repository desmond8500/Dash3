<?php

namespace App\Livewire\Erp;

use App\Livewire\Forms\BlForm;
use App\Models\InvoiceBl;
use Livewire\Component;

class InvoiceBordereau extends Component
{
    public $invoice_id;


    function mount($invoice_id){
        $this->invoice_id = $invoice_id;
    }

    public function render()
    {
        return view('livewire.erp.invoice-bordereau',[
            'bls' => InvoiceBl::where('invoice_id', $this->invoice_id)->get(),
        ]);
    }

    public $bl;
    public BlForm $bl_form;

    function store(){
        $this->bl_form->invoice_id = $this->invoice_id;
        $this->bl_form->store();
        $this->dispatch('close-addBL');
    }

    function edit($id){
        $this->bl_form->set($id);
        $this->dispatch('open-editBL');
    }

    function update(){
        $this->bl_form->update();
        $this->dispatch('close-editBL');
    }

    function delete(){
        $this->bl_form->delete();
    }
}
