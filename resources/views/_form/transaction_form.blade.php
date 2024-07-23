
<div class="col-md-8 mb-3">
    <div class="mb-3">
        <label class="form-label">Objet</label>
        <input type="text" class="form-control" wire:model="transaction_form.objet" placeholder="Nom">
        @error('transaction_form.objet') <span class='text-danger'>{{ $message }}</span> @enderror
    </div>

    <div class="mb-3">
        <label class="form-label">Description</label>
        <textarea class="form-control" wire:model="transaction_form.description" placeholder="Description" cols="30" rows="5"></textarea>
        @error('transaction_form.description') <span class='text-danger'>{{ message }}</span> @enderror
    </div>
</div>

<div class="col-md-4 mb-3">
    <div class="mb-3">
        <label class="form-label">Montant</label>
        <input type="text" class="form-control" wire:model="transaction_form.montant" placeholder="Montant">
        @error('transaction_form.montant') <span class='text-danger'>{{ $message }}</span> @enderror
    </div>

    <div class="mb-3">
        <label class="form-label">Type</label>
        <select class="form-select" wire:model="transaction_form.type">
            <option value="credit">Crédit</option>
            <option value="debit">Débit</option>
        </select>
        @error('transaction_form.type') <span class='text-danger'>{{ $message }}</span> @enderror
    </div>

    <div class="mb-3">
        <label class="form-label">Date</label>
        <input type="date" class="form-control" wire:model="transaction_form.date" placeholder="Nom">
        @error('transaction_form.date') <span class='text-danger'>{{ $message }}</span> @enderror
    </div>


</div>
