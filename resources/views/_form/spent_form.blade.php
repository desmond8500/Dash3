<div class="col-md-8">
    <div class="mb-3">
        <label class="form-label">Titre</label>
        <input type="text" class="form-control" wire:model="spent_form.name" placeholder="Nom">
        @error('spent_form.name') <span class='text-danger'>{{ $message }}</span> @enderror
    </div>

    <div class="mb-3">
        <label class="form-label">Description</label>
        <textarea class="form-control" wire:model="spent_form.description" placeholder="Description" data-bs-toggle="autosize"></textarea>
        @error('spent_form.description') <span class='text-danger'>{{ message }}</span> @enderror
    </div>
</div>

<div class="col-md-4">
    <div class="mb-3">
        <label class="form-label">Montant</label>
        <input type="text" class="form-control" wire:model="spent_form.montant" placeholder="Montant">
        @error('spent_form.montant') <span class='text-danger'>{{ $message }}</span> @enderror
    </div>
    <div class="mb-3">
        <label class="form-label">Date</label>
        <input type="date" class="form-control" wire:model='spent_form.date'>
        @error('spent_form.date') <span class='text-danger'>{{ $message }}</span> @enderror
    </div>
    <div class="mb-3">
        <label class="form-label">Statut</label>
        <select class="form-control" wire:model="spent_form.status">
            <option value="prevue">Prévue</option>
            <option value="achete">achete</option>
        </select>
        @error('Name') <span class='text-danger'>{{ $message }}</span> @enderror
    </div>

</div>



