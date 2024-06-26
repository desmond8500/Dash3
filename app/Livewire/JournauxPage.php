<?php

namespace App\Livewire;

use App\Livewire\Forms\JournalForm;
use App\Models\Journal;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\WithFileUploads;
use Livewire\WithPagination;

class JournauxPage extends Component
{
    use WithFileUploads;
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $search;
    public $breadcrumbs;


    public function render()
    {
        $this->breadcrumbs = array(
            array('name' => 'Journaux', 'route' => route('journaux')),
        );
        return view('livewire.journaux-page',[
            'journaux' => Journal::search($this->search)->paginate(20),
        ]);
    }

    public JournalForm $journalForm;

    function edit_journal($journal_id)
    {
        $this->journalForm->set($journal_id);
        $this->dispatch('open-editJournal');
    }

    function update_journal()
    {
        $this->journalForm->update();
        $this->dispatch('close-editJournal');
    }

    function delete_journal()
    {
        $this->journalForm->delete();
        $this->dispatch('close-editJournal');
    }
}
