<?php

namespace App\Livewire\Form;

use App\Livewire\Forms\TransactionForm;
use Livewire\Component;

class TransactionAdd extends Component
{
    public $achat_id;
    public $projet_id;
    public $invoice_id;

    public TransactionForm $transaction_form;

    function mount($achat_id = 0, $projet_id = 0, $invoice_id = 0){
        if ($achat_id) {
            $this->transaction_form->achat_id = $achat_id;
        }elseif($projet_id){
            $this->transaction_form->projet_id = $projet_id;
        }elseif ($invoice_id) {
            $this->transaction_form->invoice_id = $invoice_id;
        }
    }

    public function render()
    {
        return view('livewire.form.transaction-add');
    }

    function store(){
        $this->transaction_form->store();
        $this->dispatch('close-addTransaction');
        $this->dispatch('get-transactions');
    }
}
