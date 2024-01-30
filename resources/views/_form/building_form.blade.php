<div>
    <div class="row">
        <div class="col-md-9 mb-3">
            <label class="form-label">Nom du batiment</label>
            <input type="text" class="form-control" wire:model="form.name" placeholder="Nom du batiment">
            @error('form.name') <span class='text-danger'>{{ $message }}</span> @enderror
        </div>
        <div class="col-md-3 mb-3">
            <label class="form-label">Odre</label>
            <input type="text" class="form-control" wire:model="form.order" placeholder="Odre">
            @error('form.order') <span class='text-danger'>{{ $message }}</span> @enderror
        </div>

        <div class="col-md-12 mb-3">
            <label class="form-label">Description</label>
            <textarea class="form-control" wire:model="form.description" placeholder="Description" cols="30" rows="5"></textarea>
            @error('form.description') <span class='text-danger'>{{ $message }}</span> @enderror
        </div>
    </div>
</div>
