<div class="row g-2">
    <div class="col-md-12">
        <div class="card-title">Liens et document</div>
    </div>
    <div class="col-md-12">
        @component('components.modal', ["id"=>'addModal', 'title' => 'Titre'])
            <form class="row" wire:submit="store">
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                    <button type="submit" class="btn btn-primary">Valider</button>
                </div>
            </form>
            <script> window.addEventListener('open-addModal', event => { $('#addModal').modal('show'); }) </script>
            <script> window.addEventListener('close-addModal', event => { $('#addModal').modal('hide'); }) </script>
        @endcomponent
    </div>
    <div class="col-md-8">
        @foreach ($documents as $document)
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
                </div>
            </div>
        @endforeach
    </div>
    <div class="col-md-4">
        <div class="card card-body">
            <div class="card-title">Ajouter un document</div>
            @if ($button == "Valider")
                <form class="row" wire:submit='store()'>
            @else
                <form class="row" wire:submit='update()'>
            @endif
                <div class="col-md-12 mb-3">
                    <label class="form-label">Nom</label>
                    <input type="text" class="form-control" wire:model="document_form.name" placeholder="Nom">
                    @error('document_form.name') <span class='text-danger'>{{ $message }}</span> @enderror
                </div>
                <div class="col-md-12 mb-3">
                    <label class="form-label">Lien</label>
                    <input type="text" class="form-control" wire:model="document_form.link" placeholder="Lien">
                    @error('document_form.link') <span class='text-danger'>{{ $message }}</span> @enderror
                </div>
                <div class="col-md-12 mb-3">
                    <label class="form-label">Folder</label>
                    <input type="file" class="form-control" wire:model="document_form.folder">
                    @error('document_form.folder') <span class='text-danger'>{{ $message }}</span> @enderror
                </div>
                <div class="col-md-12 mb-3">
                    <label class="form-label">Description</label>
                    <textarea class="form-control" wire:model="document_form.description" placeholder="Description" cols="30" rows="5"></textarea>
                    @error('document_form.description') <span class='text-danger'>{{ $message }}</span> @enderror
                </div>

                <div class="d-flex-between">
                    <button class="btn btn-secondary">Effacer</button>
                    <button class="btn btn-primary" type="submit">{{ $button }}</button>
                </div>

            </form>

        </div>
    </div>
</div>
