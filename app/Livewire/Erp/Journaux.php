<?php

namespace App\Livewire\Erp;

use App\Livewire\Forms\JournalForm;
use App\Models\Client;
use App\Models\Journal;
use App\Models\Projet;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithPagination;

use function Laravel\Prompts\search;

class Journaux extends Component
{
    use WithPagination;

    public $projet_id;
    public $projet;
    public $search;
    public $class;
    public $paginate;

    function mount($projet_id, $class = null, $paginate = null){
        $this->projet_id = $projet_id;
        $this->projet = Projet::find($projet_id);
        $this->class = $class;
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
        if ($this->paginate) {
            return Journal::where('projet_id', $this->projet_id)
                ->orderByDesc('date')
                ->where('title', 'LIKE', "%{$this->search}%")
                ->paginate($this->paginate);
        } else {
            return Journal::where('projet_id', $this->projet_id)
                ->orderByDesc('date')
                ->where('title', 'LIKE', "%{$this->search}%")
                ->get();
        }

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
