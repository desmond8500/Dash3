<div class="modal fade" id="{{ $id ?? 'exampleModal' }}" tabindex="-1" aria-labelledby="{{ $id ?? 'exampleModal' }}Label" aria-hidden="true" wire:ignore.self>
    <div class="{{ $class ?? 'modal-dialog' }} modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="{{ $id ?? 'exampleModal' }}Label">
                    @include('breadcrumbs.task_breadcrumb')
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                <button class="btn btn-icon" wire:click='$refresh'><i class="ti ti-reload"></i> </button>

                {{ $actions ?? '' }}
            </div>
            <div class="modal-body">

                {{ $slot }}

            </div>
            @isset ($method)
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                <button type="button" class="btn btn-primary" wire:click="{{ $method }}">{{ $submit ?? 'Valider'
                    }}</button>
            </div>
            @endisset
        </div>
    </div>
</div>
