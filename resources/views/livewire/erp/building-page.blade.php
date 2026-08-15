
<div>
    @component('components.layouts.page-header', ['title'=>'Gestion de batiment', 'breadcrumbs'=>$breadcrumbs])
        <div class="btn-list">
            @if ($selected_tab==1)
                {{-- @livewire('form.stage-add', ['building_id' => $building->id], key($building->id)) --}}
                @livewire('_forms.stage_add', ['building_id' => $building->id], key($building->id))
            @elseif ($selected_tab==2)
                @livewire('form.quantitatif-add', ['building_id' => $building->id], key($building->id))
            @elseif($selected_tab==3)
                @livewire('form.fiche-add', ['building_id' => $building->id])
            @endif
                @livewire('form.task-add', ['building_id' => $building->id])
            <a href="{{ route('avancements',['building_id'=>$building->id]) }}" class="btn btn-primary" >Avancements</a>
            <button class="btn btn-icon" wire:click='$refresh'><i class="ti ti-reload"></i> </button>
        </div>
    @endcomponent

    <div class="row g-2">
        <div class="col-md-3">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">Niveaux</div>
                    <div class="card-actions">
                        @livewire('_forms.stage_add', ['building_id' => $building->id], key($building->id))
                    </div>
                </div>
                <div class="card-body">
                    @foreach ($stages->sortBy('order') as $stage)
                    <div class="mb-2">
                        @include('_card.stage_card')
                    </div>
                    @endforeach
                </div>
                <div class="card-footer">

                </div>
            </div>
        </div>
        <div class="col-md-6">
            @if ($selected_room)
            <div class="card">
                <div class="card-header">
                    <div class="card-title">{{ $selected_room->name }}</div>
                    <div class="card-actions">
                        <button class='btn btn-primary' wire:click="dispatch('open-addRoom')"><i class='ti ti-plus'></i> Local</button>
                    </div>
                </div>
                <div class="card-body">

                </div>
                <div class="card-footer">

                </div>
            </div>
            @endif
        </div>
        <div class="col-md-3">
            @if ($selected_stage)
            <div class="card">
                <div class="card-header">
                    <div class="card-title">Appareils</div>
                    <div class="card-actions">
                        <button class='btn btn-primary' wire:click="dispatch('open-addRoom')"><i class='ti ti-plus'></i> Local</button>

                    </div>
                </div>
                <div class="card-body">



                </div>
                <div class="card-footer">

                </div>
            </div>
            @endif
        </div>
    </div>

    <hr>

    <div class="row g-2">
        {{-- <div class="col-md-12">
            <div class="btn-list">
                @foreach ($tabs as $tab)
                    <button class="btn {{ $tab->number == $selected_tab ? 'btn-primary' : '' }}" wire:click="$set('selected_tab','{{ $tab->number }}')">{{ $tab->name }}</button>
                @endforeach
            </div>
        </div> --}}

        {{-- <div class="row  g-2 mb-3">
            <div class="col-md-6">
                <div class="border rounded p-3 mb-3">
                    @livewire('building.diagram_extended', ['building_id' => $building->id], key($building->id))
                </div>
            </div>
            <div class="col-md-6">
                <div class="border rounded p-3 mb-3">
                    @livewire('building.item_list_extended', [], key($building->id))
                </div>
            </div>
        </div> --}}

        {{--
        @if ($selected_tab == 0)
            <div>Résumé</div>
            @livewire('erp.building-resumes',['building_id'=> $building->id ])
        @elseif($selected_tab == 1)
            @livewire('erp.stagelist', ['building_id' => $building->id])
        @elseif($selected_tab == 2)
            @livewire('erp.building-quantitatif',['building_id'=> $building->id ])
        @elseif($selected_tab == 3)
            @livewire('erp.building-fiche',['building_id'=> $building->id ])
        @elseif($selected_tab == 4)
            @livewire('erp.building-document',['building_id'=> $building->id ])
        @endif --}}

    </div>

    @component('components.modal', ["id"=>'editBuilding', 'title' => 'Editer un batiment', 'method'=>'update_building'])
        <form class="row" wire:submit="update_building">
            @include('_form.building_form')
        </form>
        <script> window.addEventListener('open-editBuilding', event => { window.$('#editBuilding').modal('show'); }) </script>
        <script> window.addEventListener('close-editBuilding', event => { window.$('#editBuilding').modal('hide'); }) </script>
    @endcomponent

    @component('components.modal', ["id"=>'editStage', 'title' => 'Editer un niveau', 'method'=>'update_stage'])
        <form class="row" wire:submit="update_stage">
            @include('_form.stage_form')
        </form>
        <script> window.addEventListener('open-editStage', event => { window.$('#editStage').modal('show'); }) </script>
        <script> window.addEventListener('close-editStage', event => { window.$('#editStage').modal('hide'); }) </script>
    @endcomponent

    @component('components.modal', ["id"=>'addRoom', 'title' => 'Ajouter un local'])
        @slot('actions')
            @if ($room_tab)
                <button class="btn btn-primary" wire:click="select('tab')">Générer</button>
            @else
                <button class="btn btn-primary" wire:click="select('tab')">Nouveau</button>
            @endif
        @endslot
        @if ($room_tab)

        @else
            <form class="row" wire:submit="store">
                @include('_form.room_form')
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                    <button type="submit" class="btn btn-primary">Valider</button>
                </div>
            </form>
            <script>
                window.addEventListener('open-addRoom', event => { window.$('#addRoom').modal('show'); })
            </script>
            <script>
                window.addEventListener('close-addRoom', event => { window.$('#addRoom').modal('hide'); })
            </script>
        @endif
    @endcomponent
</div>
