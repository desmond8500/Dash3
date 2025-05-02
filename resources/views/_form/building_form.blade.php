<div>
    <div class="row">
        <div class="col-md-9 mb-3">
            <label class="form-label">Nom du batiment</label>
            <input type="text" class="form-control" wire:model="building_form.name" placeholder="Nom du batiment">
            @error('building_form.name') <span class='text-danger'>{{ $message }}</span> @enderror
        </div>
        <div class="col-md-3 mb-3">
            <label class="form-label">Odre</label>
            <input type="text" class="form-control" wire:model="building_form.order" placeholder="Odre">
            @error('building_form.order') <span class='text-danger'>{{ $message }}</span> @enderror
        </div>

        <div class="col-md-12 mb-3">
            <label class="form-label">Description</label>
            <textarea class="form-control" wire:model="building_form.description" placeholder="Description" data-bs-toggle="autosize"></textarea>
            @error('building_form.description') <span class='text-danger'>{{ $message }}</span> @enderror
        </div>
    </div>
</div>
