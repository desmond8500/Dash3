<div>
    @component('components.layouts.page-header', ['title'=>'Equipe', 'breadcrumbs'=>$breadcrumbs])
        <button class='btn btn-primary' wire:click="$dispatch('open-addTeam')"><i class='ti ti-plus'></i> Membre</button>
    @endcomponent

    <div class="row g-2">
        <div class="col-md-12">
            <div class="input-icon">
                <input type="text" class="form-control form-control-rounded" wire:model.live="search" placeholder="Chercher">
                <span class="input-icon-addon">
                    <i class="ti ti-search"></i>
                </span>
            </div>
        </div>
        @foreach ($equipe->sortBy('lastname') as $personne)
            <div class="col-md-4">
                <div class="card p-2">
                    <div class="row">
                        <div class="col-auto">
                            <img src="" alt="A" class="avatar avatar-md">
                        </div>
                        <div class="col">
                            <div class="fw-bold">
                                <div>{{ $personne->firstname }}</div>
                                <div>{{ $personne->lastname }}</div>
                            </div>
                            <div class="text-muted">{{ $personne->function }}</div>
                        </div>
                        <div class="col-auto">
                        <button class="btn btn-outline-primary btn-icon" wire:click="edit('{{ $personne->id }}')">
                            <i class="ti ti-edit"></i>
                        </button>
                        <button class="btn btn-outline-danger btn-icon" wire:click="delete('{{ $personne->id }}')">
                            <i class="ti ti-trash"></i>
                        </button>
                    </div>
                    </div>
                </div>
            </div>
        @endforeach
        <div class="col-md-12">
            {{ $equipe->links() }}
        </div>
    </div>

    @component('components.modal', ["id"=>'addTeam', 'title' => 'Ajouter un membre'])
        <form class="row" wire:submit="store">
            @include('_form.team_form')
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                <button type="submit" class="btn btn-primary">Valider</button>
            </div>
        </form>
        <script> window.addEventListener('open-addTeam', event => { $('#addTeam').modal('show'); }) </script>
        <script> window.addEventListener('close-addTeam', event => { $('#addTeam').modal('hide'); }) </script>
    @endcomponent
    @component('components.modal', ["id"=>'editTeam', 'title' => 'Editer un membre'])
        <form class="row" wire:submit="update">
            @include('_form.team_form')
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                <button type="submit" class="btn btn-primary">Valider</button>
            </div>
        </form>
        <script> window.addEventListener('open-editTeam', event => { $('#editTeam').modal('show'); }) </script>
        <script> window.addEventListener('close-editTeam', event => { $('#editTeam').modal('hide'); }) </script>
    @endcomponent
</div>
