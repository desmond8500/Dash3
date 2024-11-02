<div class="row g-2">
    <div class="col-md-4">
        <div class="card p-2 mb-2">
            <div class="row">
                <div class="col-auto">
                    <img class="avatar avatar" src="{{ asset($projet->client->avatar) }}" alt="A">
                </div>
                <div class="col">
                    <h4>{{ $projet->name }}</h4>
                </div>
                <div class="col-auto">
                    <div class="dropdown open">
                        <button class="btn btn-action border dropdown-toggle" type="button" id="triggerId"
                            data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="ti ti-dots-vertical"></i>
                        </button>
                        <div class="dropdown-menu" aria-labelledby="triggerId">
                            <button class="dropdown-item" wire:click="edit('{{ $projet->id }}')">Editer</button>
                        </div>
                    </div>
                    <div class="dropdown-menu" aria-labelledby="triggerId">
                        <button class="dropdown-item" wire:click="edit('{{ $projet->id }}')">Editer</button>
                    </div>
                </div>
                <div class="col-md-12">
                    <p class="mt-2">{{ nl2br($projet->description) }}</p>
                </div>
            </div>
        </div>

        <div class="card p-2 mb-2">
            <div class="row">
                <div class="col">
                    <h2>Devis</h2>
                    <ul>
                        <li>Nouveaux devis</li>
                        <li>Devis en cours</li>
                    </ul>
                </div>

            </div>
        </div>

        <div class="card p-2 mb-2">
            <div class="row">
                <div class="col">
                    <h2>Taches </h2>
                </div>
                <div class="col-auto">
                    @livewire('form.task-add', ['projet_id' => $projet->id])
                </div>
                <div class="col-12">
                    @component('components.chartjs',[
                        'labels' => [
                            "Nouvelles (".$projet->tasks->where('statut_id', 1)->count().")",
                            "En cours (".$projet->tasks->where('statut_id', 2)->count().")",
                            "En pause (".$projet->tasks->where('statut_id', 3)->count().")",
                            "Terminés (".$projet->tasks->where('statut_id', 4)->count().")",
                            "Annulés (".$projet->tasks->where('statut_id', 5)->count().")",
                        ],
                        'data' => [
                            $projet->tasks->where('statut_id', 1)->count(),
                            $projet->tasks->where('statut_id', 2)->count(),
                            $projet->tasks->where('statut_id', 3)->count(),
                            $projet->tasks->where('statut_id', 4)->count(),
                            $projet->tasks->where('statut_id', 5)->count(),
                        ],
                    ])
                    @endcomponent
                </div>
            </div>
        </div>

    </div>
    <div class="col-md-8">
        <div class="row">
            <div class="col-md-8">
                @component('components.chartjs',[
                'title' => 'Taches',
                'labels' => [
                "Nouvelles (".$projet->tasks->where('statut_id', 1)->count().")",
                "En cours (".$projet->tasks->where('statut_id', 2)->count().")",
                "En pause (".$projet->tasks->where('statut_id', 3)->count().")",
                "Terminés (".$projet->tasks->where('statut_id', 4)->count().")",
                "Annulés (".$projet->tasks->where('statut_id', 5)->count().")",
                ],
                'data' => [
                $projet->tasks->where('statut_id', 1)->count(),
                $projet->tasks->where('statut_id', 2)->count(),
                $projet->tasks->where('statut_id', 3)->count(),
                $projet->tasks->where('statut_id', 4)->count(),
                $projet->tasks->where('statut_id', 5)->count(),
                ],
                ])
                @endcomponent
            </div>
        </div>
    </div>
</div>
