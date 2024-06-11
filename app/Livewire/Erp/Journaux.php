<?php

namespace App\Livewire\Erp;

use App\Models\Journal;
use Livewire\Attributes\Validate;
use Livewire\Component;

class Journaux extends Component
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

    public function render()
    {
        return view('livewire.erp.journaux',[
            'journaux' => Journal::paginate(20),
        ]);
    }

    public $selected_id;

    function edit_journal($journal_id){
        $journal = Journal::find($journal_id);
        $this->selected_id = $journal->id;
        $this->dispatch('open-editJournal');

        $this->title = $journal->title;
        $this->description = $journal->description;
        $this->date = $journal->date;
    }

    function update_journal() {
        $journal = Journal::find($this->selected_id);

        $journal->title = $this->title;
        $journal->description = $this->description;
        $journal->date = $this->date;

        $journal->save();
        $this->dispatch('close-editJournal');
    }
}
