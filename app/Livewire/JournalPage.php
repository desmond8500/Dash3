<?php

namespace App\Livewire;

use App\Models\Journal;
use Livewire\Component;

class JournalPage extends Component
{
    public $journal;
    public $breadcrumbs;

    function mount($journal_id){
        $this->journal = Journal::find($journal_id);

        $this->breadcrumbs = array(
            array('name' => 'Journal', 'route' => route('journal',['journal_id'=>$this->journal->id])),
        );
    }

    public function render()
    {
        return view('livewire.journal-page');
    }
}
