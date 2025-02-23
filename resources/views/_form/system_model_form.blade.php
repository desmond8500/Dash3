
<div class="col-md-4 mb-3">
    <label class="form-label">invoice_system_id</label>
    <input type="text" class="form-control" disabled wire:model="model_form.invoice_system_id" >
    @error('model_form.invoice_system_id') <span class='text-danger'>{{ $message }}</span> @enderror
</div>

<div class="col-md-8 mb-3">
    <label class="form-label">Nom du système</label>
    <input type="text" class="form-control" wire:model="model_form.name" placeholder="Nom du système">
    @error('model_form.name') <span class='text-danger'>{{ $message }}</span> @enderror
</div>

<div class="col-md-12 mb-3">
    <label class="form-label">Description</label>
    <textarea class="form-control" wire:model="model_form.description" placeholder="Description" data-bs-toggle="autosize"></textarea>
    @error('model_form.description') <span class='text-danger'>{{ $message }}</span> @enderror
</div>
