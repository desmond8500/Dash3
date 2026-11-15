<div>
    <div class="col-md-12 mb-3">
        <label class="form-label">Article ID</label>
        <input type="text" class="form-control" wire:model="article_id" placeholder="Article ID">
        @error('article_id') <span class='text-danger'>{{ $message }}</span> @enderror
    </div>
    <div class="col-md-12 mb-3">
        <label class="form-label">Quantité</label>
        <input type="text" class="form-control" wire:model="quantity" placeholder="Quantité">
        @error('quantity') <span class='text-danger'>{{ $message }}</span> @enderror
    </div>
</div>
