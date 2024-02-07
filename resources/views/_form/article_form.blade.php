<div class="row">
    <div class="col-md-12 mb-3">
        <label class="form-label">Désignation</label>
        <input type="text" class="form-control" wire:model="article_form.designation" placeholder="Désignation">
        @error('article_form.designation') <span class='text-danger'>{{ $message }}</span> @enderror
    </div>

    <div class="col-md-12 mb-3">
        <label class="form-label">Référence</label>
        <textarea class="form-control" wire:model="article_form.reference" placeholder="Référence" cols="30" rows="1"></textarea>
        @error('article_form.reference') <span class='text-danger'>{{ $message }}</span> @enderror
    </div>

    <div class="col-md-4 mb-3">
        <label class="form-label">Quantité</label>
        <input type="text" class="form-control" wire:model="article_form.quantity" placeholder="Quantite">
        @error('article_form.quantity') <span class='text-danger'>{{ $message }}</span> @enderror
    </div>
    <div class="col-md-4 mb-3">
        <label class="form-label">Quantité Minimale</label>
        <input type="text" class="form-control" wire:model="article_form.quantity_min" placeholder="Quantite">
        @error('article_form.quantity_min') <span class='text-danger'>{{ $message }}</span> @enderror
    </div>

    <div class="col-md-4 mb-3">
        <label class="form-label">Prix</label>
        <input type="text" class="form-control" wire:model="article_form.price" placeholder="Prix">
        @error('article_form.price') <span class='text-danger'>{{ $message }}</span> @enderror
    </div>

    <div class="col-md-4 mb-3">
        <label class="form-label">Priorite</label>
        <select class="form-control" wire:model="article_form.priority_id">
            <option value=""></option>
        </select>
        @error('article_form.priority_id') <span class='text-danger'>{{ $message }}</span> @enderror
    </div>

    <div class="col-md-6 mb-3">
        <label class="form-label">Marque</label>
        <select class="form-control" wire:model="article_form.brand_id">
            <option value=""></option>
        </select>
        @error('article_form.brand_id') <span class='text-danger'>{{ $message }}</span> @enderror
    </div>

    <div class="col-md-12 mb-3">
        <label class="form-label">Description</label>
        <textarea class="form-control" wire:model="article_form.description" placeholder="Description" cols="30" rows="5"></textarea>
        @error('article_form.description') <span class='text-danger'>{{ $message }}</span> @enderror
    </div>

</div>
