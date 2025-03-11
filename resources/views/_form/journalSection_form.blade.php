<div class="col-md-10 mb-3">
    <label class="form-label">Titre de la section</label>
    <input type="text" class="form-control" wire:model="name" placeholder="Titre de la section">
    @error('name') <span class='text-danger'>{{ $message }}</span> @enderror
</div>
<div class="col-md-2 mb-3">
    <label class="form-label">Ordre</label>
    <input type="number" class="form-control" wire:model="order" placeholder="Ordre">
    @error('order') <span class='text-danger'>{{ $message }}</span> @enderror
</div>

<div class="col-md-12 mb-3">
    <label class="form-label">Description</label>
    <textarea class="form-control" wire:model="description" placeholder="Description" data-bs-toggle="autosize"></textarea>
    @error('description') <span class='text-danger'>{{ $message }}</span> @enderror
</div>
