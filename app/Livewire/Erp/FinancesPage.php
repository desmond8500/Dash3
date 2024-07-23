<?php

namespace App\Livewire\Erp;

use App\Livewire\Forms\TransactionForm;
use App\Models\Transaction;
use Carbon\Carbon;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class FinancesPage extends Component
{
    use WithPagination;
    use WithFileUploads;

    protected $paginationTheme = 'bootstrap';
    public $search ='';
    public $breadcrumbs;

    public function mount(){
        $this->breadcrumbs = array(
            array('name' => 'Finances', 'route' => route('finances')),
        );
    }

    #[On('get-transactions')]
    public function render()
    {
        return view('livewire.erp.finances-page',[
            'transactions' => Transaction::all(),
            'total' => Transaction::where('type','credit')->sum('montant') - Transaction::where('type', 'debit')->sum('montant')
        ]);
    }

    function total(){
        $total = 0;
        foreach (Transaction::all() as $key => $ret) {
            if ($ret->credit == 'credit') {
                $total = $total + $ret->montant;
            }else{
                $total = $total - $ret->montant;
            }
        }
        return $total;
    }

    public TransactionForm $transaction_form;

    function edit($transaction_id){
        $this->transaction_form->set($transaction_id);
        $this->dispatch('open-editTransaction');
    }

    function update(){
        $this->transaction_form->update();
        $this->dispatch('close-editTransaction');
    }

    function delete($transaction_id){
        $this->transaction_form->delete($transaction_id);
    }
}
