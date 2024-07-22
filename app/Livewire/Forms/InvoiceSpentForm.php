<?php

namespace App\Livewire\Forms;

use App\Models\InvoiceSpent;
use App\Models\Transaction;
use Livewire\Attributes\Rule;
use Livewire\Attributes\Validate;
use Livewire\Form;

class InvoiceSpentForm extends Form
{
    public InvoiceSpent $spent;

    public $invoice_id;
    #[Rule('required')]
    public $name;
    public $description;
    #[Rule('numeric')]
    public $montant;
    #[Rule('date')]
    public $date;
    public $status;

    function store($id)
    {
        $this->invoice_id = $id;
        $this->validate();
        $spent = InvoiceSpent::create($this->all());

        Transaction::create([
            'invoice_spent_id' => $spent->id,
            'objet' => $spent->objet,
            'type' => "depense",
            'date' => $spent->date,
            'montant' =>$spent->montant,
        ]);
    }

    function select($model_id)
    {
        return InvoiceSpent::find($model_id);
    }

    function set($model_id)
    {
        $this->spent = $this->select($model_id);

        $this->invoice_id = $this->spent->invoice_id;
        $this->name = $this->spent->name;
        $this->description = $this->spent->description;
        $this->montant = $this->spent->montant;
        $this->date = $this->spent->date;
    }

    function update()
    {
        $this->validate();
        $this->spent->update($this->all());
    }

    function delete($id)
    {
        $this->spent = $this->select($id);
        $this->spent->delete();
    }
}
