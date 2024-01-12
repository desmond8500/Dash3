<?php

namespace App\Livewire\Form;

use App\Models\Journal;
use Livewire\Attributes\Validate;
use Livewire\Component;

class JournalAdd extends Component
{
    #[Validate('required')]
    public $user_id;
    public $client_id;
    public $projet_id;
    public $devis_id;

    #[Validate('required')]
    public $title;
    public $description;

    #[Validate('required')]
    public $date;

    function mount($projet_id = null, $devis_id=null){
        if (auth()) {
            $this->user_id = auth()->user()->id;
        }
    }

    public function render()
    {
        return view('livewire.form.journal-add',[
            'Journal_count' => Journal::count(),
        ]);
    }

    function store(){
        $this->validate();
        Journal::create([
            'user_id' =>  $this->user_id,
            'client_id' => $this->client_id,
            'projet_id' => $this->projet_id,
            'devis_id' => $this->devis_id,
            'title' => $this->title,
            'description' => $this->description,
            'date' => $this->date,
        ]);
        $this->dispatch('close-addJournal');
    }

}
