<?php

namespace App\Livewire;

use App\Livewire\Forms\ContactForm;
use App\Models\Contact;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\WithFileUploads;
use Livewire\WithPagination;

class ContactList extends Component
{
    use WithPagination;
    use WithFileUploads;

    public ContactForm $contact_form;

    public $projet_id;
    public $search;

    function mount($projet_id = 0){
        $this->projet_id = $projet_id;
    }

    #[On('get-contacts')]
    public function render()
    {
        return view('livewire.contact-list',[
            'contacts' => Contact::where('projet_id', $this->projet_id)->search($this->search)->paginate(18),
        ]);
    }
}
