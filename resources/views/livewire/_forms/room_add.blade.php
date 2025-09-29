<?php

use Livewire\Volt\Component;
use App\Livewire\Forms\RoomForm;
use App\Models\Room;

new class extends Component {
    public RoomForm $room_form;
    public $count;
    public $tab = false;

    function mount($stage_id)
    {
        $this->room_form->stage_id = $stage_id;
        $stages = Room::where('stage_id', $stage_id)->get();
        $this->room_form->order = $stages->count() + 1;
    }

    function select(){
        $this->tab = ($this->tab) ? false : true ;
    }

    function store(){
        $this->room_form->store();
        $this->dispatch('close-addRoom');
        $this->dispatch('get-rooms');
    }

    // Local
    function local_form(){
        $this->dispatch('open-addRoom');
    }
}; ?>

<div>
    <button class='btn btn-primary' wire:click="local_form()"><i class='ti ti-plus'></i> Local</button>

    @component('components.modal', ["id"=>'addRoom', 'title' => 'Ajouter un local'])
        @slot('actions')
            @if ($tab)
                <button class="btn btn-primary" wire:click="select('tab')">Générer</button>
            @else
                <button class="btn btn-primary" wire:click="select('tab')">Nouveau</button>
            @endif
        @endslot
        @if ($tab)

        @else
            <form class="row" wire:submit="store">
                @include('_form.room_form')
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                    <button type="submit" class="btn btn-primary">Valider</button>
                </div>
            </form>
            <script> window.addEventListener('open-addRoom', event => { window.$('#addRoom').modal('show'); }) </script>
            <script> window.addEventListener('close-addRoom', event => { window.$('#addRoom').modal('hide'); }) </script>
        @endif
    @endcomponent
</div>
