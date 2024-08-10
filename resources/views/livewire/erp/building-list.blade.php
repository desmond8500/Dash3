<div class="">

    <div class="p-2">
        <div class="row row-deck g-2">
            <div class="col"><h2>Building management</h2></div>
            <div class="col-auto">
                @livewire('form.building-add', ['projet_id' => $projet_id])
            </div>
            <div class="w-100"></div>
            @foreach ($buildings as $building)
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title"><a href="{{ route('building', ['building_id'=> $building->id]) }}">{{
                                $building->name }}</a> </h3>
                        <div class="card-actions">
                            <button class="btn btn-primary btn-icon" wire:click="edit_building('{{ $building->id }}')">
                                <i class="ti ti-edit"></i>
                            </button>
                        </div>
                    </div>
                    <div class="p-2">
                        <span class="text-muted"> {{ nl2br($building->description) }} </span>

                    </div>
                    <div class="p-2">
                        <li class="d-flex justify-content-between  btn btn-primary p-2 rounded mb-1">
                            <span class="fw-bold">Niveaux: </span> <span class="badge bg-white text-primary">{{
                                $building->stages->count() }}</span>
                        </li>
                        <li class="d-flex justify-content-between  btn btn-primary p-2 rounded mb-1">
                            <span class="fw-bold">Taches: </span> <span class="badge bg-white text-primary">{{
                                $building->tasks->count() }}</span>
                        </li>
                    </div>

                </div>
            </div>
            @endforeach
        </div>

    </div>
    @component('components.modal', ["id"=>'editBuilding', 'title' => 'Editer le batiment'])
        <form class="row" wire:submit="store_building">
            @include('_form.building_form')

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                <button type="submit" class="btn btn-primary">Valider</button>
            </div>
        </form>
        <script> window.addEventListener('open-editBuilding', event => { $('#editBuilding').modal('show'); }) </script>
        <script> window.addEventListener('close-editBuilding', event => { $('#editBuilding').modal('hide'); }) </script>
    @endcomponent
</div>
