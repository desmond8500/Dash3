<?php

namespace App\Livewire\Erp;

use App\Livewire\Forms\SystemeForm;
use App\Models\Systeme;
use App\Models\TaskStatus;
use App\View\Components\Status;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class SystemesPage extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';
    public $search ='';
    public $breadcrumbs;

    public function mount(){
        $this->breadcrumbs = array(
            array('name' => 'Systemes', 'route' => route('systemes')),
        );
    }

    // function getSearch() {
    // return Projet::where('client_id', $this->client_id)->where('name', 'like', '%' . $this->search . '%')->paginate(10);
    // }

    #[On('close-addSysteme')]
    public function render()
    {
        return view('livewire.erp.systemes-page',[
            'systemes' => Systeme::all(),
            'statuts' => TaskStatus::all(),
        ]);
    }

    public SystemeForm $systeme_form;

    function store(){
        $this->systeme_form->store();
    }

    function edit($id){
        $this->systeme_form->set($id);
        $this->dispatch('open-editSysteme');
    }

    function update(){
        $this->systeme_form->update();
        $this->dispatch('close-editSysteme');
    }

    function delete($id){
        $this->systeme_form->delete($id);
    }
}
