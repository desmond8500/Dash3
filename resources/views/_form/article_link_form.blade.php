<div class="col-md-12 mb-3">
    <label class="form-label">Nom</label>
    <div class="input-group">
        <input type="text" class="form-control" wire:model="article_link_form.name" placeholder="Nom">
        <div class="dropdown open">
            <button class="btn btn-primary btn-icon" type="button" id="triggerId" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" >
                <i class="ti ti-chevron-down"></i>
            </button>
            <div class="dropdown-menu" aria-labelledby="triggerId">
                <a class="dropdown-item" wire:click="set_name('Site officiel')">Site officiel</a>
                <a class="dropdown-item" wire:click="set_name('{{ $article->provider->name }}')">{{ $article->provider->name }}</a>
            </div>
        </div>
    </div>
    @error('article_link_form.name') <span class='text-danger'>{{ $message }}</span> @enderror
</div>
<div class="col-md-12 mb-3">
    <label class="form-label">lien</label>
    <input type="text" class="form-control" wire:model="article_link_form.link" placeholder="lien">
    @error('article_link_form.link') <span class='text-danger'>{{ $message }}</span> @enderror
</div>
