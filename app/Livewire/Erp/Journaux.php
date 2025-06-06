<?php

namespace App\Livewire\Erp;

use App\Livewire\Forms\JournalForm;
use App\Models\Client;
use App\Models\Journal;
use App\Models\Projet;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;
use Livewire\Component;

use function Laravel\Prompts\search;

class Journaux extends Component
{
    public $projet_id;
    public $projet;
    public $search;

    function mount($projet_id){
        $this->projet_id = $projet_id;
        $this->projet = Projet::find($projet_id);

    }

    #[On('get-news')]
    public function render()
    {
        return view('livewire.erp.journaux',[
            'journaux' => $this->getJournaux(),
            'projets' => $this->projet->client->projets,
        ]);
    }

    function getJournaux(){
        return Journal::where('projet_id', $this->projet_id)
            ->orderByDesc('date')
            ->where('title', 'LIKE', "%{$this->search}%")
            ->get();
            // ->paginate(20);
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

    function delete_journal($journal_id) {
        $this->journalForm->set($journal_id);
        $this->journalForm->delete();
        $this->dispatch('close-editJournal');
    }
}
