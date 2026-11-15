<?php

namespace App\Livewire;

use App\Livewire\Forms\JournalForm;
use App\Models\Achat;
use App\Models\Contact;
use App\Models\Invoice;
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
        $this->journal = Journal::findOrFail($journal_id);
        $projet = $this->journal->projet;

        // Fil d'Ariane complet : Journaux › Client › Projet › titre du journal
        $this->breadcrumbs = array_values(array_filter([
            array('name' => 'Journaux', 'route' => route('journaux')),
            $projet?->client ? array('name' => $projet->client->name, 'route' => route('projets', ['client_id' => $projet->client->id])) : null,
            $projet ? array('name' => $projet->name, 'route' => route('projet', ['projet_id' => $projet->id])) : null,
            array('name' => $this->journal->title, 'route' => route('journal', ['journal_id' => $this->journal->id])),
        ]));
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
            'devis' => $this->journal->invoices()->with('sections.rows')->get(),
            'devis_disponibles' => Invoice::where('projet_id', $this->journal->projet_id)
                ->whereNotIn('id', $this->journal->invoices()->pluck('invoices.id'))
                ->orderByDesc('id')
                ->get(['id', 'reference', 'description']),
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

    /** Rattache un devis du projet au journal */
    function add_devis($invoice_id){
        $invoice = Invoice::where('projet_id', $this->journal->projet_id)->find($invoice_id);
        if (! $invoice) {
            return;
        }
        $this->journal->invoices()->syncWithoutDetaching([$invoice->id]);
        // Le premier devis rattaché devient le devis principal
        if (! $this->journal->devis_id) {
            $this->journal->update(['devis_id' => $invoice->id]);
        }
    }

    function delete_devis($invoice_id){
        $this->journal->invoices()->detach($invoice_id);
        if ($this->journal->devis_id == $invoice_id) {
            $this->journal->update(['devis_id' => $this->journal->invoices()->value('invoices.id')]);
        }
    }


}
