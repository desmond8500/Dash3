<div class="row">
    <div class="col-md-12 mb-3">
        <label class="form-label">Description</label>
        <textarea class="form-control" wire:model="form.description" placeholder="Description" data-bs-toggle="autosize"></textarea>
        @error('form.description') <span class='text-danger'>{{ $message }}</span> @enderror
    </div>

    <div class="col-md-12 mb-3">
        <label class="form-label">Détails</label>
        <textarea class="form-control" wire:model="form.details" placeholder="Description" data-bs-toggle="autosize"></textarea>
        @error('form.details') <span class='text-danger'>{{ $message }}</span> @enderror
    </div>

    <div class="w-100"></div>

    <div class="col-auto mb-3">
        <label class="form-check form-switch">
            <input class="form-check-input" type="checkbox" wire:model="form.client_name" />

            <span class="form-check-label">Nom du client</span>
        </label>
        <select class="form-select" wire:model="form.client_name">
            <option value="1">1</option>
            <option value="0">0</option>
        </select>
        @error('form.client_name') <span class='text-danger'>{{ $message }}</span> @enderror
    </div>

    <div class="col-auto mb-3">
        <label class="form-check form-switch">
            <input class="form-check-input" type="checkbox" wire:model="form.logo" />
            <span class="form-check-label">Logo</span>
        </label>
        <select class="form-select" wire:model="form.logo">
            <option value="1">1</option>
            <option value="0">0</option>
        </select>
        @error('form.logo') <span class='text-danger'>{{ $message }}</span> @enderror
    </div>

    <div class="col-auto mb-3">
        <label class="form-check form-switch">
            <input class="form-check-input" type="checkbox" wire:model="form.projet_name" />
            <span class="form-check-label">Projet</span>
        </label>
        <select class="form-select" wire:model="form.projet_name">
            <option value="1">1</option>
            <option value="0">0</option>
        </select>
        @error('form.projet_name') <span class='text-danger'>{{ $message }}</span> @enderror
    </div>
    <div class="col-auto mb-3">
        <label class="form-check form-switch">
            <input class="form-check-input" type="checkbox" wire:model="form.footer" />
            <span class="form-check-label">Bas de page</span>
        </label>
        <select class="form-select" wire:model="form.footer">
            <option value="1">1</option>
            <option value="0">0</option>
        </select>
        @error('form.footer') <span class='text-danger'>{{ $message }}</span> @enderror
    </div>
    <div class="col-auto mb-3">
        <label class="form-check form-switch">
            <input class="form-check-input" type="checkbox" wire:model="form.description" />
            <span class="form-check-label">Description</span>
        </label>
        <select class="form-select" wire:model="form.description">
            <option value="1">1</option>
            <option value="0">0</option>
        </select>
        @error('form.description') <span class='text-danger'>{{ $message }}</span> @enderror
    </div>




</div>
