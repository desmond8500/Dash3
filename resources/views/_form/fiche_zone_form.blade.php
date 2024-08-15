<div class="col-md-3 mb-3">
    <label class="form-label">Zone</label>
    <input type="text" class="form-control" wire:model="zone_form.number" placeholder="Numéro de zone">
    @error('zone_form.number') <span class='text-danger'>{{ $message }}</span> @enderror
</div>
<div class="col-md-6 mb-3">
    <label class="form-label">Equipement</label>
    <input type="text" class="form-control" wire:model="zone_form.equipement" placeholder="Equipement">
    @error('zone_form.equipement') <span class='text-danger'>{{ $message }}</span> @enderror
</div>
<div class="col-md-5 mb-3">
    <label class="form-label">Nom du local</label>
    <input type="text" class="form-control" wire:model="zone_form.name" placeholder="Nom">
    @error('zone_form.name') <span class='text-danger'>{{ $message }}</span> @enderror
</div>
<div class="col-md-4 mb-3">
    <label class="form-label">Code</label>
    <input type="text" class="form-control" wire:model="zone_form.code" placeholder="Nom">
    @error('zone_form.code') <span class='text-danger'>{{ $message }}</span> @enderror
</div>
<div class="col-md-4 mb-3">
    <label class="form-label">Ordre</label>
    <input type="text" class="form-control" wire:model="zone_form.order" >
    @error('zone_form.order') <span class='text-danger'>{{ $message }}</span> @enderror
</div>
