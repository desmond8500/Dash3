<?php

use Livewire\Volt\Component;
use App\Models\Building;
use App\Livewire\Forms\BuildingForm;

new class extends Component {
    public int $projet_id;

    public function with(): array {
        return [
            'buildings' => $this->get_buildings(),
        ];
    }

    #[On('get-buildings')]
    function get_buildings(){
        return Building::where('projet_id', $this->projet_id)->get();
    }

    public BuildingForm $building_form;

    function edit($id) {
        $this->building_form->set($id);
        $this->dispatch('open-editBuilding');
    }

    function update() {
        $this->building_form->update();
        $this->dispatch('close-editBuilding');
    }
    function delete($id) {
        $this->building_form->set($id);
        $message = $this->building_form->delete();

        if ($message == "Success") {
            $this->js("alert($message)");
        }
    }
}; ?>

<div class="card">
    <div class="card-header">
        <div class="card-title">Batiments</div>
        <div class="card-actions">
            @livewire('form.building-add', ['projet_id' => $projet_id], key(2))
        </div>
    </div>
    <div class="table-responsive">
        <table class="table table-hover">
            {{-- <thead class="sticky-top">
                <tr>
                    <td>Batiment</td>
                    <td width="100px" class="text-center">Actions</td>
                </tr>
            </thead> --}}
            <tbody>
                @foreach ($buildings as $key => $building)
                    <tr>
                        <td>
                            <a href="{{ route('building',['building_id'=> $building->id]) }}">{{ $building->name }}</a>
                            <div class="text-muted">{!! nl2br($building->description) !!}</div>
                        </td>
                        <td width="80px">
                            <div class="col-auto text-end">
                                @if (!$building->stages()->count() > 0)
                                <button class="btn btn-outline-danger btn-icon btn-sm" wire:click="delete('{{ $building->id }}')">
                                    <i class="ti ti-trash"></i>
                                </button>
                                @endif
                                <button class="btn btn-outline-primary btn-icon btn-sm" wire:click="edit('{{ $building->id }}')">
                                    <i class="ti ti-edit"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    @component('components.modal', ["id"=>'editBuilding', 'title' => 'Editer le batiment', 'method'=>'update'])
    <form class="row" wire:submit="update">
        @include('_form.building_form')

    </form>
    <script> window.addEventListener('open-editBuilding', event => { window.$('#editBuilding').modal('show'); }) </script>
    <script> window.addEventListener('close-editBuilding', event => { window.$('#editBuilding').modal('hide'); }) </script>
    @endcomponent
</div>

