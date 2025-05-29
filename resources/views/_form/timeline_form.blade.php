<div>
    <div class="col-md-12 mb-3">
        <label class="form-label">Titre</label>
        <input type="text" class="form-control" wire:model="title" placeholder="Titre">
        @error('title') <span class='text-danger'>{{ $message }}</span> @enderror
    </div>

    <div class="col-md-12 mb-3">
        <label class="form-label">Description</label>
        <textarea class="form-control" wire:model="description" placeholder="Description" data-bs-toggle="autosize" cols="30" rows="5"></textarea>
        @error('description') <span class='text-danger'>{{ $message }}</span> @enderror
    </div>

</div>
