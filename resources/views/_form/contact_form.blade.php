<div class="col-md-6 mb-3">
    <label class="form-label">Prénom</label>
    <input type="text" class="form-control" wire:model="contact_form.firstname" placeholder="Prénom">
    @error('contact_form.firstname') <span class='text-danger'>{{ $message }}</span> @enderror
</div>
<div class="col-md-6 mb-3">
    <label class="form-label">Nom</label>
    <input type="text" class="form-control" wire:model="contact_form.lastname" placeholder="Nom">
    @error('contact_form.lastname') <span class='text-danger'>{{ $message }}</span> @enderror
</div>
<div class="col-md-6 mb-3">
    <label class="form-label">Fonction</label>
    <input type="text" class="form-control" wire:model="contact_form.fonction" placeholder="Fonction">
    @error('contact_form.fonction') <span class='text-danger'>{{ $message }}</span> @enderror
</div>
