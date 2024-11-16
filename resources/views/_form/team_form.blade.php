<div class="col-md-12 mb-3">
    <label class="form-label">Prénom</label>
    <input type="text" class="form-control" wire:model="team_form.firstname" placeholder="Prénom">
    @error('team_form.firstname') <span class='text-danger'>{{ $message }}</span> @enderror
</div>
<div class="col-md-12 mb-3">
    <label class="form-label">nom</label>
    <input type="text" class="form-control" wire:model="team_form.lastname" placeholder="nom">
    @error('team_form.lastname') <span class='text-danger'>{{ $message }}</span> @enderror
</div>
<div class="col-md-12 mb-3">
    <label class="form-label">Fonction ou poste</label>
    <input type="text" class="form-control" wire:model="team_form.function" placeholder="Fonction ou poste">
    @error('team_form.function') <span class='text-danger'>{{ $message }}</span> @enderror
</div>
