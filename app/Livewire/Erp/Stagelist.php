<?php

namespace App\Livewire\Erp;

use App\Livewire\Forms\StageForm;
use App\Models\Stage;
use Livewire\Attributes\On;
use Livewire\Component;

class Stagelist extends Component
{
    public $building_id;
    public $selected_stage;
    public StageForm $stage_form;

    function mount($building_id){
        $this->building_id = $building_id;
    }

    public function render()
    {
        return view('livewire.erp.stagelist',[
            'stages' => Stage::where('building_id', $this->building_id)->get(),
        ]);
    }

    // Stages
    #[On('get-stages')]
    function get_stages()
    {
        return Stage::where('building_id', $this->building_id)->get();
    }

    function set_stage($stage_id)
    {
        $this->selected_stage = Stage::find($stage_id);
    }

    function edit_stage($stage_id)
    {
        $this->stage_form->set($stage_id);
        $this->dispatch('open-editStage');
    }
    function update_stage()
    {
        $this->stage_form->update();
        $this->dispatch('close-editStage');
    }
    function delete_stage($id)
    {
        $stage = Stage::find($id);
        $stage->delete();
        $this->reset('selected_stage');
        $this->dispatch('get-stages');
    }
}
