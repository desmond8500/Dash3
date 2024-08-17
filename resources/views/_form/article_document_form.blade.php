<div class="col-md-8 mb-3">
    <label class="form-label">Nom</label>
    <input type="text" class="form-control" wire:model="article_document_form.name" placeholder="Nom">
    @error('article_document_form.name') <span class='text-danger'>{{ $message }}</span> @enderror
</div>
<div class="col-md-4 mb-3">
    <label class="form-label">Fichier</label>
    <input type="file" class="form-control" wire:model="article_document_form.folder" >
    @error('article_document_form.folder') <span class='text-danger'>{{ $message }}</span> @enderror
</div>
