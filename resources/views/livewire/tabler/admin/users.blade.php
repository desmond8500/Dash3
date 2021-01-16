<div>
    @section('page-title')
        Utilisateurs
    @endsection
    @section('page-action')

    @endsection
    @section('breadcrumb')
        {{-- <li class="breadcrumb-item"><a href="{{ route('tabler.erp.clients') }}">Clients</a></li> --}}
        <li class="breadcrumb-item">Administration</li>
        <li class="breadcrumb-item active">Utilisateurs</li>
    @endsection

    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="table-responsive">
                    <table class="table table-vcenter">
                        <thead>
                            <tr>
                                <th>Nom</th>
                                <th>Statut</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th class="w-1"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                                <tr>
                                    <td>{{ $user->name }}</td>
                                    <td class="text-muted">{{ ucfirst($user->statut) }}</td>
                                    <td class="text-muted" >{{ $user->email }}</td>
                                    <td class="text-muted" >{{ ucfirst($user->role) }}</td>
                                    <td>
                                        <button class="btn btn-outline-primary" wire:click="edit_user('{{ $user->id }}')">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M9 7h-3a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-3" /><path d="M9 15h3l8.5 -8.5a1.5 1.5 0 0 0 -3 -3l-8.5 8.5v3" /><line x1="16" y1="5" x2="19" y2="8" /></svg>
                                        </button>
                                        <button class="btn btn-outline-danger" href="#">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><line x1="4" y1="7" x2="20" y2="7" /><line x1="10" y1="11" x2="10" y2="17" /><line x1="14" y1="11" x2="14" y2="17" /><path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" /><path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" /></svg>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card card-body">

                <div class="mb-3">
                    <label class="form-label">Pseudo</label>
                    <input type="text" wire:model="user_name" class="form-control" placeholder="Pseudo">
                </div>

                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="text" wire:model="user_email" class="form-control" placeholder="Email">
                </div>

                <div class="mb-3">
                    <label class="form-label">Role</label>
                    <select wire:model="user_role" class="form-select">
                        <option value="user">User</option>
                        <option value="admin">Admin</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Statut</label>
                    <select wire:model="user_statut" class="form-select">
                        <option value="actif">Actif</option>
                        <option value="inactif">Inactif</option>
                    </select>
                </div>

                <div class="mb-3">
                    <button class="btn btn-primary" wire:click="update_user('{{ $user->id }}')">Modifier</button>
                </div>

            </div>
        </div>
    </div>
</div>
