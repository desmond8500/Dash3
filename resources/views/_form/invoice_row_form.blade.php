<div class="row">
    <div class="col-md-8 mb-3">
        <label class="form-label">Désignation</label>
        <input type="text" class="form-control" wire:model="designation" placeholder="Désignation de l'article">
        @error('designation') <span class='text-danger'>{{ $message }}</span> @enderror
    </div>
    <div class="col-md-4 mb-3">
        <label class="form-label">Quantité</label>
        <input type="text" class="form-control" wire:model="quantite" placeholder="Quantité">
        @error('quantite') <span class='text-danger'>{{ $message }}</span> @enderror
    </div>

    <div class="col-md-4 mb-3">
        <label class="form-label">Prix</label>
        <input type="text" class="form-control" wire:model="prix" placeholder="Prix de l'article">
        @error('prix') <span class='text-danger'>{{ $message }}</span> @enderror
    </div>
    <div class="col-md-4 mb-3">
        <label class="form-label">Coeficient</label>
        <input type="text" class="form-control" wire:model="coef" placeholder="Coféficient de marge">
        @error('coef') <span class='text-danger'>{{ $message }}</span> @enderror
    </div>
    <div class="col-md-4 mb-3">
        <label class="form-label">Priorité</label>
        <select wire:model="priorite" class="form-select">
            @foreach ($priorites as $key => $priorite)
            <option value="{{ $key+1 }}">{{ $priorite }}</option>
            @endforeach
        </select>
        @error('priorite') <span class='text-danger'>{{ $message }}</span> @enderror
    </div>

    <div class="col-md-12 mb-3">
        <label class="form-label">Référence</label>
        <textarea class="form-control" wire:model="reference" placeholder="Référence de l'article" cols="30" rows="4"></textarea>
        @error('reference') <span class='text-danger'>{{ $message }}</span> @enderror
    </div>

    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
        <button type="submit" class="btn btn-primary">Valider</button>
    </div>
</div>

