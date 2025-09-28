<?php

use Livewire\Volt\Component;
use App\Livewire\Forms\BuildingForm;
use App\Models\Building;

new class extends Component {
    public  $projet_id;
    public BuildingForm $building_form;


    function mount($projet_id ){
        $this->building_form->projet_id = $projet_id;
        $buildings = Building::where('projet_id', $projet_id)->get();
        $this->building_form->order = $buildings->count()+1;

    }

    function store(){
        $this->building_form->store();

        $this->dispatch('get_buildings');
        $this->dispatch('close-addBuilding');
    }
}; ?>

<div>
    <button class='btn btn-primary btn-pill' wire:click="dispatch('open-addBuilding')">
        <i class='ti ti-plus'></i> Building
    </button>

    @component('components.modal', ["id"=>'addBuilding', 'title' => 'Ajouter un batiment', "method"=>"store"])
        <form class="row" wire:submit="store">
            @include('_form.building_form')
        </form>

        <script> window.addEventListener('open-addBuilding', event => { window.$('#addBuilding').modal('show'); }) </script>
        <script> window.addEventListener('close-addBuilding', event => { window.$('#addBuilding').modal('hide'); }) </script>
    @endcomponent
</div>
