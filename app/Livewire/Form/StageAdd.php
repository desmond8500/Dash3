<?php

namespace App\Livewire\Form;

use App\Livewire\Forms\StageForm;
use App\Models\Stage;
use Livewire\Attributes\On;
use Livewire\Component;

class StageAdd extends Component
{
    public StageForm $stage_form;
    public $count;
    public $tab = 0;

    function mount($building_id) {
        $this->stage_form->building_id = $building_id;
        $stages = Stage::where('building_id', $building_id)->get();
        $this->stage_form->order = $stages->count() + 1;
        $this->count = $stages->count() + 1;
    }

    public function render() {
        return view('livewire.form.stage-add');
    }

    function store() {
        $this->stage_form->store();
        $this->stage_form->order++;
        $this->dispatch('close-addStage');
        $this->dispatch('get-stages');
    }

    public $sous_sol = 0;
    public $rdc = true;
    public $mezz = false;
    public $roof = false;
    public $level = 0;

    function add_stage($name, $n=null){
        if ($n>1) {
            for ($i=1; $i <= $n; $i++) {
                Stage::create([
                    'building_id' => $this->stage_form->building_id,
                    'name' => ucfirst($name).$i,
                    'order' => ++$this->count,
                ]);
            }
        } else {
            Stage::create([
                'building_id' => $this->stage_form->building_id,
                'name' => ucfirst($name),
                'order' => ++$this->count,
            ]);
        }

        $this->dispatch('get-stages');
    }

    function generate_stage(){
        if ($this->sous_sol) {
            $this->add_stage('Sous-sol ', $this->sous_sol);
        }
        if ($this->rdc) {
            $this->add_stage('RDC');
        }
        if ($this->mezz) {
            $this->add_stage('Mezzanine');
        }
        if ($this->level) {
            $this->add_stage('Etage ', $this->level);
        }
        if ($this->roof) {
            $this->add_stage('Terrasse');
        }

    }

    #[On('generate-stage')]
    function toggle(){
        if ($this->tab) {
            $this->tab=0;
        } else {
            $this->tab=1;
        }
    }
}
