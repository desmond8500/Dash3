<div class="col-md-8">
    <div class="mb-2">
        <label class="form-label">Titre</label>
        <input type="text" class="form-control" wire:model="acompte_form.name" placeholder="Nom">
        @error('acompte_form.name') <span class='text-danger'>{{ $message }}</span> @enderror
    </div>

    <div class="mb-2">
        <label class="form-label">Description</label>
        <textarea class="form-control" wire:model="acompte_form.description" placeholder="Description" data-bs-toggle="autosize"></textarea>
        @error('acompte_form.description') <span class='text-danger'>{{ $message }}</span> @enderror
    </div>
    <div class="mb-3">
        <label class="form-label">Afficher le résumé</label>
        <label class="form-check form-switch">
            <input class="form-check-input" type="checkbox" wire:model="acompte_form.show" />
        </label>
        @error('acompte_form.show') <span class='text-danger'>{{ $message }}</span> @enderror
    </div>
</div>

<div class="col-md-4">
    <div class="mb-2">
        <label class="form-label">Montant</label>
        <input type="text" class="form-control" wire:model="acompte_form.montant" placeholder="Montant">
        @error('acompte_form.montant') <span class='text-danger'>{{ $message }}</span> @enderror
    </div>
    <div class="mb-2">
        <label class="form-label">Date</label>
        <input type="date" class="form-control" wire:model='acompte_form.date'>
        @error('acompte_form.date') <span class='text-danger'>{{ $message }}</span> @enderror
    </div>
    <div class="mb-2">
        <label class="form-label">Statut </label>
        <select class="form-select" wire:model="acompte_form.statut">
            <option value="0" class="text-danger">Pas payé</option>
            <option value="1" class="text-success">Payé</option>
        </select>
        @error('acompte_form.statut') <span class='text-danger'>{{ $message }}</span> @enderror
    </div>

</div>



