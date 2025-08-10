<div class="col-auto mb-3">
    <div wire:loading wire:target='clientForm.avatar'>
        Chargement <div class="spinner-border" role="status"></div>
    </div>
    @if ($clientForm->avatar)
        @if(is_string($clientForm->avatar))
            <img src="{{ $clientForm->avatar }}" alt="" class="avatar avatar-xl rounded avatar-upload">
        @else
            <img src="{{ $clientForm->avatar->temporaryUrl() }}" alt="" class="avatar avatar-xl rounded avatar-upload">
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
    <input type="file" id="file" accept="image/*" style="display: none" wire:model="clientForm.avatar">
</div>

<div class="w-100"></div>

<div class="col-12 mb-3">
    <label class="form-label">Nom du client</label>
    <input type="text" class="form-control" wire:model='clientForm.name' />
    @error('clientForm.name') <span class="text-danger">{{ $message }}</span> @enderror
</div>

<div class="w-100"></div>

<div class="col-md-4 mb-3">
    <label class="form-label">Type de client</label>
    <select class="form-select" wire:model="clientForm.type">
        <option value="Entreprise">Entreprise</option>
        <option value="Particulier">Particulier</option>
    </select>
</div>

<div class="col-md-8 mb-3">
    <label class="form-label">Adresse</label>
    <input type="text" class="form-control" wire:model="clientForm.address" placeholder="Adresse du client">
</div>

<div class="col-md-12 mb-3">
    <label class="form-label">Description</label>
    <textarea class="form-control" wire:model="clientForm.description" rows="5" placeholder="Description du client" data-bs-toggle="autosize"></textarea>
</div>
@script
    <script>
        autosize(document.querySelector('textarea'));
    </script>
@endscript
