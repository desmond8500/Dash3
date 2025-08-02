<div class="col-auto mb-3">
    <div wire:loading wire:target='brand_form.logo'>
        Chargement <div class="spinner-border" role="status"></div>
    </div>
        @if ($brand_form->logo)
            @if(is_string($brand_form->logo))
                <img src="{{ asset($brand_form->logo) }}" alt="" class="avatar avatar-xl rounded avatar-upload p-1">
            @else
                <img src="{{ $brand_form->logo->temporaryUrl() }}" alt="" class="avatar avatar-xl rounded avatar-upload p-1">
            @endif
            {{-- <label for="file" href="#" class="avatar avatar-upload rounded">
                <i class="ti ti-edit text-muted"></i>
                <span class="avatar-upload-text">Modifier</span>
            </label>
            <input type="file" id="file" accept="image/*" style="display: none" wire:model.live="brand_form.logo2"> --}}
        @else
            <label for="file" href="#" class="avatar avatar-xl avatar-upload rounded">
                <i class="ti ti-plus text-muted"></i>
                <span class="avatar-upload-text">Ajouter</span>
            </label>

            <input type="file" id="file" accept="image/*" style="display: none" wire:model.live="brand_form.logo">
        @endif
</div>

<div class="col mb-3">
    <label class="form-label required">Nom </label>
    <input type="text" class="form-control" wire:model='brand_form.name' />
    @error('brand_form.name') <span class="text-danger">{{ $message }}</span> @enderror
</div>

<div class="col-md-12 mb-3">
    <label class="form-label">Description</label>
    <textarea class="form-control" wire:model="brand_form.description" data-bs-toggle="autosize" placeholder="Description du client" id="" cols="30" rows="3"></textarea>
</div>
