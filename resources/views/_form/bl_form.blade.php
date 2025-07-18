@error('bl_form.invoice_id') <span class='text-danger'>{{ $message }}</span> @enderror

<div class="col-md-8 mb-3">
    <label class="form-label">Description</label>
    <input type="text" class="form-control" wire:model="bl_form.name" placeholder="Description du bl">
    @error('bl_form.name') <span class='text-danger'>{{ $message }}</span> @enderror
</div>
<div class="col-md-4 mb-3">
    <label class="form-label">Date</label>
    <input type="date" class="form-control" wire:model="bl_form.date">
    @error('bl_form.date') <span class='text-danger'>{{ $message }}</span> @enderror
</div>
<div class="col-md-6 mb-3">
    <label class="form-label">Type</label>
    <select class="form-select" wire:model="bl_form.type">
        <option value="travaux">Bordereau de travaux</option>
        <option value="livraison">Bordereau de livraison</option>
    </select>
    @error('bl_form.type') <span class='text-danger'>{{ $message }}</span> @enderror
</div>
<div class="col-md-6 mb-3">
    <label class="form-label">Logo</label>
    <select class="form-select" wire:model="bl_form.logo">
        <option value="">- Select -</option>
        <option value="1">True</option>
        <option value="0">False</option>
    </select>
    @error('bl_form.type') <span class='text-danger'>{{ $message }}</span> @enderror
</div>

<div class="col-md-12 mb-3">
    <label class="form-label">Travaux Effectués</label>
    <textarea class="form-control" wire:model="bl_form.done" placeholder="Travaux Effectués" data-bs-toggle="autosize"></textarea>
    @error('bl_form.done') <span class='text-danger'>{{ $message }}</span> @enderror
</div>
<div class="col-md-12 mb-3">
    <label class="form-label">Travaux Restants</label>
    <textarea class="form-control" wire:model="bl_form.todo" placeholder="Travaux Restants" data-bs-toggle="autosize"></textarea>
    @error('bl_form.todo') <span class='text-danger'>{{ $message }}</span> @enderror
</div>
