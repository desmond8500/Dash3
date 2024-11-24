
<div>
    @component('components.layouts.page-header', ['title'=>'Gestion de batiment', 'breadcrumbs'=>$breadcrumbs])
        <div class="btn-list">
            @if ($selected_tab==1)
                @livewire('form.stage-add', ['building_id' => $building->id], key($building->id))
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
        <div class="col-md-12">
            <div class="btn-list">
                @foreach ($tabs as $tab)
                    <button class="btn {{ $tab->number == $selected_tab ? 'btn-primary' : '' }}" wire:click="$set('selected_tab','{{ $tab->number }}')">{{ $tab->name }}</button>
                @endforeach
            </div>
        </div>

        {{-- <hr> --}}

        @if ($selected_tab == 0)
            <div>Résumé</div>
            @livewire('erp.building-resumes',['building_id'=> $building->id ])


            {{-- <div class="row">
                <div class="col-md-12">
                    <div class="row">
                        <div class="col">
                            <h2>Résumé</h2>
                        </div>
                        <div class="col-auto">
                            <button class="btn btn-icon" wire:click='$refresh'><i class="ti ti-reload"></i> </button>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card mb-2">
                        <div class="card-header">
                            <div class="card-title">{{ $building->name }}</div>
                            <div class="card-actions">
                                <button class="btn btn-primary btn-icon" wire:click="editBuilding"><i class="ti ti-edit"></i></button>
                            </div>
                        </div>
                        <div class="card-body">
                            {{ nl2br($building->description) }}
                        </div>
                    </div>

                </div>
                <div class="col-md-8">

                </div>
            </div> --}}

        @elseif($selected_tab == 1)
            @livewire('erp.stagelist', ['building_id' => $building->id])
        @elseif($selected_tab == 2)
            {{-- <div>Quantitatif</div> --}}
            @livewire('erp.building-quantitatif',['building_id'=> $building->id ])
        @elseif($selected_tab == 3)
            {{-- <div>Fiches</div> --}}
            @livewire('erp.building-fiche',['building_id'=> $building->id ])
        @elseif($selected_tab == 4)
            {{-- <div>Documents</div> --}}
            @livewire('erp.building-document',['building_id'=> $building->id ])
        @endif

    </div>




    @component('components.modal', ["id"=>'editBuilding', 'title' => 'Editer un batiment'])
        <form class="row" wire:submit="update_building">
            @include('_form.building_form')
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                <button type="submit" class="btn btn-primary">Valider</button>
            </div>
        </form>
        <script> window.addEventListener('open-editBuilding', event => { $('#editBuilding').modal('show'); }) </script>
        <script> window.addEventListener('close-editBuilding', event => { $('#editBuilding').modal('hide'); }) </script>
    @endcomponent

    @component('components.modal', ["id"=>'editStage', 'title' => 'Editer un niveau'])
        <form class="row" wire:submit="update_stage">
            @include('_form.stage_form')
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                <button type="submit" class="btn btn-primary">Valider</button>
            </div>
        </form>
        <script> window.addEventListener('open-editStage', event => { $('#editStage').modal('show'); }) </script>
        <script> window.addEventListener('close-editStage', event => { $('#editStage').modal('hide'); }) </script>
    @endcomponent
</div>
