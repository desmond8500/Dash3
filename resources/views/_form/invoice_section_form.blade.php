<div class="col-md-8 mb-3">
    <label class="form-label">Nom de la section</label>
    <input type="text" class="form-control" wire:model="section_form.section" placeholder="Nom">
    @error('section_form.section') <span class='text-danger'>{{ $message }}</span> @enderror
</div>

<div class="col-md-4 mb-3">
    <label class="form-label">Ordre</label>
    <input type="number" class="form-control" wire:model="section_form.ordre" placeholder="Ordre">
    @error('section_form.ordre') <span class='text-danger'>{{ $message }}</span> @enderror
</div>
