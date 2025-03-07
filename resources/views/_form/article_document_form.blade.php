<div class="col-md-8 mb-3">
    <label class="form-label">Nom</label>
    <div class="input-group">
        <input type="text" class="form-control" wire:model="article_document_form.name" placeholder="Nom">
        <div class="dropdown open">
            <button class="btn btn-primary btn-icon" type="button" id="triggerId" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" >
                <i class="ti ti-chevron-down"></i>
            </button>
            <div class="dropdown-menu" aria-labelledby="triggerId">
                <a class="dropdown-item" wire:click="$set('article_document_form.name','Fiche Technique')">Fiche Technique</a>
                <a class="dropdown-item" wire:click="$set('article_document_form.name','Fiche Commerciale')">Fiche Commerciale</a>
                <a class="dropdown-item" wire:click="$set('article_document_form.name','Schéma de cablage')">Schéma de cablage</a>
                <a class="dropdown-item" wire:click="$set('article_document_form.name','Manuel d\'utilisation')">Manuel d'utilisation</a>
                <a class="dropdown-item" wire:click="$set('article_document_form.name','Manuel d\'installation')">Manuel d'installation</a>
            </div>
            <a class="btn btn-primary btn-icon btn-secondary" wire:click="$set('article_document_form.name','')"
                data-bs-toggle="tooltip" title="Effacer">
                <i class="ti ti-x"></i>
            </a>
        </div>
    </div>
    @error('article_document_form.name') <span class='text-danger'>{{ $message }}</span> @enderror
</div>
<div class="col-md-4 mb-3">
    <label class="form-label">Fichier</label>
    <input type="file" class="form-control" wire:model="article_document_form.folder" >
    @error('article_document_form.folder') <span class='text-danger'>{{ $message }}</span> @enderror
</div>
