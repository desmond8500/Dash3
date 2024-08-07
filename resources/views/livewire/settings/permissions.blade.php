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

                    </div>
                </div>
                <ul class="list-group">
                    @foreach ($roles as $role)
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            {{ ucfirst($role->name) }}
                            {{-- <span class="badge bg-secondary badge-pill">pill2</span> --}}
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
                        <button class="btn btn-primary" wire:click="">
                            <i class="ti ti-plus"></i> Permission
                        </button>
                    </div>
                </div>
                <ul class="list-group">
                    @foreach ($permissions as $permission)
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            {{ ucfirst($permission->name) }}
                            {{-- <span class="badge bg-secondary badge-pill">pill2</span> --}}
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>

    </div>
    @component('components.modal', ["id"=>'addPermission', 'title' => 'Ajouter un statut'])
    <form class="row" wire:submit="status_store">
        @include('_form.task_status_form')
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
            <button type="submit" class="btn btn-primary">Valider</button>
        </div>
    </form>
    <script> window.addEventListener('open-addPermission', event => { $('#addPermission').modal('show'); }) </script>
    <script> window.addEventListener('close-addPermission', event => { $('#addPermission').modal('hide'); }) </script>
    @endcomponent

    @component('components.modal', ["id"=>'editPermission', 'title' => 'Editer un statut'])
    <form class="row" wire:submit="status_update">
        @include('_form.task_status_form')
        <div class="modal-footer">
            <button type="button" class="btn btn-danger" wire:click='status_delete'> <i class="ti ti-trash"></i> </button>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
            <button type="submit" class="btn btn-primary">Valider</button>
        </div>
    </form>
    <script> window.addEventListener('open-editPermission', event => { $('#editPermission').modal('show'); }) </script>
    <script> window.addEventListener('close-editPermission', event => { $('#editPermission').modal('hide'); }) </script>
    @endcomponent
</div>
