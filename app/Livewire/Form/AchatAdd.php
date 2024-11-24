<?php

namespace App\Livewire\Form;

use App\Livewire\Forms\AchatForm;
use App\Models\Achat;
use App\Models\Provider;
use Livewire\Attributes\Validate;
use Livewire\Component;

class AchatAdd extends Component
{
    public $journal_id;

    function mount($journal_id=null){
        $this->journal_id = $journal_id;
        if ($this->journal_id) {
            $this->achat_form->journal_id = $journal_id;
        }
    }

    public function render() {
        return view('livewire.form.achat-add',[
            'providers' => Provider::all(),
        ]);
    }
    public AchatForm $achat_form;

    function store(){
        $this->achat_form->store();

        $this->dispatch('close-addAchat');
    }

}

