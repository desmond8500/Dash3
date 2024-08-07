<div class="p-3">
    <div class="d-flex justify-content-between">
        <h2>Permissions et Roles</h2>
        <button class="btn btn-icon" wire:click='$refresh'><i class="ti ti-reload"></i> </button>
    </div>
    <div class="row g-2 mt-3">

        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">Roles</div>
                    <div class="card-actions">
                        <a class='btn btn-primary' wire:click="$toggle('form_role')">
                            <i class='ti ti-plus'></i> Role
                        </a>
                    </div>
                </div>
                @if ($form_role)
                    <div class="card-body">
                        <form class="row" wire:submit="role_store">
                            <div class="input-group">
                                @include('_form.role_form')
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                                <button type="submit" class="btn btn-primary">Valider</button>
                            </div>
                        </form>
                    </div>
                @endif
                <ul class="list-group">
                    @foreach ($roles as $role)
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <div wire:click="select_role('{{ $role->id }}')">{{ ucfirst($role->name) }}</div>
                            <button class="btn btn-danger btn-sm rounded" wire:click="role_delete('{{ $role->id }}')">
                                <i class="ti ti-trash"></i>
                            </button>
                        </li>
                    @endforeach
                </ul>
            </div>

            @if ($selected_role)
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">Permission Role</div>
                        <div class="card-actions">

                        </div>
                    </div>
                    <div class="card-body">
                        @foreach ($permissions as $permission)
                            @php
                                $green = 0;
                            @endphp
                            @foreach ($selected_role->getAllPermissions() as $perm)
                                @php
                                    if ($perm->name == $permission->name) {
                                        $green =1;
                                    }
                                @endphp
                            @endforeach
                            @if ($green)
                                <button class="border bg-green text-white p-1 mb-1 rounded cursor-pointer" wire:click="assign_role('{{ $permission->name }}')">
                                    {{ $permission->name }}
                                </button>
                            @else
                                <button class="border bg-red text-white p-1 mb-1 rounded cursor-pointer" wire:click="revoke_role('{{ $permission->name }}')">
                                    {{ $permission->name }}
                                </button>
                            @endif

                        @endforeach

                    </div>
                    <div class="card-footer">

                    </div>
                </div>
            @endif
        </div>

        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">Permisions</div>
                    <div class="card-actions">
                        <a class='btn btn-primary' wire:click="$toggle('form_permission')">
                            <i class='ti ti-plus'></i> Permission
                        </a>
                    </div>
                </div>
                @if ($form_permission)
                    <div class="card-body">
                        <form class="row" wire:submit="permission_store">
                            <div class="input-group">
                            @include('_form.permission_form')
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                                <button type="submit" class="btn btn-primary">Valider</button>
                            </div>
                        </form>
                    </div>
                @endif
                <ul class="list-group">
                    @foreach ($permissions as $permission)
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            {{ ucfirst($permission->name) }}
                            <div>
                                <button class="btn btn-danger btn-sm rounded" wire:click="permission_delete('{{ $permission->id }}')">
                                    <i class="ti ti-trash"></i>
                                </button>
                                {{-- <button class="btn btn-primary btn-sm rounded" wire:click="permission_edit('{{ $permission->id }}')">
                                    <i class="ti ti-edit"></i>
                                </button> --}}
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>

    </div>
</div>
