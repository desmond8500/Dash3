<div>
    <div class="card-body">
        <h2 class="mb-4">Mon compte</h2>

        <div class="row">
            <div class="col-auto">
                {{-- Avatar --}}
                <h3 class="card-title">Photo</h3>
                <div class="row align-items-center">
                    <div class="col-auto">
                        <label for="file">
                            <img src="{{ asset($user->avatar) }}" class="avatar avatar-xl" for="file" alt="A">
                        </label>
                        <form wire:submit='updateAvatar()' class="col-auto">
                            <input type="file" id="file" accept="image/*" style="display: none;" wire:model='avatar'>
                            <div class="d-flex justify-content-between mt-1">
                                @if ($avatar)
                                <button class="btn btn-primary" > Modifier </button>
                                @else
                                    <button class="btn btn-outline-primary btn-icon" > <i class="ti ti-edit"></i> </button>
                                    <button type="button" class="btn btn-outline-danger btn-icon" > <i class="ti ti-trash"></i> </button>
                                @endif
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-5">
                <h3 class="card-title">Informations</h3>
                <form class="row g-3" wire:submit="nameUpdate()" style="align-items: center">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Prénom</label>
                        <input type="text" class="form-control" wire:model="firstname" placeholder="Prénom">
                        @error('firstname') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Nom</label>
                        <input type="text" class="form-control" wire:model="lastname" placeholder="Nom">
                        @error('lastname') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Nom</label>
                        <input type="text" class="form-control" wire:model="lastname" placeholder="Nom">
                        @error('lastname') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                    <div class="col-auto mb-3">
                        <button class="btn btn-primary" type="submit">Modifier</button>
                    </div>
                </form>

            </div>

            <div class="col-md-5">
                <h3 class="card-title">Email</h3>
                <div>
                    <div class="input-group">
                        <input type="text" class="form-control w-auto" value="paweluna@howstuffworks.com">
                        <button class="btn btn-primary" >Modifier</button>
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
            </div>
        </div>

    </div>
    {{-- Footer --}}
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
