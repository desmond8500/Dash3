<div class="col-md-6 mb-3">
    <label class="form-label">Prénom</label>
    <input type="text" class="form-control" wire:model="team_form.firstname" placeholder="Prénom">
    @error('team_form.firstname') <span class='text-danger'>{{ $message }}</span> @enderror
</div>
<div class="col-md-6 mb-3">
    <label class="form-label">Nom</label>
    <input type="text" class="form-control" wire:model="team_form.lastname" placeholder="nom">
    @error('team_form.lastname') <span class='text-danger'>{{ $message }}</span> @enderror
</div>
<div class="col-md-6 mb-3">
    <label class="form-label">Fonction ou poste</label>
    <input type="text" class="form-control" wire:model="team_form.function" placeholder="Fonction ou poste">
    @error('team_form.function') <span class='text-danger'>{{ $message }}</span> @enderror
</div>
<div class="w-100"></div>
<div class="col-md-6 mb-3">
    <label class="form-label">Email</label>
    <input type="text" class="form-control" wire:model="email_form.email" placeholder="Fonction ou poste">
    @error('email_form.function') <span class='text-danger'>{{ $message }}</span> @enderror
</div>
<div class="col-md-6 mb-3">
    <label class="form-label">Téléphone</label>
    <input type="text" class="form-control" wire:model="phone_form.phone" placeholder="Fonction ou poste">
    @error('phone_form.function') <span class='text-danger'>{{ $message }}</span> @enderror
</div>
