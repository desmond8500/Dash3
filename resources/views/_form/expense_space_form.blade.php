<div>
    <div class="col-md-12 mb-3">
        <label class="form-label">Name</label>
        <input type="text" class="form-control" wire:model="space_name" placeholder="Name">
        @error('space_name') <span class='text-danger'>{{ $message }}</span> @enderror
    </div>

    <div class="col-md-4 mb-3">
        <label class="form-label">Type</label>
        <select class="form-select" wire:model="space_type">
            <option value="Personnel">Personnel</option>
            <option value="Commune">Commune</option>
            <option value="Professionel">Professionel</option>
        </select>
        @error('space_type') <span class='text-danger'>{{ $message }}</span> @enderror
    </div>

    <div class="col-md-12 mb-3">
        <label class="form-label">Description</label>
        <textarea class="form-control" wire:model="space_description" placeholder="Description" cols="30" rows="5"></textarea>
        @error('space_description') <span class='text-danger'>{{ $message }}</span> @enderror
    </div>
</div>
