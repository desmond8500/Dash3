<?php

namespace App\Livewire\Erp;

use App\Livewire\Forms\projetForm;
use App\Models\Invoice;
use App\Models\Projet;
use Livewire\Component;
use Livewire\WithPagination;

class ProjetResume extends Component
{
    use WithPagination;
    public $projet_id;

    function mount($projet_id){
        $this->projet_id = $projet_id;
    }

    public function render()
    {
        return view('livewire.erp.projet-resume',[
            'projet' => Projet::find($this->projet_id),
            'invoices' => Invoice::where('projet_id', $this->projet_id)->paginate(5),
        ]);
    }

    // Projets
    public projetForm $projetForm;

    function edit()
    {
        $this->projetForm->set($this->projet->id);
        $this->dispatch('open-editProjet');
    }

    function update()
    {
        $this->projetForm->update();
        $this->projet = Projet::find($this->projet->id);
        $this->dispatch('close-editProjet');
    }
}
