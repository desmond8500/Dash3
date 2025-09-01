<div>
    @component('components.layouts.page-header', ['title'=> 'Dashboard'])
        <div class="btn-list">
            @if (!$init)
                <button class="btn btn-primary" wire:click="initServer()">
                    Initialiser le serveur
                </button>
            @endif

            @auth
                <div style="font-size: clamp(1rem, 2vw, 3rem);">
                    {{ ucfirst($carbon->dayName) }} {{ $carbon->format('d')}} {{ $carbon->monthName }} {{ $carbon->format('Y') }}
                </div>
            @endauth
        </div>
    @endcomponent

    @auth
        <div class="row g-2">
            @foreach ($resumes as $resume)
                <a class="col-sm-6 col-md-3 col-xl-2 " href="{{ $resume->route }}" >
                    <div class="card p-2">
                        <div class="row g-1 align-items-center ">
                            <div class="col-auto">
                                <span class="bg-blue text-white avatar">
                                    <i class="ti ti-{{ $resume->icon }}"></i>
                                </span>
                            </div>
                            <div class="col ">
                                <h4 class="font-weight-medium"> {{ $resume->name }} </h4>
                            </div>
                            <div class="col-auto">
                                <div class="text-primary" style="font-size: 20px" >
                                    {{ $resume->all }}
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            @endforeach

            @if ($clients->count())
                <div class="col-md-12">
                    <div class="text-white mb-1 border p-1 bg-blue-lt border">Clients Favoris</div>

                    <div class="row row-deck g-2">
                        @foreach ($clients as $client)
                        <div class="col-md-3">
                            <a class="card p-2"  href="{{ route('projets',['client_id'=>$client->id]) }}" style="height: 73px; overflow: hidden;">
                                <div class="row g-2">
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
                </div>
            @endif

            @if ($projets->count())
                <div class="col-md-12">
                    <div class="text-white mb-1 border p-1 bg-blue-lt border">Projets Favoris</div>

                    <div class="row row-deck g-2">
                        @foreach ($projets as $projet)
                            <div class="col-md-3">
                                <a class="card p-2"  href="{{ route('projet',['projet_id'=>$projet->id]) }}">
                                    <div class="row g-2">
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
                </div>
            @endif

            @if ($invoices->count())
                <div class="col-md-12">
                    <div class="text-white mb-1 border p-1 bg-blue-lt border">Devis Favoris</div>

                    <div class="row row-deck g-2">
                        @foreach ($invoices as $invoice)
                            <div class="col-md-4">
                                <a class="card p-2"  href="{{ route('invoice',['invoice_id'=>$invoice->id]) }}">
                                    <div class="row g-2">
                                        <div class="col-auto">
                                            <img src="{{ asset($invoice->projet->client->avatar) }}" alt="A" class="avatar">
                                        </div>
                                        <div class="col">
                                            <div class="fw-bold text-primary">{{ $invoice->projet->client->name }}</div>
                                            <div class="fw-bold">{{ $invoice->projet->name }}</div>
                                            <div class="">{{ $invoice->reference }}</div>
                                            <div class="text-muted">{{ $invoice->description }}</div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <div class="col-md-12">
                @env('local')
                    @livewire('erp.planning')
                @endenv
            </div>

        </div>

    @else
        <div class="row align-items-center">
            <div class="col-md">
                <div class="btn-list mb-2">
                    <a class="btn btn-primary" wire:click="dispatch('open-login')">Connexion</a>
                    <a class="btn btn-secondary" wire:click="dispatch('open-register')">Inscription</a>
                </div>
            </div>
            <div class="col-md-auto">
                <div style="font-size: clamp(1rem, 2vw, 3rem);">
                    {{ ucfirst($carbon->dayName) }} {{ $carbon->format('d')}} {{ $carbon->monthName }} {{ $carbon->format('Y') }}
                </div>
            </div>
        </div>

    @endauth

    <div class="mt-2 border border-primary rounded p-2 bg-white">
        <div class="fw-bold mb-2 ">
            Dev tools !!!
        </div>
        <div class="btn-list">
            <a class="btn btn-cyan" href="/log-viewer" target="_blank">Logs Viewer page</a>
            <button class="btn btn-danger" wire:click='init'>Initialiser</button>
            @env('local')
                <a class="btn btn-purple" href="/migrator" target="_blank">Migrator page</a>
                <button class="btn btn-secondary" wire:click='send'>Send mail</button>
            @endenv
        </div>
    </div>

    <div>
        @component('components.modal', ["id"=>'register', 'title'=>'Inscription', 'method'=>'register'])
        <form class="row" wire:submit="register">
            @include('_form.register_form')
        </form>

        <script>
            window.addEventListener('open-register', event => { window.$('#register').modal('show'); })
        </script>
        <script>
            window.addEventListener('close-register', event => { window.$('#register').modal('hide'); })
        </script>
        @endcomponent

        @component('components.modal', ["id"=>'login', 'title'=>'Connexion', 'class'=>'modal-sm'])

        @include('_form.login_form')

        <script>
            window.addEventListener('open-login', event => { window.$('#login').modal('show'); })
        </script>
        <script>
            window.addEventListener('close-login', event => { window.$('#login').modal('hide'); })
        </script>
        @endcomponent
    </div>


</div>
