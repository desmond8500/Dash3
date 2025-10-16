<div class="dropdown open">
    <button class="btn " type="button" id="triggerId" data-bs-toggle="dropdown" aria-haspopup="true"
        aria-expanded="false">
        <i class="ti ti-chevron-down"></i>{{ $statut ? $statut : 'Trier' }}
    </button>
    <div class="dropdown-menu" aria-labelledby="triggerId">
        <a class="dropdown-item text-primary" wire:click="$set('statut', '')"> <i class="ti ti-circle"></i>
            Reset
        </a>
        @foreach ($statuses as $status)
        <a class="dropdown-item" wire:click="$set('statut', '{{ $status }}')"> <i class="ti ti-circle"></i>
            {{ $status }}
        </a>
        @endforeach
    </div>
</div>
