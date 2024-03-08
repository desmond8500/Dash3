<div class="col-md-2 mb-3">
    <label class="form-label">Client_id</label>
    <input type="text" disabled class="form-control" wire:model="projetForm.client_id" placeholder="Nom du projet">
    @error('projetForm.client_id') <span class="text-danger">{{ $message }}</span> @enderror
</div>
<div class="col-md mb-3">
    <label class="form-label">Nom</label>
    <input type="text" class="form-control" wire:model="projetForm.name" placeholder="Nom du projet">
    @error('projetForm.name') <span class="text-danger">{{ $message }}</span> @enderror
</div>
<div class="col-auto md-3">
    <label class="form-label text-white">Favoris</label>
    @if ($projetForm->favorite)
    <button class="btn btn-secondary btn-icon" data-bs-toggle="tooltip" wire:click="toggleFavorite()"
        title="Supprimmer aux favoris">
        <i class="ti ti-heart"></i>
    </button>
    @else
    <button class="btn btn-success btn-icon" data-bs-toggle="tooltip" wire:click="toggleFavorite()"
        title="Ajouter aux favoris">
        <i class="ti ti-heart"></i>
    </button>
    @endif
</div>

<div class="w-100"></div>
<div class="col-md-6 mb-3">
    <label class="form-label">Date de début</label>
    <input type="date" class="form-control" wire:model="projetForm.start_date" placeholder="Nom du projet">
    @error('projetForm.start_date') <span class="text-danger">{{ $message }}</span> @enderror
</div>
<div class="col-md-6 mb-3">
    <label class="form-label">Date de fin</label>
    <input type="date" class="form-control" wire:model="projetForm.end_date" placeholder="Nom du projet">
    @error('projetForm.end_date') <span class="text-danger">{{ $message }}</span> @enderror
</div>
<div class="col-md-12 mb-3">
    <label class="form-label">Description</label>
    <textarea class="form-control" wire:model="projetForm.description" placeholder="Description du projet" cols="30"
        rows="3"></textarea>
    @error('projetForm.description') <span class="text-danger">{{ $message }}</span> @enderror
</div>

<div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
    <button type="submit" class="btn btn-primary">Valider</button>
</div>
