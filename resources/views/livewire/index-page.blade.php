<div>
    @component('components.layouts.page-header', ['title'=> 'Dashboard'])
        @if (!$init)
            <button class="btn btn-primary" wire:click="initServer()">
                Initialiser le serveur
            </button>
        @endif

        @auth
            <div class="btn-list mt-3">
                @livewire('form.journal-add')
                @livewire('form.task-add')
            </div>
        @endauth

        @env('local')
            @component('components.off-canvas',['button'=>'Todos'])

            @endcomponent
        @endenv


    @endcomponent

    @auth
        <div class="row g-2">
            <div class="col-md-8">
                <div class="row">
                    @foreach ($resumes as $resume)
                        <a class="col-md-3 mb-1" href="{{ $resume->route }}">
                            <div class="card p-2">
                                <div class="row align-items-center">
                                    <div class="col-auto">
                                        <span class="bg-green text-white avatar">
                                            <i class="ti ti-{{ $resume->icon }}"></i>
                                        </span>
                                    </div>
                                    <div class="col">
                                        <h4 class="font-weight-medium"> {{ $resume->name }} </h4>
                                        <div class="text-secondary">
                                            {{ $resume->all }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>

                <div class="hr-text hr-text-left">Clients Favoris</div>

                <div class="row g-2">
                    @foreach ($clients as $client)
                        <div class="col-md-3">
                            <a class="card p-2" href="{{ route('projets',['client_id'=>$client->id]) }}">
                                <div class="row">
                                    <div class="col-auto">
                                        <img src="{{ asset($client->avatar) }}" alt="A" class="avatar">
                                    </div>
                                    <div class="col">
                                        <div class="fw-bold text-primary">{{ $client->name }}</div>
                                        <div class="text-muted">{{ $client->description }}</div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
                <div class="hr-text hr-text-left">Projets Favoris</div>

                <div class="row g-2">
                    @foreach ($projets as $projet)
                        <div class="col-md-3">
                            <a class="card p-2" href="{{ route('projet',['projet_id'=>$projet->id]) }}">
                                <div class="row">
                                    <div class="col-auto">
                                        <img src="{{ asset($projet->client->avatar) }}" alt="A" class="avatar">
                                    </div>
                                    <div class="col">
                                        <div class="fw-bold text-primary">{{ $projet->client->name }}</div>
                                        <div class="fw-bold">{{ $projet->name }}</div>
                                        <div class="text-muted">{{ $projet->description }}</div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
                <div class="hr-text hr-text-left">Devis Favoris</div>

                <div class="row g-2">
                    @foreach ($invoices as $invoice)
                        <div class="col-md-4">
                            <a class="card p-2" href="{{ route('invoice',['invoice_id'=>$invoice->id]) }}">
                                <div class="row">
                                    <div class="col-auto">
                                        <img src="{{ asset($invoice->projet->client->avatar) }}" alt="A" class="avatar">
                                    </div>
                                    <div class="col">
                                        <div class="fw-bold text-primary">{{ $invoice->projet->client->name }}</div>
                                        <div class="fw-bold">{{ $projet->name }}</div>
                                        <div class="">{{ $invoice->reference }}</div>
                                        <div class="text-muted">{{ $invoice->description }}</div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>

                @env('local')
                    <div class="mt-2">
                        @livewire('erp.planning')
                    </div>
                @endenv


            </div>
            <div class="col-md-4">
                @livewire('erp.tasklist')

            </div>

        </div>

    @else
        <div class="btn-list">
            <a class="btn btn-primary" wire:click="dispatch('open-login')">Connexion</a>
            <a class="btn btn-secondary" wire:click="dispatch('open-register')">Inscription</a>
        </div>
    @endauth

    @env('local')
        <ul>
            <li><a href="/log-viewer" target="_blank">Logs Viewer page</a></li>
            <li><a href="/migrator" target="_blank">Migrator page</a></li>
        </ul>
    @endenv




</div>
