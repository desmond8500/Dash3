<div>
    <div class="card-body">
        <h2 class="mb-4">Mon compte</h2>

        <div class="row">
            <div class="col-auto">
                {{-- Avatar --}}
                <h3 class="card-title">Details du profil</h3>
                <div class="row align-items-center">
                    <div class="col-auto">
                        <label for="file">
                            <img src="{{ asset($user->avatar) }}" class="avatar avatar-xl" for="file" alt="A">
                        </label>
                        <form wire:submit='updateAvatar()' class="col-auto">
                            <input type="file" id="file" accept="image/*" style="display: none;" wire:model='avatar'>
                            <div class="d-flex justify-content-evenly mt-1">
                                @if ($avatar)
                                <button class="btn btn-primary" > Modifier </button>
                                @else
                                    <button class="btn btn-outline-primary btn-icon" >
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-edit" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"> <path stroke="none" d="M0 0h24v24H0z" fill="none"></path> <path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1"></path> <path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z"></path> <path d="M16 5l3 3"></path> </svg>
                                    </button>
                                    <button type="button" class="btn btn-outline-danger btn-icon" >
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-trash" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"> <path stroke="none" d="M0 0h24v24H0z" fill="none"></path> <path d="M4 7l16 0"></path> <path d="M10 11l0 6"></path> <path d="M14 11l0 6"></path> <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12"></path> <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3"></path> </svg>
                                    </button>
                                @endif
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-5">
                <h3 class="card-title">Business Profile</h3>
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
