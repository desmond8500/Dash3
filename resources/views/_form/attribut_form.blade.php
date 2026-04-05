<div>
    <div class="col-md-6 mb-3">
        <label class="form-label">Nom</label>
        <input type="text" class="form-control" wire:model="attribut_name" placeholder="Nom">
        @error('attribut_name') <span class='text-danger'>{{ $message }}</span> @enderror
    </div>
    <div class="col-md-6 mb-3">
        <label class="form-label">Valeur</label>
        <input type="text" class="form-control" wire:model="attribut_value" placeholder="Valeur">
        @error('attribut_value') <span class='text-danger'>{{ $message }}</span> @enderror
    </div>
</div>
