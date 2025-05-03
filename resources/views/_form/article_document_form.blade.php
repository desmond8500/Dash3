<div class="col-md-8 mb-3">
    <label class="form-label">Nom</label>
    <div class="input-group">
        <input type="text" list="itemDocumentList" class="form-control" wire:model="article_document_form.name" placeholder="Nom">
        <datalist id="itemDocumentList">
            <option>Fiche </option>
            <option>Fiche Technique</option>
            <option>Fiche Commerciale</option>
            <option>Schéma</option>
            <option>Schéma de cablage</option>
            <option>Manuel</option>
            <option>Manuel d'utilisation</option>
            <option>Manuel d'installation</option>
        </datalist>
    </div>
    @error('article_document_form.name') <span class='text-danger'>{{ $message }}</span> @enderror
</div>
<div class="col-md-4 mb-3">
    <label class="form-label">Fichier</label>
    <div wire:loading>
        <div class="d-flex justify-content-between">
            <div>Chargement <span class="animated-dots"></div>
        </div>
    </div>
    <input type="file" class="form-control" wire:model="article_document_form.folder" >
    @error('article_document_form.folder') <span class='text-danger'>{{ $message }}</span> @enderror
</div>
