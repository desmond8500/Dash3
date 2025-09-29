<?php

use Livewire\Volt\Component;
use App\Livewire\Forms\StageForm;
use App\Models\Stage;

new class extends Component {
    public StageForm $stage_form;
    public $count;
    public $tab = 0;

    function mount($building_id) {
        $this->stage_form->building_id = $building_id;
        $stages = Stage::where('building_id', $building_id)->get();
        $this->stage_form->order = $stages->count() + 1;
        $this->count = $stages->count() + 1;
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
                    'building_id'=> $this->stage_form->building_id,
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
            $this->dispatch('get-stages');
        }

        function toggle(){
            if ($this->tab) {
                $this->tab=0;
            } else {
                $this->tab=1;
            }
        }
}; ?>

<div>
    <button class='btn btn-primary' wire:click="dispatch('open-addStage')"><i class='ti ti-plus'></i> Niveau</button>

    @component('components.modal', ["id"=>'addStage', 'title' => 'Ajouter un niveau'])
        @slot('actions')
            @if ($tab)
                <button button class="btn btn-primary" wire:click="$set('tab',0)">Nouveau</button>
            @else
                <button class="btn btn-primary" wire:click="$set('tab',1)">Générer</button>
            @endif
        @endslot

        @if ($tab == 0)
            <form class="row" wire:submit="store">

                @include('_form.stage_form')

                <div class="">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                    <button type="submit" class="btn btn-primary">Valider</button>
                </div>

            </form>

        @elseif($tab == 1)
            <form wire:submit="generate_stage">
                <div class="row">
                    <div class="col-md-8">
                        <div class="row mb-3">
                            <label class="col-md-4 form-label">Sous Sol</label>
                            <div class=" col-md-8">
                                <input type="text" class="form-control" wire:model="sous_sol" placeholder="Nombre de niveaux">
                                {{-- <button class="btn btn-primary" wire:click="add_sous_sol">Ajouter</button> --}}
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label class="col-md-4 form-label">Etage</label>
                            <div class=" col-md-8">
                                <input type="text" class="form-control" wire:model="level" placeholder="Nombre de niveaux">
                                {{-- <button class="btn btn-primary" wire:click="add_level">Ajouter</button> --}}
                            </div>
                            @error('level') <span class='text-danger'>{{ $message }}</span> @enderror
                        </div>

                    </div>
                    <div class="col-md-4">
                        <div class="mt-2">
                            <label class="form-check form-check-single form-switch d-flex justify-content-between">
                                <input class="form-check-input" wire:model='rdc' type="checkbox" ch> <span class="ms-2">RDC</span>
                            </label>
                        </div>
                        <div class="mt-2">
                            <label class="form-check form-check-single form-switch d-flex justify-content-between">
                                <input class="form-check-input" wire:model='mezz' type="checkbox"> <span
                                    class="ms-2">Mezzanine</span>
                            </label>
                        </div>
                        <div class="mt-2">
                            <label class="form-check form-check-single form-switch d-flex justify-content-between">
                                <input class="form-check-input" wire:model='roof' type="checkbox"> <span
                                    class="ms-2">Terrasse</span>
                            </label>
                        </div>

                    </div>
                </div>
                <div class="">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                    <button type="submit" class="btn btn-primary">Valider</button>
                </div>

            </form>
        @endif


        <script> window.addEventListener('open-addStage', event => { window.$('#addStage').modal('show'); }) </script>
        <script> window.addEventListener('close-addStage', event => { window.$('#addStage').modal('hide'); }) </script>
    @endcomponent
</div>
