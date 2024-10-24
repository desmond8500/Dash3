<?php

namespace App\Livewire;

use App\Livewire\Forms\BadgeForm;
use App\Models\Badge;
use Livewire\Attributes\On;
use Livewire\Component;

class Badges extends Component
{
    public $projet_id;
    public BadgeForm $badge_form;
    public $search;

    function mount($projet_id)
    {
        $this->projet_id = $projet_id;
    }
    #[On('close-addbadge')]
    public function render()
    {
        return view('livewire.badges',[
            'badges' => Badge::where('projet_id', $this->projet_id)
            ->where('prenom', 'LIKE', "%{$this->search}%")
            ->Where('nom', 'LIKE', "%{$this->search}%")
            ->get(),
        ]);
    }

    public function resetSearch()
    {
        $this->reset('search') ;
        $this->getArticles();
    }

    function edit($id){
        $this->badge_form->set($id);
        $this->dispatch('open-editBadge');
    }
    function update(){
        $this->badge_form->update();
        $this->dispatch('close-editBadge');
    }
    function delete($id){
        $this->badge_form->delete($id);
        $this->dispatch('close-editBadge');
    }
}
