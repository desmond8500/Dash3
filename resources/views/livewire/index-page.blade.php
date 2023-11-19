<div>
    @component('components.layouts.page-header', ['title'=> 'Dashboard'])
        @if (!$init)
            <button class="btn btn-primary" wire:click="initServer()">Initialiser le serveur</button>
        @endif

    @endcomponent


</div>
