<?php

namespace App\Livewire;

use App\Livewire\Forms\JournalForm;
use App\Models\Journal;
use Livewire\Attributes\On;
use Livewire\Component;

class JournalPage extends Component
{
    public $journal;
    public $breadcrumbs;

    function mount($journal_id){
        $this->journal = Journal::find($journal_id);

        $this->breadcrumbs = array(
            array('name' => 'Journaux', 'route' => route('journaux')),
            array('name' => 'Journal', 'route' => route('journal',['journal_id'=>$this->journal->id])),
        );
    }

    #[On('close-editJournal')]
    public function render()
    {
        return view('livewire.journal-page');
    }

    public JournalForm $journalForm ;
    function edit_journal($journal_id){
        $this->journalForm->set($journal_id);
        $this->dispatch('open-editJournal');
    }

    function update_journal(){
        $this->journalForm->update();
        $this->dispatch('close-editJournal');
    }

    function delete_journal(){

    }


}
