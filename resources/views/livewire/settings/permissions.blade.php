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
</div>
