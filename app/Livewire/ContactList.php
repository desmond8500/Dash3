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

    public $projet_id;
    public $client_id;
    public $card_class;
    public $search;

    function mount($projet_id = 0, $client_id = 0){
        $this->projet_id = $projet_id;
        $this->client_id = $client_id;
    }

    #[On('get-contacts')]
    public function render()
    {
        return view('livewire.contact-list',[
            'contacts' => $this->getContacts()
        ]);
    }

    function getContacts(){
        if ($this->projet_id) {
            return Contact::where('projet_id', $this->projet_id)
            ->search($this->search,'firstname')
            ->search($this->search, 'lastname')
            ->paginate(18);
        }
        if ($this->client_id) {
            return Contact::where('client_id', $this->client_id)
            ->search($this->search,'firstname')
            ->search($this->search, 'lastname')
            ->paginate(18);
        }
    }

    public ContactForm $contact_form;

    function edit($id){
        $this->contact_form->set($id);
        $this->dispatch('open-editContact');
    }

    function update(){
        $this->contact_form->update();
        $this->dispatch('close-editContact');
    }

    function delete($id){
        $this->contact_form->delete($id);
    }
}
