<div class="bg-blue mx-auto" style=" border-radius: 25px; width: 50px; height: 50px; color: white; ">
    <i class="ti ti-user" style=" display: block; padding: 10px; font-size: 30px; "> </i>
</div>

<form wire:submit="login">

    <div class=" mb-3">
        <label class="form-label">Email</label>
        <input type="text" class="form-control" wire:model="email" placeholder="Email">
        @error('email') <span class="text-danger">{{ $message }}</span> @enderror
    </div>

    <div class=" mb-3">
        <label class="form-label">Mot de passe</label>
        <div class="input-group input-group-flat">
            <input type="{{ $formtype ? 'password' : " text" }}" class="form-control" wire:model="password" placeholder="Mot de passe">
            <span class="input-group-text">
                <span type='button' class="input-group-link" title="Afficher le mot de passe" wire:click="$toggle('formtype')">
                    @if ($formtype)
                        <i class="ti ti-eye"></i>
                    @else
                        <i class="ti ti-eye-off"></i>
                    @endif
                </span>
            </span>
        </div>
        @error('password') <span class="text-danger">{{ $message }}</span> @enderror
    </div>

    <div class="col-md-12 text-danger">
        {{ $errorMessage }}
    </div>

    <div class="d-flex justify-content-evenly">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
        <button type="submit" class="btn btn-primary">Valider</button>
    </div>

</form>
