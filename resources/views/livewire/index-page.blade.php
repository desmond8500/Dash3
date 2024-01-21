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
            </div>
        @endauth

    @endcomponent

    @auth
        <div class="row g-2">
            <div class="col-md-8">
                <div class="row">
                    @foreach ($resumes as $resume)
                        <a class="col-md-3" href="{{ $resume->route }}">
                            <div class="card card-sm">
                                <div class="card-body">
                                    <div class="row align-items-center">
                                        <div class="col-auto">
                                            <span class="bg-green text-white avatar">
                                                <i class="ti ti-user"></i>
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
                            </div>
                        </a>
                    @endforeach
                </div>

            </div>
            <div class="col-auto">
                @livewire('erp.tasklist')

            </div>

        </div>

    @else

        <div class="btn-list">
            <a class="btn btn-primary" wire:click="dispatch('open-login')">Connexion</a>
            <a class="btn btn-light" wire:click="dispatch('open-register')">Inscription</a>
        </div>

    @endauth

</div>
