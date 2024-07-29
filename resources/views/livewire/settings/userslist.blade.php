<div class="card-body">
    <div class="row g-2">
        <div class="col-auto">
            <h2>Utilisateurs</h2>
        </div>
        <div class="col mb-3">
            <input type="text" class="form-control" wire:model.live="search" placeholder="Chercher">
        </div>
        <div class="col-auto">
            <button class="btn btn-icon" wire:click='$refresh'><i class="ti ti-reload"></i></button>
        </div>
        <div class="w-100"></div>
        <div class="col-md-5">
            @foreach ($users as $user)
                <div class="card p-2" wire:click="select_user('{{ $user->id }}')">
                    <div class="row">
                        <div class="col-auto">
                            <img src="{{ $user->avatar }}" alt="A" class="avatar">
                        </div>
                        <div class="col">
                            <div class="fw-bold">{{ $user->firstname }} {{ $user->lastname }}</div>
                            <div class="">{{ $user->email }} </div>
                            {{-- <div class="text-muted">Description</div> --}}
                        </div>
                        <div class="col-auto">
                            <button class="btn btn-outline-primary btn-icon">
                                <i class="ti ti-edit"></i>
                            </button>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="col-md-7">
            @if ($selected)
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-auto">
                                <img src="{{ asset($selected->avatar) }}" alt="U" class="avatar ">
                            </div>
                            <div class="col">
                                <div class="fw-bold">{{ $selected->firstname }} {{ $selected->lastname }}</div>
                                <div class="text-muted">{{ $selected->email }} </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="card-title">Roles</div>
                        @foreach ($roles as $role)
                            <div class="card card-sm  p-1 mb-1">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>{{ ucfirst($role->name) }}</div>
                                    @if ($user->hasRole($role->name))
                                        <div class="btn btn-sm rounded btn-danger" wire:click="delete_role('{{ $role->name }}')">Supprimer</div>
                                    @else
                                        <div class="btn btn-sm rounded btn-primary" wire:click="add_role('{{ $role->name }}')">Ajouter</div>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="card-body">
                        <div class="card-title">Permissions</div>
                        @foreach ($permissions as $permission)
                            <div class="card card-sm  p-1 mb-1">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>{{ ucfirst($permission->name) }}</div>
                                    @if ($user->hasPermissionTo($permission->name))
                                    <div class="btn btn-sm rounded btn-danger" wire:click="delete_permission('{{ $permission->name }}')">Supprimer</div>
                                    @else
                                    <div class="btn btn-sm rounded btn-primary" wire:click="add_permission('{{ $permission->name }}')">Ajouter</div>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>

</div>
