<div class="col-md-12 mb-3">
    <label class="form-label">Nom</label>
    <input type="text" class="form-control" wire:model="article_link_form.name" placeholder="Nom">
    @error('article_link_form.name') <span class='text-danger'>{{ $message }}</span> @enderror
</div>
<div class="col-md-12 mb-3">
    <label class="form-label">lien</label>
    <input type="text" class="form-control" wire:model="article_link_form.link" placeholder="lien">
    @error('article_link_form.link') <span class='text-danger'>{{ $message }}</span> @enderror
</div>
