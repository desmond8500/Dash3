<?php

namespace App\Livewire\Modules;

use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class ContactsPage extends Component
{
    use WithPagination;
    use WithFileUploads;
    protected $paginationTheme = 'bootstrap';

    public function updatingSearch() {
        $this->resetPage();
    }

    public $search ='';
    public $breadcrumbs ='';
    public function mount()
    {
        $this->breadcrumbs = array(
            array('name' => 'Contacts', 'route' => route('contacts')),
        );
    }
    public function render()
    {
        return view('livewire.modules.contacts-page');
    }
}
