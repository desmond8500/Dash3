<div class="col-md-12">
    @error('brand_link.brand_id') <span class='text-danger'>{{ $message }}</span> @enderror
</div>

<div class="col-md-12 mb-3">
    <label class="form-label">Nom du document / lien</label>
    <div class="input-group">
        <input type="text" list="brandLinkList" class="form-control" wire:model="brand_link.name" placeholder="Lien ou document">
        <datalist id="brandLinkList">
            <option>Brochure</option>
            <option>Catalogue</option>
            <option>Fiche Commerciale</option>
            <option>Liste de prix</option>
        </datalist>
    </div>
    @error('brand_link.name') <span class='text-danger'>{{ $message }}</span> @enderror
</div>
<div class="col-md-12 mb-3">
    <label class="form-label">Lien</label>
    <input type="text" class="form-control" wire:model="brand_link.link" placeholder="Lien ou document">
    @error('brand_link.link') <span class='text-danger'>{{ $message }}</span> @enderror
</div>

<div class="col-md-12 mb-3">
    <label class="form-label">Description</label>
    <textarea class="form-control" wire:model="brand_link.description" placeholder="Description" data-bs-toggle="autosize"></textarea>
    @error('brand_link.description') <span class='text-danger'>{{ $message }}</span> @enderror
</div>
