<div>
    @component('components.layouts.page-header', ['title'=> 'Dashboard'])
        @if (!$init)
            <button class="btn btn-primary" wire:click="initServer()">
                Initialiser le serveur
            </button>
        @endif

    @endcomponent

    <div class="row g-2">
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

    @auth
        <div class="btn-list mt-3">
            @livewire('form.journal-add')
        </div>

    @endauth




</div>
