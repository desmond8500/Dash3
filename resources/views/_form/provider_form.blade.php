<div class="row">
    <div class="col-auto mb-3">
        <div class="col-auto">
            <div wire:loading>
                Chargement <div class="spinner-border" role="status"></div>
            </div>
                <label href="#" class="avatar avatar-xl avatar-upload rounded" for="file">
                    @if ($provider_form->logo)
                        @if (is_string($provider_form->logo))
                            <img src="{{ asset($provider_form->logo) }}" class="avatar avatar-lg">
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
        <textarea class="form-control" wire:model="provider_form.description" placeholder="Description"
            data-bs-toggle="autosize"></textarea>
        @error('provider_form.description') <span class='text-danger'>{{ $message }}</span> @enderror
    </div>

    <div class="col-sm-6 col-xs-12 mb-3">
        <label class="required form-label ">Adresse</label>
        <input type="text" class="form-control" wire:model="provider_form.address" placeholder="Nom">
        @error('provider_form.address') <span class='text-danger'>{{ $message }}</span> @enderror
    </div>
    <div class="col-sm-6 col-xs-12 mb-3">
        <label class="form-label required">Email</label>
        <input type="email" class="form-control" wire:model="provider_form.email" placeholder="Nom">
        @error('provider_form.email') <span class='text-danger'>{{ $message }}</span> @enderror
    </div>
    <div class="col-sm-6 col-xs-12 mb-3">
        <label class="form-label required">Téléphone</label>
        <input type="tel" class="form-control" wire:model="provider_form.phone" placeholder="Nom">
        @error('provider_form.phone') <span class='text-danger'>{{ $message }}</span> @enderror
    </div>
    <div class="col-sm-6 col-xs-12 mb-3">
        <label class="form-label required">Site Web</label>
        <input type="url" class="form-control" wire:model="provider_form.website" placeholder="Nom">
        @error('provider_form.website') <span class='text-danger'>{{ $message }}</span> @enderror
    </div>


</div>

