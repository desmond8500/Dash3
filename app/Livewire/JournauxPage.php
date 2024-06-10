<?php

namespace App\Livewire;

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
            'journaux' => Journal::search($this->search),
        ]);
    }
}
