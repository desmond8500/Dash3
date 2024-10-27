<div class="card p-2 mb-1 ">
    <div class="row align-items-center">
        <div class="col-auto">
            <img src="" alt="A" class="avatar avatar-md">
        </div>
        <div class="col">
            @if ($document->link)
            <a href="{{ asset($document->link) }}" target="_blank">
                @endif
                <div class="card-title">{{ $document->name }}</div>
                <div class="text-muted">{!! $document->description !!}</div>
                @if ($document->link)
            </a>
            @endif
        </div>
        @isset($edit)
            <div class="col-auto">
                <button class="btn btn-outline-primary btn-icon" wire:click="edit({{ $document->id }})">
                    <i class="ti ti-edit"></i>
                </button>
                @if ($document->folder)
                <a class="btn btn-outline-primary btn-icon" href="{{ asset($document->folder) }}" target="_blank">
                    <i class="ti ti-download"></i>
                </a>
                @endif
                <button class="btn btn-outline-danger btn-icon" wire:click="delete({{ $document->id }})">
                    <i class="ti ti-trash"></i>
                </button>
            </div>
        @endisset
    </div>
</div>
