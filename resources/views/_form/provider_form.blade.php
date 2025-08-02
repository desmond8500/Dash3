<div class="row">
    <div class="col-auto mb-3">
        <div class="col-auto">
            <div wire:loading>
                Chargement <div class="spinner-border" role="status"></div>
            </div>
                <label href="#" class="avatar avatar-xl avatar-upload rounded" for="file">
                    @if ($provider_form->logo)
                        @if (is_string($provider_form->logo))
                            <img src="{{ asset($provider_form->logo) }}" class="avatar avatar-xl">
                        @else
                            <img src="{{ $provider_form->logo->temporaryUrl() }}" class="avatar avatar-xl">
                        @endif
                    @else
                    <i class="ti ti-plus"></i>
                @endif
                <span class="avatar-upload-text">Ajouter</span>
                <input type="file" style="display: none" id="file" accept="image/*" wire:model="provider_form.logo">
            </label>
        </div>
    </div>

    <div class="col mb-3">
        <label class="form-label required">Nom du fournisseur</label>
        <input type="text" class="form-control" wire:model="provider_form.name" placeholder="Nom">
        @error('provider_form.name') <span class='text-danger'>{{ $message }}</span> @enderror
    </div>

    <div class="col-md-12 mb-3">
        <label class="form-label">Description</label>
        <textarea class="form-control" wire:model="provider_form.description" placeholder="Description" data-bs-toggle="autosize"></textarea>
        @error('provider_form.description') <span class='text-danger'>{{ $message }}</span> @enderror
    </div>
</div>

