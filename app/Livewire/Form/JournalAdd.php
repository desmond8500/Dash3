<?php

namespace App\Livewire\Form;

use App\Livewire\Forms\JournalForm;
use App\Models\Client;
use App\Models\Journal;
use App\Models\Projet;
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

    function mount($client_id=null, $projet_id = null, $devis_id=null){
        $this->client_id = $client_id;
        $this->projet_id = $projet_id;
        $this->devis_id = $devis_id;
        if (auth()) {
            $this->user_id = auth()->user()->id;
        }
    }

    public function render()
    {
        return view('livewire.form.journal-add',[
            'Journal_count' => Journal::count(),
            'clients' => Client::all(),
            'projets' => Projet::where('id', $this->projet_id)->get()
        ]);
    }

    public JournalForm $journalForm;

    function store(){
        $this->journalForm->client_id= $this->client_id;
        $this->journalForm->projet_id= $this->projet_id;
        $this->journalForm->devis_id= $this->devis_id;
        $this->journalForm->store();
        $this->dispatch('close-addJournal');
        $this->dispatch('get-news');
    }

}
