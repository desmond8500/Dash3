<div class="col-md-2 mb-3">
    <div wire:loading wire:target='clientForm.avatar'>
        Chargement <div class="spinner-border" role="status"></div>
    </div>
    @if ($user_form->avatar)
        @if(is_string($user_form->avatar))
            <img src="{{ $user_form->avatar }}" alt="" class="avatar rounded avatar-upload">
        @else
            <img src="{{ $user_form->avatar->temporaryUrl() }}" alt="" class="avatar rounded avatar-upload">
        @endif
        <label for="file" href="#" class="avatar avatar-upload rounded">
            <i class="ti ti-edit text-muted"></i>
            <span class="avatar-upload-text">Modifier</span>
        </label>
    @else
        <label for="file" href="#" class="avatar avatar-upload rounded">
            <i class="ti ti-plus text-muted"></i>
            <span class="avatar-upload-text">Ajouter</span>
        </label>
    @endif
    <input type="file" id="file" accept="image/*" style="display: none" wire:model="user_form.avatar">
</div>

<div class="col-md-5 mb-3">
    <label class="form-label">Prénom</label>
    <input type="text" class="form-control" wire:model="user_form.firstname" placeholder="Prénom">
    @error('user_form.firstname') <span class="text-danger">{{ $message }}</span> @enderror
</div>
<div class="col-md-5 mb-3">
    <label class="form-label">Nom</label>
    <input type="text" class="form-control" wire:model="user_form.lastname" placeholder="Nom">
    @error('user_form.lastname') <span class="text-danger">{{ $message }}</span> @enderror
</div>
<div class="col-md-6 mb-3">
    <label class="form-label">Email</label>
    <input type="email" class="form-control" wire:model="user_form.email" placeholder="Email">
    @error('user_form.email') <span class="text-danger">{{ $message }}</span> @enderror
</div>
<div class="col-md-6 mb-3">
    <label class="form-label">Fonction</label>
    <input type="text" class="form-control" wire:model="user_form.function" placeholder="Fonction / job">
    @error('user_form.function') <span class="text-danger">{{ $message }}</span> @enderror
</div>
<div class="col-md-6 mb-3">
    <label class="form-label">Mot de passe</label>
    <div class="input-group input-group-flat">
        <input type="{{ $formtype ? 'password' : " text" }}" class="form-control" wire:model="user_form.password"
            placeholder="Mot de passe">
        <span class="input-group-text">
            <a href="#" class="input-group-link" title="Afficher le mot de passe" wire:click="$toggle('formtype')">
                @if ($formtype)
                    <i class="ti ti-eye"></i>
                @else
                    <i class="ti ti-eye-off"></i>
                @endif
            </a>
        </span>
    </div>
    @error('user_form.password') <span class="text-danger">{{ $message }}</span> @enderror
</div>
<div class="col-md-6 mb-3">
    <label class="form-label">Confirmation de mot de passe</label>
    <div class="input-group input-group-flat">
        <input type="{{ $formtype ? 'password' : " text" }}" class="form-control"
            wire:model="user_form.password_confirmation" placeholder="Confirmation de mot de passe">
        <span class="input-group-text">
            <a href="#" class="input-group-link" title="Afficher le mot de passe" wire:click="$toggle('formtype')">
                @if ($formtype)
                    <i class="ti ti-eye"></i>
                @else
                    <i class="ti ti-eye-off"></i>
                @endif
            </a>
        </span>
    </div>
    @error('user_form.password_confirmation') <span class="text-danger">{{ $message }}</span> @enderror
</div>
