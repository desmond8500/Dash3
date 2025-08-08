<div class="col-md-12 mb-3">
    <label class="form-label">Nom</label>
    <input type="text" class="form-control" wire:model="webpage_category_form.name" placeholder="Nom">
    @error('webpage_category_form.name') <span class='text-danger'>{{ $message }}</span> @enderror
</div>

<div class="col-md-12 mb-3">
    <label class="form-label">Description</label>
    <textarea class="form-control" wire:model="webpage_category_form.description" placeholder="Description" cols="30" rows="5"></textarea>
    @error('webpage_category_form.description') <span class='text-danger'>{{ $message }}</span> @enderror
</div>
