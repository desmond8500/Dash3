<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <div class="card-title">Liens et document</div>
                <div class="card-actions">

                </div>
            </div>
            <div class="card-body">

            </div>
            <div class="card-footer">

            </div>
        </div>

    </div>
    <div class="col-md-4">
        <div class="card card-body">
            <form class="row">
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

            </form>

        </div>
    </div>
</div>
