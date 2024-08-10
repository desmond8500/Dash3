
<div>
    @component('components.layouts.page-header', ['title'=>'Gestion de batiment', 'breadcrumbs'=>$breadcrumbs])
        <div class="btn-list">
            @livewire('form.stage-add', ['building_id' => $building->id], key($building->id))
            <a href="{{ route('avancements',['building_id'=>$building->id]) }}" class="btn btn-primary" >Avancements</a>
            <button class="btn btn-icon" wire:click='$refresh'><i class="ti ti-reload"></i> </button>
        </div>
    @endcomponent

    <div class="row g-2">
        <div class="col-md-3">
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

            @foreach ($stages->sortBy('order') as $stage)
                <div class="mb-2">
                    @include('_card.stage_card')
                </div>
            @endforeach

            <div class="card">
                <div class="card-header">
                    <div class="card-title">Quantitatif</div>
                    <div class="card-actions">
                        <button class="btn btn-primary" >
                            <i class="ti ti-plus">Quantitatif</i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <ul>
                        <li>Article</li>
                        <li>lien</li>
                        <li>quantite</li>
                    </ul>

                </div>
                <div class="card-footer">

                </div>
            </div>
        </div>

        <div class="col-md-9">
            @if ($selected_stage)
                <div class="card mb-2">
                    <div class="card-header">
                        <h3 class="card-title"> {{ $selected_stage->name }} </h3>
                        <div class="card-actions">
                            <div class="btn-list">
                                <button class="btn btn-primary btn-icon" wire:click="edit_stage('{{ $selected_stage->id }}')">
                                    <i class="ti ti-edit"></i>
                                </button>
                                <button class="btn btn-danger btn-icon" wire:click="delete_stage('{{ $selected_stage->id }}')">
                                    <i class="ti ti-trash"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row g-2">

                    @foreach ($selected_stage->rooms as $room)
                        <div class="col-md-4">
                            <div class="card p-2">
                                <div class="row">
                                    <div class="col">
                                        <div class="card-title">
                                            <a href="{{ route('room', ['room_id' => $room->id]) }}">{{ $room->name }}</a>
                                        </div>
                                        <div class="text-muted">{{ nl2br($room->description) }}</div>
                                    </div>
                                    <div class="col-auto">
                                        <button class="btn btn-outline-primary btn-icon">
                                            <i class="ti ti-edit"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif

            <div class="row">
                <div class="col-md-6">
                    @livewire('erp.building-quantitatif')
                </div>
                <div class="col-md-6">
                    @livewire('erp.building-fiche')

                </div>
            </div>
        </div>
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
