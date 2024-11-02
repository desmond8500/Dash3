<div class="col-auto">
    <div wire:loading>
        Chargement <div class="spinner-border" role="status"></div>
    </div>
        <label href="#" class="avatar avatar-upload rounded" for="file">
            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"> <path stroke="none" d="M0 0h24v24H0z" fill="none" /> <line x1="12" y1="5" x2="12" y2="19" /> <line x1="5" y1="12" x2="19" y2="12" /> </svg>
        <span class="avatar-upload-text">Ajouter</span>
        <input type="file" style="display: none" id="file"  wire:model.defer="document_form.file">
    </label>
</div>

<div class="col-md-4 mb-3">
    <label class="form-label">Nom du document</label>
    <input type="text" class="form-control" wire:model="document_form.name" placeholder="Nom du document">
    @error('name') <span class='text-danger'>{{ $message }}</span> @enderror
</div>



<div class="col-md-4 mb-3">
    <label class="form-label">Type de document</label>
    <select class="form-control" wire:model="document_form.type">
        <option selected>Bon de commande</option>
        <option >Devis</option>
        <option >Décharge</option>
        <option >Bordereau de travaux</option>
        <option >Bordereau de livraison</option>
        <option >Autre</option>
    </select>
    @error('type') <span class='text-danger'>{{ $message }}</span> @enderror
</div>
