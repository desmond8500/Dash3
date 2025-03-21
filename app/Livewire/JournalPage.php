<?php

namespace App\Livewire;

use App\Livewire\Forms\JournalForm;
use App\Models\Achat;
use App\Models\Contact;
use App\Models\Journal;
use App\Models\JournalIntervenant;
use App\Models\Task;
use App\Models\Team;
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
        return view('livewire.journal-page',[
            'contacts' => Contact::where('projet_id', $this->journal->projet->id)
                                ->orWhere('client_id', $this->journal->projet->client->id)
                                ->get(),
            'team' => Team::get(),
            'intervenants' => JournalIntervenant::where('journal_id', $this->journal->id)->get(),
            'tasks' => Task::where('journal_id', $this->journal->id)->get(),
            'achats' => Achat::where('journal_id', $this->journal->id)->get(),
            'projets' => $this->journal->projet->client->projets,
        ]);
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

    function add_contact($contact_id){
        JournalIntervenant::create([
            'journal_id' => $this->journal->id,
            'contact_id' => $contact_id,
        ]);
    }
    function add_team($team_id){
        JournalIntervenant::create([
            'journal_id' => $this->journal->id,
            'team_id' => $team_id,
        ]);
    }

    function delete_intervenant($id){
        $intervenant = JournalIntervenant::find($id);
        $intervenant->delete();
    }


}
