<div class="row g-2">
    <div class="col-12">
        <div wire:loading wire:target="article_form.image" class="alert alert-info d-flex align-items-center" role="alert">
            Chargement <div class="spinner-border" role="status"></div>
        </div>
        <div class="row g-1">
            @if ($article_form)
                @if ($article_form->image)
                    @if(is_string($article_form->image))
                        <img src="{{ asset($article_form->image) }}" alt="" class="avatar avatar-xl rounded avatar-upload mt-1 col-auto">
                    @else
                        <img src="{{ $article_form->image->temporaryUrl() }}" alt="" class="avatar avatar-xl rounded avatar-upload mt-1 col-auto">
                    @endif
                    <label for="file" href="#" class="avatar avatar-xl avatar-upload rounded col-auto">
                        <i class="ti ti-edit text-muted"></i>
                        <span class="avatar-upload-text">Modifier</span>
                    </label>
                @else
                    <label for="file" href="#" class="avatar avatar-xl avatar-upload rounded col-auto">
                        <i class="ti ti-plus text-muted"></i>
                        <span class="avatar-upload-text">Ajouter</span>
                    </label>
                @endif

            @endif
        </div>
        <input type="file" id="file" accept="image/*" style="display: none" wire:model.live="article_form.image">
    </div>

    <div class="col-md-8">
        <label class="form-label required">Désignation </label>
        <input type="text" class="form-control" wire:model="article_form.designation" placeholder="Désignation">
        @error('article_form.designation') <span class='text-danger'>{{ $message }}</span> @enderror
    </div>

    <div class="col-md-4">
        <div class="row g-2">
            <div class="col-6">
                <label class="form-label">Qte</label>
                <input type="number" class="form-control" wire:model="article_form.quantity" placeholder="Quantite">
                @error('article_form.quantity') <span class='text-danger'>{{ $message }}</span> @enderror
            </div>
            <div class="col-6">
                <label class="form-label">Qte Min</label>
                <input type="number" class="form-control" wire:model="article_form.quantity_min" placeholder="Quantite">
                @error('article_form.quantity_min') <span class='text-danger'>{{ $message }}</span> @enderror
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <label class="form-label required">Référence</label>
        <div class="input-group">
            <textarea class="form-control" wire:model="article_form.reference" placeholder="Référence" cols="30"
                rows="1"></textarea>
            <a class="btn btn-primary btn-icon" wire:click='uppercase' data-bs-toggle="tooltip" title="Majuscule">
                <i class="ti ti-arrow-big-up"></i>
            </a>
        </div>
        @error('article_form.reference') <span class='text-danger'>{{ $message }}</span> @enderror
    </div>
    <div class="col-md-6">
        <label class="form-label">Prix</label>
        <div class="input-group">
            <input type="number" class="form-control" wire:model.live="article_form.price" placeholder="Prix">
            <a class="btn btn-primary btn-icon" wire:click="$set('article_form.price', '{{ ($article_form->price ?? 1) * 1,8 }}' )">
                tva
            </a>
            <a class="btn btn-icon btn-primary" wire:click="$set('article_form.price', '{{ ($article_form->price ?? 1) * 655 }}' )" data-bs-toggle="tooltip" title="Convertir en Euro">
                <i class="ti ti-currency-euro"></i>
            </a>
        </div>
        @error('article_form.price') <span class='text-danger'>{{ $message }}</span> @enderror
    </div>

    <div class="col-md-4">
        <label class="form-label">Priorite</label>

        <select class="form-select" wire:model="article_form.priority_id">
            <option value="0">Centrale 1</option>
            <option value="1">Centrale 2</option>
            <option value="2">Organe 1</option>
            <option value="3">Organe 2</option>
            <option value="4">Organe 3</option>
            <option value="5">Cable</option>
            <option value="6">Accessoires</option>
            <option value="7">Forfait</option>
        </select>
        @error('article_form.priority_id') <span class='text-danger'>{{ $message }}</span> @enderror
    </div>

    <div class="col-6 col-md-4">
        <label class="form-label">Fournisseur</label>
        <select class="form-select" wire:model="article_form.provider_id">
            <option value="" class="text-muted">--Sélectionner--</option>
            @foreach ($providers->sortBy('name') as $provider)
                <option value="{{ $provider->id }}">{{ $provider->name }}</option>
            @endforeach
        </select>
        @error('article_form.brand_id') <span class='text-danger'>{{ $message }}</span> @enderror
    </div>

    <div class="col-6 col-md-4">
        <label class="form-label">Marque</label>
        <select class="form-select" wire:model="article_form.brand_id">
            <option value="" >--Sélectionner--</option>
            @foreach ($brands->sortBy('name') as $brand)
            <option value="{{ $brand->id }}">{{ $brand->name }}</option>
            @endforeach
        </select>
        @error('article_form.brand_id') <span class='text-danger'>{{ $message }}</span> @enderror
    </div>

    <div class="col-md-12">
        <label class="form-label">Description</label>
        <textarea class="form-control"  wire:model="article_form.description" placeholder="Description" data-bs-toggle="autosize"></textarea>
        @error('article_form.description') <span class='text-danger'>{{ $message }}</span> @enderror
    </div>
    <div class="col-md-12">
        <label class="form-label">Spécifications techniques</label>
        <textarea class="form-control"  wire:model="article_form.spec" placeholder="Description" data-bs-toggle="autosize"></textarea>
        @error('article_form.spec') <span class='text-danger'>{{ $message }}</span> @enderror
    </div>

</div>
