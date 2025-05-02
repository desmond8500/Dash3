<div class="col-md-3 mb-3">
    <label class="form-label">ID batiment</label>
    <input type="text" class="form-control" wire:model="stage_form.building_id" disabled>
    @error('stage_form.building_id') <span class='text-danger'>{{ $message }}</span> @enderror
</div>

<div class="col-md-7 mb-3">
    <label class="form-label">Nom du niveau</label>
    <input type="text" class="form-control" wire:model="stage_form.name" placeholder="Nom du niveau">
    @error('stage_form.name') <span class='text-danger'>{{ $message }}</span> @enderror
</div>

<div class="col-md-2 mb-3">
    <label class="form-label">Odre</label>
    <input type="text" class="form-control" wire:model="stage_form.order" placeholder="Odre">
    @error('stage_form.order') <span class='text-danger'>{{ $message }}</span> @enderror
</div>

<div class="col-md-12 mb-3">
    <label class="form-label">Description</label>
    <textarea class="form-control" wire:model="stage_form.description" placeholder="Description" data-bs-toggle="autosize"></textarea>
    @error('stage_form.description') <span class='text-danger'>{{ $message }}</span> @enderror
</div>
