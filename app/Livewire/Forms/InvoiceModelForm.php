<?php

namespace App\Livewire\Forms;

use App\Models\InvoiceModel;
use Livewire\Attributes\Rule;
use Livewire\Attributes\Validate;
use Livewire\Form;

class InvoiceModelForm extends Form
{
    public InvoiceModel $model;

    #[Rule('required')]
    public $invoice_system_id;
    public $name;
    public $description;

    function fix(){
        $this->name = ucfirst($this->name);
    }

    function store(){
        $this->validate();
        $this->fix();
        InvoiceModel::create($this->all());
    }

    function set($model_id){
        $this->model = InvoiceModel::find($model_id);
        $this->invoice_system_id = $this->model->invoice_system_id;
        $this->name = $this->model->name;
        $this->description = $this->model->description;
    }

    function update(){
        $this->validate();
        $this->fix();
        $this->model->update($this->all());
    }

    function delete($model_id){
        $this->model = InvoiceModel::find($model_id);
        $this->model->delete();
    }
}
