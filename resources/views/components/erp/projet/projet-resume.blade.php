<div class="row g-2">
    <div class="col-md-12">
        <div class="card p-2">
            <div class="row">
                <div class="col-auto">
                    <img class="avatar avatar-md" src="{{ asset($projet->client->avatar) }}" alt="A">
                </div>
                <div class="col">
                    <h4>{{ $projet->name }}</h4>
                    <p>{{ nl2br($projet->description) }}</p>
                </div>
                <div class="col-auto">
                    <button class="btn btn-primary btn-icon">
                        <i class="ti ti-edit"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-8">
        <div class="card p-2">
            <div class="row">
                <div class="col">
                    <h2>Devis</h2>
                    <ul>
                        <li>Nouveaux devis</li>
                        <li>Devis en cours</li>
                    </ul>
                </div>
                <div class="col-auto">
                    <button class="btn btn-primary btn-icon">
                        <i class="ti ti-edit"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card p-2">
            <div class="row">
                <div class="col">
                    <h2>Taches {{ $projet->id }}</h2>
                    <ul>
                        <li>Nouvelles taches {{ $projet->tasks->count() }}</li>
                        <li>Taches en cours</li>
                    </ul>
                </div>
                <div class="col-auto">
                    @livewire('form.task-add', ['projet_id' => $projet->id])
                </div>
            </div>

        </div>

    </div>
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <div class="card-title"><h2>Building management</h2></div>
                <div class="card-actions">
                    @livewire('form.building-add', ['projet_id' => $projet->id])
                </div>
            </div>
            <div class="card-body">
                <div class="row g-2">
                    @foreach ($buildings as $building)
                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title"><a href="{{ route('building', ['building_id'=> $building->id]) }}">{{ $building->name }}</a> </h3>
                                    <div class="card-actions">
                                        {{-- @livewire('form.stage-add', ['building_id' => $building->id, key($building->id)]) --}}
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="text-muted">
                                        {{ nl2br($building->description) }}
                                    </div>
                                    <div>
                                        @foreach ($building->stages as $stage)
                                            <a href="{{ route('stage', ['stage_id'=>$stage->id]) }}" class="d-flex justify-content-between">
                                                <div>{{ $stage->name  }}</div> <div> {{ $stage->rooms->count() }}</div>
                                            </a>
                                        @endforeach
                                    </div>

                                </div>


                            </div>
                        </div>
                    @endforeach
                </div>

            </div>
        </div>
    </div>
</div>
