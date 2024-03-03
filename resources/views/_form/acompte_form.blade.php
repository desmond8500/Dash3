<div class="col-md-8">
    <div class="mb-3">
        <label class="form-label">Titre</label>
        <input type="text" class="form-control" wire:model="acompte_form.name" placeholder="Nom">
        @error('acompte_form.name') <span class='text-danger'>{{ $message }}</span> @enderror
    </div>

    <div class="mb-3">
        <label class="form-label">Description</label>
        <textarea class="form-control" wire:model="acompte_form.description" placeholder="Description" cols="30"
            rows="5"></textarea>
        @error('acompte_form.description') <span class='text-danger'>{{ message }}</span> @enderror
    </div>
</div>

<div class="col-md-4">
    <div class="mb-3">
        <label class="form-label">Montant</label>
        <input type="text" class="form-control" wire:model="acompte_form.montant" placeholder="Montant">
        @error('acompte_form.montant') <span class='text-danger'>{{ $message }}</span> @enderror
    </div>
    <div class="mb-3">
        <label class="form-label">Date</label>
        <input type="date" class="form-control" wire:model='acompte_form.date'>
        @error('acompte_form.date') <span class='text-danger'>{{ $message }}</span> @enderror
    </div>
    <div class="mb-3">
        <label class="form-label">Statut </label>
        <select class="form-control" wire:model="acompte_form.statut">
            <option value="0" class="text-danger">Pas payé</option>
            <option value="1" class="text-success">Payé</option>
        </select>
        @error('acompte_form.statut') <span class='text-danger'>{{ $message }}</span> @enderror
    </div>

</div>



