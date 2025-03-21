<div class="modal modal-dialog-scrollable fade" id="{{ $id ?? 'exampleModal' }}" tabindex="-1" aria-labelledby="{{ $id ?? 'exampleModal' }}Label" aria-hidden="true" wire:ignore.self>
    <style>
        /* Chrome, Safari, Edge, Opera */
        input::-webkit-outer-spin-button,
        input::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
        }

        /* Firefox */
        input[type=number] {
        -moz-appearance: textfield;
        }
    </style>

    <div class="{{ $class ?? 'modal-dialog' }} modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="{{ $id ?? 'exampleModal' }}Label">{{ $title ?? 'Modal title' }}</h5>
                <div class="card-actions">
                    {{ $actions ?? '' }}
                </div>
                {{-- @isset($refresh)
                    <button class="btn btn-icon" wire:click='$refresh'><i class="ti ti-reload"></i> </button>
                @endisset --}}
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                {{ $slot }}

            </div>
            @isset ($method)
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                    <button type="button" class="btn btn-primary" wire:click="{{ $method }}">{{ $submit ?? 'Valider' }}</button>
                </div>
            @endisset
        </div>
    </div>
</div>

