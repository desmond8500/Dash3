<div class="col-md-12">
    @error('brand_link.brand_id') <span class='text-danger'>{{ $message }}</span> @enderror
</div>

<div class="col-md-12 mb-3">
    <label class="form-label">Nom du document / lien</label>
    <input type="text" class="form-control" wire:model="brand_link.name" placeholder="Lien ou document">
    @error('brand_link.name') <span class='text-danger'>{{ $message }}</span> @enderror
</div>
<div class="col-md-12 mb-3">
    <label class="form-label">Lien</label>
    <input type="text" class="form-control" wire:model="brand_link.link" placeholder="Lien ou document">
    @error('brand_link.link') <span class='text-danger'>{{ $message }}</span> @enderror
</div>

<div class="col-md-12 mb-3">
    <label class="form-label">Description</label>
    <textarea class="form-control" wire:model="brand_link.description" placeholder="Description" cols="30" rows="5"></textarea>
    @error('brand_link.description') <span class='text-danger'>{{ $message }}</span> @enderror
</div>

<div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
    <button type="submit" class="btn btn-primary">Valider</button>
</div>
