<div>
    <div class="col-md-12 mb-3">
        <label class="form-label">Nom du document</label>
        <input type="text" class="form-control" wire:model="form.document_name" placeholder="Nom du document">
        @error('form.document_name') <span class='text-danger'>{{ $message }}</span> @enderror
    </div>
    <div class="col-md-12 mb-3">
        <label class="form-label">Fichier</label>
        <input type="file" class="form-control" wire:model="form.document_path" >
        @error('form.document_path') <span class='text-danger'>{{ $message }}</span> @enderror
    </div>
</div>
