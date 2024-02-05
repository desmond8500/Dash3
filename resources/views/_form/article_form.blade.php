<div class="row">
    <div class="col-md-12 mb-3">
        <label class="form-label">Désignation</label>
        <input type="text" class="form-control" wire:model="designation" placeholder="Désignation">
        @error('designation') <span class='text-danger'>{{ $message }}</span> @enderror
    </div>

    <div class="col-md-12 mb-3">
        <label class="form-label">Référence</label>
        <textarea class="form-control" wire:model="reference" placeholder="Référence" cols="30" rows="1"></textarea>
        @error('reference') <span class='text-danger'>{{ $message }}</span> @enderror
    </div>

    <div class="col-md-4 mb-3">
        <label class="form-label">Quantite</label>
        <input type="text" class="form-control" wire:model="quantity" placeholder="Quantite">
        @error('quantity') <span class='text-danger'>{{ $message }}</span> @enderror
    </div>

    <div class="col-md-4 mb-3">
        <label class="form-label">Prix</label>
        <input type="text" class="form-control" wire:model="price" placeholder="Prix">
        @error('price') <span class='text-danger'>{{ $message }}</span> @enderror
    </div>

    <div class="col-md-4 mb-3">
        <label class="form-label">Priorite</label>
        <select class="form-control" wire:model="priority_id">
            <option value=""></option>
        </select>
        @error('priority_id') <span class='text-danger'>{{ $message }}</span> @enderror
    </div>

    <div class="col-md-6 mb-3">
        <label class="form-label">Marque</label>
        <select class="form-control" wire:model="brand_id">
            <option value=""></option>
        </select>
        @error('brand_id') <span class='text-danger'>{{ $message }}</span> @enderror
    </div>

    <div class="col-md-12 mb-3">
        <label class="form-label">Description</label>
        <textarea class="form-control" wire:model="description" placeholder="Description" cols="30" rows="5"></textarea>
        @error('description') <span class='text-danger'>{{ $message }}</span> @enderror
    </div>

</div>
