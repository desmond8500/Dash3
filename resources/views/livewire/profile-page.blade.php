<div>
    @component('components.layouts.page-header', ['title'=> 'Profile'])
        <button class="btn btn-icon" wire:click='$refresh'><i class="ti ti-reload"></i> </button>
    @endcomponent

    <div class="row g-2">
        <div class="col-auto">
            <div class="card p-3">
                <img src="{{ asset($user->avatar) }}" alt="U" class="avatar avatar-xl">
                <input type="file" id="file" accept="image/*" style="display: none;" wire:model='avatar'>
                @if ($avatar)
                    <button class="btn btn-primary w-100 mt-2" wire:click='update_avatar'>Sauvegarder</button>
                @else
                    <label for="file" class="btn btn-primary w-100 mt-2" >
                        Modifier

                        <div wire:loading>
                            <div class="d-flex justify-content-between">
                                <div class="ms-2 spinner-border"></div>
                            </div>
                        </div>
                    </label>
                @endif
            </div>
        </div>

        <div class="col-md-4">

            <div class="card">
                <div class="card-header">
                    <div class="card-title">Informations</div>
                    <div class="card-actions">
                        <button class="btn btn-primary btn-icon" wire:click="edit('{{ $user->id }}')">
                            <i class="ti ti-edit"></i>
                        </button>
                    </div>
                </div>
                <ul class="list-group list-group">
                    <li class="list-group-item">
                        <div class="d-flex-between">
                            <div class="fw-bold">Prénom :</div>
                            <div class="">{{ $user->firstname }}</div>
                        </div>
                    </li>
                    <li class="list-group-item">
                        <div class="d-flex-between">
                            <div class="fw-bold">Nom :</div>
                            <div class="">{{ $user->lastname }}</div>
                        </div>
                    </li>
                    <li class="list-group-item">
                        <div class="d-flex-between">
                            <div class="fw-bold">Email :</div>
                            <div class="">{{ $user->email }}</div>
                        </div>
                    </li>
                    @if ($user->function)
                        <li class="list-group-item">
                            <div class="d-flex-between">
                                <div class="fw-bold">Fonction :</div>
                                <div class="">{{ $user->function }}</div>
                            </div>
                        </li>
                    @endif
                </ul>

                <div class="card-body">
                    <button class="btn btn-primary" wire:click='edit_password'>Modifier le mot de passe</button>
                </div>
            </div>

        </div>

        <div class="col-md-4">
            @livewire('erp.c-v', ['user_id' => $user->id])
        </div>
    </div>

    @component('components.modal', ["id"=>'editUser', 'title' => 'Editer profile', 'method'=>'update'])
        <form class="row" wire:submit="update">
            @include('_form.user_form')
        </form>
        <script> window.addEventListener('open-editUser', event => { window.$('#editUser').modal('show'); }) </script>
        <script> window.addEventListener('close-editUser', event => { window.$('#editUser').modal('hide'); }) </script>
    @endcomponent

    @component('components.modal', ["id"=>'editPassword', 'title' => 'Editer avatar', 'method'=>'update_password'])
        <form class="row" wire:submit="update_password">
            <div class="col-md-12 mb-3">
                <label class="form-label">Mot de passe</label>
                <input type="text" class="form-control" wire:model="user_form.password" placeholder="Mot de passe">
                @error('user_form.password') <span class='text-danger'>{{ $message }}</span> @enderror
            </div>
            <div class="col-md-12 mb-3">
                <label class="form-label">Confirmer Mot de passe</label>
                <input type="text" class="form-control" wire:model="user_form.password_confirmation" placeholder="Mot de passe">
                @error('user_form.password_confirmation') <span class='text-danger'>{{ $message }}</span> @enderror
            </div>
        </form>
        <script> window.addEventListener('open-editPassword', event => { window.$('#editPassword').modal('show'); }) </script>
        <script> window.addEventListener('close-editPassword', event => { window.$('#editPassword').modal('hide'); }) </script>
    @endcomponent
</div>
