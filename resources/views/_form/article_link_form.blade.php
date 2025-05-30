<div class="col-md-12 mb-3">
    <label class="form-label">Nom</label>
    <div class="input-group">
        <input type="text" class="form-control" list="articleLinksList" wire:model="article_link_form.name" placeholder="Nom">
        <datalist id="articleLinksList">
            <option>Site Officiel</option>
            <option>Manuel</option>
            <option>Fiche</option>
            <option>Fiche Technique</option>
            <option>Brochure</option>
            <option>{{ $article->provider->name ?? "" }}</option>
        </datalist>
    </div>
    @error('article_link_form.name') <span class='text-danger'>{{ $message }}</span> @enderror
</div>
<div class="col-md-12 mb-3">
    <label class="form-label">Lien</label>
    <input type="text" class="form-control" wire:model="article_link_form.link" placeholder="lien">
    @error('article_link_form.link') <span class='text-danger'>{{ $message }}</span> @enderror
</div>
