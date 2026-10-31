<div>
    <div class="col-md-12 mb-3">
        <label class="form-label">Name</label>
        <input type="text" class="form-control" wire:model="name" placeholder="Name">
        @error('name') <span class='text-danger'>{{ $message }}</span> @enderror
    </div>

    <div class="col-md-12 mb-3">
        <label class="form-label">Description</label>
        <textarea class="form-control" wire:model="description" placeholder="Description" cols="30" rows="5"></textarea>
        @error('description') <span class='text-danger'>{{ $message }}</span> @enderror
    </div>
</div>
