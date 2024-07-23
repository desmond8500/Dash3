<?php

namespace App\Livewire\Forms;

use App\Models\Transaction;
use Livewire\Attributes\Rule;
use Livewire\Attributes\Validate;
use Livewire\Form;

class TransactionForm extends Form
{
    public Transaction $transaction;

    public $achat_id;
    public $projet_id;
    public $invoice_id;
    public $invoice_acompte_id;
    public $invoice_spent_id;
    #[Rule('required')]
    public $objet;
    #[Rule('required')]
    public $type = "credit";
    #[Rule('required')]
    public $montant;
    public $description;
    #[Rule('required')]
    public $date;

    function fix(){
        $this->objet = ucfirst($this->objet);
        $this->description = ucfirst($this->description);
    }


    function store(){
        // $this->validate();
        Transaction::create($this->all());
    }

    function set($model_id){
        $this->transaction = Transaction::find($model_id);
        $this->objet = $this->transaction->objet;
        $this->type = $this->transaction->type;
        $this->montant = $this->transaction->montant;
        $this->description = $this->transaction->description;
        $this->date = $this->transaction->date;
        $this->achat_id = $this->transaction->achat_id;
        $this->projet_id = $this->transaction->projet_id;
        $this->invoice_acompte_id = $this->transaction->invoice_acompte_id;
        $this->invoice_spent_id = $this->transaction->invoice_spent_id;
    }

    function update(){
        $this->validate();
        $this->transaction->update($this->all());
    }

    function delete($transaction_id){
        $transaction = Transaction::find($transaction_id);
        $transaction->delete();
    }
}
