<div class="card p-2">
    <div class="row">
        <div class="col">
            <div class="card-title">{{ $note->titre }}</div>
            <div class="text-muted">
                @parsedown($note->description)
            </div>
        </div>
        <div class="col-auto">
            <div class="dropdown">
                <button class="btn btn-action dropdown-toggle" type="button" id="triggerId" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" >
                    <i class="ti ti-dots-vertical"></i>
                </button>
                <div class="dropdown-menu" aria-labelledby="triggerId">
                    <a class="dropdown-item" wire:click="edit({{ $note->id }})">Editer</a>
                    <a class="dropdown-item text-danger" wire:click="delete({{ $note->id }})">Supprimer</a>
                </div>
            </div>
      </div>
    </div>
</div>
