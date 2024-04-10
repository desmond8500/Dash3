<div class="modal modal-blur fade" id="{{ $id ?? 'exampleModal' }}" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
        <div class="modal-content">
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            <div class="modal-status bg-{{ $type ?? 'success' }}"></div>
            <div class="modal-body text-center py-4">

                @if ($type=='primary')
                    <i class="ti ti-alert-circle text-primary" style="font-size: 50px"></i>
                @elseif ($type=='danger')
                    <i class="ti ti-alert-triangle text-danger" style="font-size: 50px"></i>
                @else
                    <i class="ti ti-circle-check text-success" style="font-size: 50px"></i>

                @endif

                <h3>{{ $title ?? 'Modal title' }}</h3>
                <div class="text-secondary">
                    {{ $slot }}
                </div>
            </div>
            <div class="modal-footer">
                <div class="w-100">
                    <div class="row">
                        <div class="col">
                            <a href="#" class="btn w-100" data-bs-dismiss="modal">
                                Fermer
                            </a>
                        </div>
                        <div class="col">
                            <a href="#" class="btn btn-{{ $type ?? 'success' }} w-100" wire:click="{{ $action }}">
                                {{ $button ?? 'Valider' }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
