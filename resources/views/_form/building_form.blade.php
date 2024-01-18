<div>
    <div class="row">
        <div class="col-md-9 mb-3">
            <label class="form-label">Nom du batiment</label>
            <input type="text" class="form-control" wire:model="name" placeholder="Nom du batiment">
            @error('name') <span class='text-danger'>{{ $message }}</span> @enderror
        </div>
        <div class="col-md-3 mb-3">
            <label class="form-label">Odre</label>
            <input type="text" class="form-control" wire:model="order" placeholder="Odre">
            @error('order') <span class='text-danger'>{{ $message }}</span> @enderror
        </div>

        <div class="col-md-12 mb-3">
            <label class="form-label">Description</label>
            <textarea class="form-control" wire:model="description" placeholder="Description" cols="30" rows="5"></textarea>
            @error('description') <span class='text-danger'>{{ $message }}</span> @enderror
        </div>
    </div>
</div>
