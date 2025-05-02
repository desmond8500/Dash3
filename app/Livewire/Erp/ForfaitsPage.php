<?php

namespace App\Livewire\Erp;

use App\Livewire\Forms\ForfaitForm;
use App\Models\Forfait;
use Livewire\Component;
use Livewire\WithPagination;

class ForfaitsPage extends Component
{
    use WithPagination;
    public ForfaitForm $forfait_form;
    public $breadcrumbs;

    function mount(){
        $this->breadcrumbs = array(
            array('name' => 'Forfaits', 'route' => route('forfaits'),
            )
        );
    }

    public function render()
    {
        return view('livewire.erp.forfaits-page',[
            'forfaits' => Forfait::paginate(12)
        ]);
    }

    function store(){
        $this->forfait_form->store();
        $this->dispatch('close-addForfait');
    }

    function edit($id){
        $this->forfait_form->set($id);
        $this->dispatch('open-editForfait');
    }

    function update(){
        $this->forfait_form->update();
        $this->dispatch('close-editForfait');
    }

    function delete($id){
        $this->forfait_form->delete($id);
    }
}
