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
    public $file;

    function store($id)
    {
        $this->invoice_id = $id;
        $this->validate();
        InvoiceSpent::create($this->all());
    }

    function add_transaction($invoice_spent_id)
    {
        $spent = InvoiceSpent::find($invoice_spent_id);
        $transaction = Transaction::create([
            'invoice_spent_id' => $invoice_spent_id,
            'objet' => $spent->name,
            'description' => $spent->description,
            'montant' => $spent->montant,
            'date' => $spent->date,
            'type' => 'debit'
        ]);
        $spent->transaction_id = $transaction->id;
        $spent->save();
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
