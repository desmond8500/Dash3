<div class="col-md-6 mb-3">
    <label class="form-label">Prénom</label>
    <input type="text" class="form-control" wire:model="vontact_form.prenom" placeholder="Prénom">
    @error('vontact_form.prenom') <span class='text-danger'>{{ $message }}</span> @enderror
</div>
<div class="col-md-6 mb-3">
    <label class="form-label">Nom</label>
    <input type="text" class="form-control" wire:model="vontact_form.nom" placeholder="Nom">
    @error('vontact_form.nom') <span class='text-danger'>{{ $message }}</span> @enderror
</div>
<div class="col-md-6 mb-3">
    <label class="form-label">Fonction</label>
    <input type="text" class="form-control" wire:model="vontact_form.fonction" placeholder="Fonction">
    @error('vontact_form.fonction') <span class='text-danger'>{{ $message }}</span> @enderror
</div>
