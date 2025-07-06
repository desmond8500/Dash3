<?php

namespace App\Livewire\Erp;

use App\Livewire\Forms\ForfaitForm;
use App\Models\Client;
use App\Models\Forfait;
use App\Models\Test;
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
            'forfaits' => Forfait::paginate(12),
            'clients' => Client::all(),
            'test' => Test::all(),
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

    function save(){
        Test::create(request()->all());
    }

    public $name;
    public $name1;
    function save2(){

        Test::create([
            'name' => $this->name,
        ]);

        $this->reset(['name']);
    }

    function deletef($test_id){
        $test = Test::find($test_id);
        if($test){
            $test->delete();
        }
    }
}
