<div class="row">
    <div class="col mb-3">
        <label class="form-label">Client</label>
        <input type="text" class="form-control" wire:model="pv_form.client" placeholder="Nom du client">
        @error('pv_form.client') <span class='text-danger'>{{ $message }}</span> @enderror
    </div>

    <div class="col-auto">
        <div wire:loading>
            Chargement <div class="spinner-border" role="status"></div>
        </div>
        <label href="#" class="avatar avatar-upload rounded" for="file">
            @if ($pv_form->client_logo)
                @if (is_string($pv_form->client_logo))
                    <img src="{{ asset($pv_form->client_logo) }}" class="avatar">
                @else
                    <img src="{{ $pv_form->client_logo->temporaryUrl() }}" class="avatar">
                @endif
            @else
                <i class="ti ti-plus"></i>
            @endif
            <span class="avatar-upload-text">Ajouter</span>
            <input type="file" style="display: none" id="file" accept="image/*" wire:model.defer="pv_form.client_logo">
        </label>
    </div>
    <div class="w-100"></div>

    <div class="col mb-3">
        <label class="form-label">Bureau de controle technique</label>
        <input type="text" class="form-control" wire:model="pv_form.bct" placeholder="Bureau de controle technique">
        @error('pv_form.bct') <span class='text-danger'>{{ $message }}</span> @enderror
    </div>

    <div class="col-auto">
        <div wire:loading>
            Chargement <div class="spinner-border" role="status"></div>
        </div>
        <label href="#" class="avatar avatar-upload rounded" for="file">
            @if ($pv_form->bct_logo)
                @if (is_string($pv_form->bct_logo))
                    <img src="{{ asset($pv_form->bct_logo) }}" class="avatar">
                @else
                    <img src="{{ $pv_form->bct_logo->temporaryUrl() }}" class="avatar">
                @endif
            @else
                <i class="ti ti-plus"></i>
            @endif
            <span class="avatar-upload-text">Ajouter</span>
            <input type="file" style="display: none" id="file" accept="image/*" wire:model.defer="pv_form.bct_logo">
        </label>
    </div>
    <div class="w-100"></div>

    <div class="col mb-3">
        <label class="form-label">Maitre d'ouvrage</label>
        <input type="text" class="form-control" wire:model="pv_form.mo" placeholder="Nom du mo">
        @error('pv_form.mo') <span class='text-danger'>{{ $message }}</span> @enderror
    </div>

    <div class="col-auto">
        <div wire:loading>
            Chargement <div class="spinner-border" role="status"></div>
        </div>
        <label href="#" class="avatar avatar-upload rounded" for="file">
            @if ($pv_form->mo_logo)
                @if (is_string($pv_form->mo_logo))
                    <img src="{{ asset($pv_form->mo_logo) }}" class="avatar">
                @else
                    <img src="{{ $pv_form->mo_logo->temporaryUrl() }}" class="avatar">
                @endif
            @else
                <i class="ti ti-plus"></i>
            @endif
            <span class="avatar-upload-text">Ajouter</span>
            <input type="file" style="display: none" id="file" accept="image/*" wire:model.defer="pv_form.mo_logo">
        </label>
    </div>
    <div class="w-100"></div>

    <div class="col mb-3">
        <label class="form-label">Client</label>
        <input type="text" class="form-control" wire:model="pv_form.client" placeholder="Nom du client">
        @error('pv_form.client') <span class='text-danger'>{{ $message }}</span> @enderror
    </div>

    <div class="col-auto">
        <div wire:loading>
            Chargement <div class="spinner-border" role="status"></div>
        </div>
        <label href="#" class="avatar avatar-upload rounded" for="file">
            @if ($pv_form->client_logo)
                @if (is_string($pv_form->client_logo))
                    <img src="{{ asset($pv_form->client_logo) }}" class="avatar">
                @else
                    <img src="{{ $pv_form->client_logo->temporaryUrl() }}" class="avatar">
                @endif
            @else
                <i class="ti ti-plus"></i>
            @endif
            <span class="avatar-upload-text">Ajouter</span>
            <input type="file" style="display: none" id="file" accept="image/*" wire:model.defer="pv_form.client_logo">
        </label>
    </div>
    <div class="w-100"></div>


</div>
