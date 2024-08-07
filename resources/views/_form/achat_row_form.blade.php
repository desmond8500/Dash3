<div class="col-md-12 mb-3">
    <label class="form-label">Désignation</label>
    <input type="text" class="form-control" wire:model="a_row.designation" placeholder="Nom">
    @error('a_row.designation') <span class='text-danger'>{{ $message }}</span> @enderror
</div>
<div class="col-md-12 mb-3">
    <label class="form-label">Référence</label>
    <input type="text" class="form-control" wire:model="a_row.reference" placeholder="Nom">
    @error('a_row.reference') <span class='text-danger'>{{ $message }}</span> @enderror
</div>

<div class="col-md-4 mb-3">
    <label class="form-label">Quantité</label>
    <input type="text" class="form-control" wire:model='a_row.quantite'>
    @error('a_row.quantite') <span class='text-danger'>{{ $message }}</span> @enderror
</div>
<div class="col-md-4 mb-3">
    <label class="form-label">Prix</label>
    <input type="text" class="form-control" wire:model='a_row.prix'>
    @error('a_row.prix') <span class='text-danger'>{{ $message }}</span> @enderror
</div>
<div class="col-md-4 my-3">
    <label class="form-check form-switch mt-2">
        <input class="form-check-input" type="checkbox" wire:model='a_row.tva'>
        <span class="form-check-label">TVA</span>
    </label>
</div>
