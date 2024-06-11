<?php

namespace App\Livewire\Erp;

use App\Livewire\Forms\JournalForm;
use App\Models\Journal;
use Livewire\Attributes\Validate;
use Livewire\Component;

class Journaux extends Component
{
    public $projet_id;

    function mount($projet_id){
        $this->projet_id = $projet_id;
    }

    public function render()
    {
        return view('livewire.erp.journaux',[
            'journaux' => $this->getJournaux(),
        ]);
    }

    function getJournaux(){
        return Journal::where('projet_id', $this->projet_id)->paginate(20);
    }

    public JournalForm $journalForm;

    function edit_journal($journal_id){
        $this->journalForm->set($journal_id);
        $this->dispatch('open-editJournal');
    }

    function update_journal() {
        $this->journalForm->update();
        $this->dispatch('close-editJournal');
    }

    function delete_journal() {
        $this->journalForm->delete();
        $this->dispatch('close-editJournal');
    }
}
