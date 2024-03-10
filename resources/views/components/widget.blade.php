<div class="card p-2">
    <div class="row">
        @isset($img)
            <div class="col-auto">
                <img src="" alt="A" class="avatar avatar-md">
            </div>
        @endisset
        <div class="col">
            <div class="card-title">{{  $title ?? '' }}</div>
            <div class="text-muted">{{ $description ?? '' }}</div>
            {{ $slot }}
            @isset($bang)
                <div class="text-danger">
                    {{ $bang }}
                </div>
            @endisset
        </div>
        @isset($edit)
            <div class="col-auto">
                <button class="btn btn-outline-primary btn-icon" wire:click="{{ $edit }}()">
                    <i class="ti ti-edit"></i>
                </button>
            </div>
        @endisset
    </div>
</div>
