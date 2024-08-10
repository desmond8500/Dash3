
<div class="col-md-6 mb-3">
    <label class="form-label">Prénom</label>
    <input type="text" class="form-control" wire:model="user_form.firstname" placeholder="Prénom">
    @error('user_form.firstname') <span class='text-danger'>{{ $message }}</span> @enderror
</div>
<div class="col-md-6 mb-3">
    <label class="form-label">Nom</label>
    <input type="text" class="form-control" wire:model='user_form.lastname' placeholder="Nom">
    @error('user_form.lastname') <span class='text-danger'>{{ $message }}</span> @enderror
</div>
<div class="col-md-6 mb-3">
    <label class="form-label">Fonction</label>
    <input type="text" class="form-control" wire:model='user_form.function' placeholder="Fonction">
    @error('user_form.function') <span class='text-danger'>{{ $message }}</span> @enderror
</div>
