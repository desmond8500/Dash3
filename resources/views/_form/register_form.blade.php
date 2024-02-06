<div class="col-md-6 mb-3">
    <label class="form-label">Prénom</label>
    <input type="text" class="form-control" wire:model="user_form.firstname" placeholder="Prénom">
    @error('user_form.firstname') <span class="text-danger">{{ $message }}</span> @enderror
</div>
<div class="col-md-6 mb-3">
    <label class="form-label">Nom</label>
    <input type="text" class="form-control" wire:model="user_form.lastname" placeholder="Nom">
    @error('user_form.lastname') <span class="text-danger">{{ $message }}</span> @enderror
</div>
<div class="col-md-12 mb-3">
    <label class="form-label">Email</label>
    <input type="text" class="form-control" wire:model="user_form.email" placeholder="Email">
    @error('user_form.email') <span class="text-danger">{{ $message }}</span> @enderror
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
