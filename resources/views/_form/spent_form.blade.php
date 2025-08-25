<div class="col-md-8">
    <div class="mb-3">
        <label class="form-label">Titre s</label>
        <div class="input-group">
            <input type="text" class="form-control" wire:model="spent_form.name" placeholder="Nom">
            <div class="dropdown open">
                <button class="btn btn-icon" type="button" id="triggerId" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" >
                    <i class="ti ti-chevron-down"></i>
                </button>
                <div class="dropdown-menu" aria-labelledby="triggerId">
                    <a class="dropdown-item" wire:click="$set('spent_form.name', 'Main d\'oeuvre')"> Main d'oeuvre</a>
                </div>
            </div>
        </div>
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
        <div class="input-group">
            <input type="text" class="form-control" wire:model="spent_form.montant" placeholder="Montant">
            <div class="dropdown open">
                <button class="btn btn-icon" type="button" id="triggerId" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="ti ti-chevron-down"></i>
                </button>
                <div class="dropdown-menu" aria-labelledby="triggerId">
                    <a class="dropdown-item" wire:click="$set('spent_form.montant', 10000)"> 10000</a>
                    <a class="dropdown-item" wire:click="$set('spent_form.montant', 20000)"> 20000</a>
                    <a class="dropdown-item" wire:click="$set('spent_form.montant', 30000)"> 30000</a>
                    <a class="dropdown-item" wire:click="$set('spent_form.montant', 40000)"> 40000</a>
                    <a class="dropdown-item" wire:click="$set('spent_form.montant', 50000)"> 50000</a>
                </div>
            </div>
        </div>
        @error('spent_form.montant') <span class='text-danger'>{{ $message }}</span> @enderror
    </div>
    <div class="mb-3">
        <label class="form-label">Date</label>
        <input type="date" class="form-control" wire:model='spent_form.date'>
        @error('spent_form.date') <span class='text-danger'>{{ $message }}</span> @enderror
    </div>
    <div class="mb-3">
        <label class="form-label">Statut</label>
        <select class="form-select" wire:model="spent_form.status">
            <option value="prevue">Prévue</option>
            <option value="achete">Acheté</option>
        </select>
        @error('Name') <span class='text-danger'>{{ $message }}</span> @enderror
    </div>

</div>



