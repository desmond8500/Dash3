<div class="row">
    <div class="col-md-12">
        <div wire:loading>
            <div class="d-flex justify-content-between">
                <div>Chargement <span class="animated-dots"></div>
            </div>
        </div>
    </div>
    <div class="col-12 mb-3">

        {{-- @isset($article_form->image)
            @if ($article_form->image)
                @foreach (glob(dirname($article_form->image)."/*") as $item)
                    <img src="{{ asset($item) }}" class="avatar avatar-md rounded" alt="A">
                @endforeach
            @endif
        @endisset --}}


        <input type="file" id="file" accept="image/*" multiple style="display: none" wire:model="article_form.image">
        <label for="file" href="#" class="avatar avatar-upload rounded">
            <i class="ti ti-plus"></i>
            <span class="avatar-upload-text">Add</span>
        </label>
    </div>
    <div class="col-md-8 mb-3">
        <div class="mb-3">
            <label class="form-label required">Désignation</label>
            <input type="text" class="form-control" wire:model="article_form.designation" placeholder="Désignation">
            @error('article_form.designation') <span class='text-danger'>{{ $message }}</span> @enderror
        </div>
    {{-- </div>

    <div class="col-md-12 mb-3"> --}}
        <label class="form-label required">Référence</label>
        <textarea class="form-control" wire:model="article_form.reference" placeholder="Référence" cols="30" rows="1"></textarea>
        @error('article_form.reference') <span class='text-danger'>{{ $message }}</span> @enderror
    </div>

    {{-- <div class="col-md-4 mb-3">
        <div class="row">
            <div class="mb-3 col-md-6">
                <label class="form-label">Qte</label>
                <input type="text" class="form-control" wire:model="article_form.quantity" placeholder="Quantite">
                @error('article_form.quantity') <span class='text-danger'>{{ $message }}</span> @enderror
            </div>
            <div class="col-md-6">
                <label class="form-label">Qte Min</label>
                <input type="text" class="form-control" wire:model="article_form.quantity_min" placeholder="Quantite">
                @error('article_form.quantity_min') <span class='text-danger'>{{ $message }}</span> @enderror
            </div>
            <div class="col-md-12">
                <label class="form-label">Prix</label>
                <input type="text" class="form-control" wire:model="article_form.price" placeholder="Prix">
                @error('article_form.price') <span class='text-danger'>{{ $message }}</span> @enderror
            </div>
        </div>
    </div> --}}
{{--
    <div class="col-md-4 mb-3">
        <label class="form-label">Priorite</label>
        <select class="form-control" wire:model="article_form.priority_id">
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

    <div class="col-md-4 mb-3">
        <label class="form-label">Fournisseur</label>
        <select class="form-control" wire:model="article_form.provider_id">
            <option value="0" disabled>Sélectionner</option>
            @foreach ($providers as $provider)
                <option value="{{ $provider->id }}">{{ $provider->name }}</option>
            @endforeach
        </select>
        @error('article_form.provider_id') <span class='text-danger'>{{ $message }}</span> @enderror
    </div>

    <div class="col-md-4 mb-3">
        <label class="form-label">Marque</label>
        <select class="form-control" wire:model="article_form.brand_id">
            <option value="0" disabled>Sélectionner</option>
            @foreach ($brands as $brand)
            <option value="{{ $brand->id }}">{{ $brand->name }}</option>
            @endforeach
        </select>
        @error('article_form.brand_id') <span class='text-danger'>{{ $message }}</span> @enderror
    </div>

    <div class="col-md-12 mb-3">
        <label class="form-label">Description</label>
        <textarea class="form-control" wire:model="article_form.description" placeholder="Description" cols="30" rows="5"></textarea>
        @error('article_form.description') <span class='text-danger'>{{ $message }}</span> @enderror
    </div> --}}

</div>
