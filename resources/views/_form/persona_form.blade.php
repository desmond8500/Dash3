    <div class="col-auto mb-3">
        <div wire:loading wire:target='form.avatar'>
            Chargement <div class="spinner-border" role="status"></div>
        </div>
        @if ($form->avatar)
            @if(is_string($form->avatar))
                <img src="{{ $form->avatar }}" alt="" class="avatar avatar-xl rounded avatar-upload">
            @else
                <img src="{{ $form->avatar->temporaryUrl() }}" alt="" class="avatar avatar-xl rounded avatar-upload">
            @endif
            <label for="file" href="#" class="avatar avatar-xl avatar-upload rounded">
                <i class="ti ti-edit text-muted"></i>
                <span class="avatar-upload-text">Modifier</span>
            </label>
        @else
            <label for="file" href="#" class="avatar avatar-xl avatar-upload rounded">
                <i class="ti ti-plus text-muted"></i>
                <span class="avatar-upload-text">Ajouter</span>
            </label>
        @endif
        <input type="file" id="file" accept="image/*" style="display: none" wire:model="form.avatar">
        <div wire:loading>
            <div class="d-flex justify-content-between">
                <div>Chargement <span class="animated-dots"></div>
            </div>
        </div>
        @error('form.avatar') <span class='text-danger'>{{ $message }}</span> @enderror
    </div>
    <div class="col">
        <div class="row g-2">
            <div class="col-md-12 mb-3">
                <label class="form-label">Prénom</label>
                <input type="text" class="form-control" wire:model="form.firstname" placeholder="Prénom">
                @error('form.firstname') <span class='text-danger'>{{ $message }}</span> @enderror
            </div>
            <div class="col-md-12 mb-3">
                <label class="form-label">Nom</label>
                <input type="text" class="form-control" wire:model="form.lastname" placeholder="Nom">
                @error('form.lastname') <span class='text-danger'>{{ $message }}</span> @enderror
            </div>
        </div>
    </div>
    <div class="col-md-12 mb-3">
        <label class="form-label">Description</label>
        <textarea class="form-control" wire:model="form.description" placeholder="Description" cols="30" rows="5"></textarea>
        @error('form.description') <span class='text-danger'>{{ $message }}</span> @enderror
    </div>
