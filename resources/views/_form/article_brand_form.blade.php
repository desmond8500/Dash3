<div class="col-auto mb-3">
    <input type="file" id="file" accept="image/*" style="display: none" wire:model="brand_form.logo">
    <label for="file" href="#" class="avatar avatar-upload rounded">
        <i class="ti ti-plus"></i>
        <span class="avatar-upload-text">Add</span>
    </label>
</div>
<div class="col mb-3">
    <label class="form-label">Nom </label>
    <input type="text" class="form-control" wire:model='brand_form.name' />
    @error('brand_form.name') <span class="text-danger">{{ $message }}</span> @enderror
</div>

<div class="col-md-12 mb-3">
    <label class="form-label">Description</label>
    <textarea class="form-control" wire:model="brand_form.description" placeholder="Description du client" id=""
        cols="30" rows="3"></textarea>
</div>
