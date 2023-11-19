<div>
    <div class="card-body">
        <h2 class="mb-4">Mon compte</h2>

        {{-- Avatar --}}
        <h3 class="card-title">Details du profil</h3>
        <div class="row align-items-center">
            <div class="col-auto">
                <img src="{{ asset($user->avatar) }}" class="avatar avatar-xl" alt="A">
            </div>
            <form wire:submit='updateAvatar()' class="col-auto">
                <input type="file" id="file" accept="image/*" style="display: none;" wire:model='avatar'>
                <label for="file" class="btn"> Choisir un avatar </label>
                <button class="btn btn-primary" >Modifier</button>
            </form>
            <div class="col-auto"><a href="#" class="btn btn-ghost-danger">
                    Delete avatar
                </a></div>
        </div>

        {{-- User infos --}}
        <h3 class="card-title mt-4">Business Profile</h3>
        <form class="row g-3" wire:submit="nameUpdate()" style="align-items: center">
            <div class="col-md-4 mb-3">
                <label class="form-label">Prénom</label>
                <input type="text" class="form-control" wire:model="firstname" placeholder="Prénom">
                @error('firstname') <span class="text-danger">{{ $message }}</span> @enderror
            </div>
            <div class="col-md-4 mb-3">
                <label class="form-label">Nom</label>
                <input type="text" class="form-control" wire:model="lastname" placeholder="Nom">
                @error('lastname') <span class="text-danger">{{ $message }}</span> @enderror
            </div>
            <div class="col-md-2 mb-3">
                <button class="btn btn-primary" type="submit">Modifier</button>
            </div>
        </form>

        <h3 class="card-title mt-4">Email</h3>
        <p class="card-subtitle">This contact will be shown to others publicly, so choose it
            carefully.</p>
        <div>
            <div class="row g-2">
                <div class="col-auto">
                    <input type="text" class="form-control w-auto" value="paweluna@howstuffworks.com">
                </div>
                <div class="col-auto"><a href="#" class="btn">
                        Change
                    </a></div>
            </div>
        </div>
        <h3 class="card-title mt-4">Password</h3>
        <p class="card-subtitle">You can set a permanent password if you don't want to use temporary
            login codes.</p>
        <div>
            <a href="#" class="btn">
                Set new password
            </a>
        </div>
        <h3 class="card-title mt-4">Public profile</h3>
        <p class="card-subtitle">Making your profile public means that anyone on the Dashkit network
            will be able to find
            you.</p>
        <div>
            <label class="form-check form-switch form-switch-lg">
                <input class="form-check-input" type="checkbox">
                <span class="form-check-label form-check-label-on">You're currently visible</span>
                <span class="form-check-label form-check-label-off">You're
                    currently invisible</span>
            </label>
        </div>
    </div>
    <div class="card-footer bg-transparent mt-auto">
        <div class="btn-list justify-content-end">
            <a href="#" class="btn">
                Cancel
            </a>
            <a href="#" class="btn btn-primary">
                Submit
            </a>
        </div>
    </div>
</div>
