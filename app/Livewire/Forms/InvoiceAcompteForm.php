<?php

namespace App\Livewire\Forms;

use App\Models\InvoiceAcompte;
use App\Models\Transaction;
use Livewire\Attributes\Rule;
use Livewire\Form;

class InvoiceAcompteForm extends Form
{
    public InvoiceAcompte $acompte;

    public $invoice_id;
    #[Rule('required')]
    public $name;
    public $description;
    #[Rule('numeric')]
    public $montant;
    public $statut = false;
    #[Rule('date')]
    public $date;

    function store($id){
        $this->invoice_id = $id;
        $this->validate();
        InvoiceAcompte::create($this->all());
    }

    function add_transaction($invoice_acompte_id)
    {
        $acompte = InvoiceAcompte::find($invoice_acompte_id);
        $transaction = Transaction::create([
            'invoice_acompte_id' => $invoice_acompte_id,
            'objet' => $acompte->name,
            'description' => $acompte->description,
            'montant' => $acompte->montant,
            'date' => $acompte->date,
            'type' => 'credit'
        ]);
        $acompte->transaction_id = $transaction->id;
        $acompte->save();
    }

    function select($model_id){
        return InvoiceAcompte::find($model_id);
    }

    function set($model_id){
        $this->acompte = $this->select($model_id);

        $this->invoice_id = $this->acompte->invoice_id;
        $this->name = $this->acompte->name;
        $this->description = $this->acompte->description;
        $this->montant = $this->acompte->montant;
        $this->statut = $this->acompte->statut;
        $this->date = $this->acompte->date;
    }

    function update(){
        $this->validate();
        $this->acompte->update($this->all());
    }

    function delete($id){
        $this->acompte = $this->select($id);
        $this->acompte->delete();
    }
}
