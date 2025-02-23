<div class="col-md-7 mb-3">
    <label class="form-label">Nom du système</label>
    <input type="text" class="form-control" wire:model="systeme_form.name" placeholder="Nom du système">
    @error('systeme_form.name') <span class='text-danger'>{{ $message }}</span> @enderror
</div>

<div class="col-md-12 mb-3">
    <label class="form-label">Description</label>
    <textarea class="form-control" wire:model="systeme_form.description" placeholder="Description" data-bs-toggle="autosize"></textarea>
    @error('systeme_form.description') <span class='text-danger'>{{ $message }}</span> @enderror
</div>
