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
                            {{ ucfirst($role->name) }}
                            <button class="btn btn-danger btn-sm rounded" wire:click="role_delete('{{ $role->id }}')">
                                <i class="ti ti-trash"></i>
                            </button>
                        </li>
                    @endforeach
                </ul>
            </div>
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



    @component('components.modal', ["id"=>'addPermission', 'title' => 'Ajouter une permission'])
        <form class="row" wire:submit="permission_store">
            @include('_form.permission_form')
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                <button type="submit" class="btn btn-primary">Valider</button>
            </div>
        </form>
        <script> window.addEventListener('open-addPermission', event => { $('#addPermission').modal('show'); }) </script>
        <script> window.addEventListener('close-addPermission', event => { $('#addPermission').modal('hide'); }) </script>
    @endcomponent

    <button class='btn btn-primary' wire:click="$dispatch('open-editPermission')" ><i class='ti ti-plus'></i> Editer</button>

    @component('components.modal', ["id"=>'editPermission', 'title' => 'Editer une permission'])
        <form class="row" wire:submit="permission_update">
            @include('_form.permission_form')
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                <button type="submit" class="btn btn-primary">Valider</button>
            </div>
        </form>
        <script> window.addEventListener('open-editPermission', event => { $('#editPermission').modal('show'); }) </script>
        <script> window.addEventListener('close-editPermission', event => { $('#editPermission').modal('hide'); }) </script>
    @endcomponent
</div>
