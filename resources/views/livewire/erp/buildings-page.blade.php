<div>
    @component('components.layouts.page-header', ['title'=>'Gestion de projet', 'breadcrumbs'=>$breadcrumbs])
    @endcomponent

    <div class="btn-list">
        @foreach ($buildings as $building)
            <button class="btn btn-primary" wire:click="selectBuilding('{{ $building->id }}')">{{ $building->name }}</button>
        @endforeach
    </div>
    <div class="row mt-3 g-2">
        <div class="col-md-3">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">Niveaux</div>
                    <div class="card-actions">

                    </div>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">

                        @foreach ($buildings[0]->stages as $stage)
                            <button class="btn btn-primary type="button"" >{{ $stage->name }}</button>
                        @endforeach
                    </div>

                </div>

            </div>
        </div>
        <div class="col-md-9">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">Locaux</div>
                    <div class="card-actions">

                    </div>
                </div>
                <div class="card-body">
                    @foreach ($buildings[0]->stages[0]->rooms as $room)
                        <button class="btn btn-primary" >{{ $room->name }}</button>
                    @endforeach

                </div>

            </div>
        </div>
    </div>

</div>
