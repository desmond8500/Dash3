<?php

namespace App\Livewire\Form;

use App\Livewire\Forms\StageForm;
use App\Models\Stage;
use Livewire\Attributes\On;
use Livewire\Component;

class StageAdd extends Component
{
    public StageForm $form;
    public $count;

    function mount($building_id) {
        $this->form->building_id = $building_id;
        $stages = Stage::where('building_id', $building_id)->get();
        $this->form->order = $stages->count() + 1;
    }

    public function render() {
        return view('livewire.form.stage-add');
    }


    function store() {
        $this->form->store();
        $this->form->order++;
        $this->dispatch('close-addStage');
        $this->dispatch('get-stage');
    }
}
