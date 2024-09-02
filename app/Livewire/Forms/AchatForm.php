<?php

namespace App\Livewire\Forms;

use App\Models\Achat;
use App\Models\Transaction;
use Livewire\Attributes\Rule;
use Livewire\Attributes\Validate;
use Livewire\Form;

class AchatForm extends Form
{
    public Achat $achat;

    #[Rule('required')]
    public $name;
    public $description;
    public $date;
    public $provider_id;
    public $status;

    function fix(){
        $this->name = ucfirst($this->name);
        $this->description = ucfirst($this->description);
    }

    function add_transaction($achat_id)
    {
        $achat = Achat::find($achat_id);
        $transaction = Transaction::create([
            'achat_id' => $achat_id,
            'objet' => $achat->name,
            'description' => $achat->description,
            'montant' => $achat->ttc(),
            'date' => $achat->date,
            'type' => 'debit'
        ]);
        $achat->transaction_id = $transaction->id;
        $achat->save();
    }


    function store(){
        $this->validate();
        Achat::create($this->all());
        $this->reset('name','date','provider_id', 'description', 'status');
    }

    function set($model_id){
        $this->achat = Achat::find($model_id);
        $this->provider_id = $this->achat->provider_id;
        $this->name = $this->achat->name;
        $this->description = $this->achat->description;
        $this->date = $this->achat->date;
        $this->status = $this->achat->status;
    }

    function update(){
        $this->validate();
        $this->achat->update($this->all());
    }

    function delete(){
        $this->achat->delete();
    }
}
