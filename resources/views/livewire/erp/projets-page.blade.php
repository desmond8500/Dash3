<div>
    @component('components.layouts.page-header', ['title'=> 'Projets', 'breadcrumbs'=>$breadcrumbs])
    <div class="d-flex">
        <input type="text" class="form-control" wire:model.live="search" placeholder="Rechercher"
            wire:keydown.enter='ProjetSearch'>
        <button class="btn btn-primary ms-1" wire:click="$dispatch('open-addProjet')">
            <i class="ti ti-plus"></i> Projet
        </button>
    </div>
    @endcomponent

    <div class="row g-2">
        @forelse ($projets as $projet)
            <div class="col-md-3">
                <div class="card p-2 ">
                    <div class="row">
                        <a class="col-auto" href="{{ route('projet',['projet_id'=> $projet->id]) }}">
                            <img class="avatar " src="{{ asset($projet->client->avatar) }}" alt="A">
                        </a>
                        <a class="col" href="{{ route('projet',['projet_id'=> $projet->id]) }}">
                            <div class="fw-bold">{{ $projet->name }}</div>
                        </a>
                        <div class="col-auto">
                            <button class="btn btn-primary btn-icon" wire:click="edit('{{ $projet->id }}')">
                                <i class="ti ti-edit"></i>
                            </button>
                        </div>
                        <div class="col-md-12">
                            <div class="text-muted">{{ nl2br($projet->description) }}</div>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            @component('components.no-result')

            @endcomponent
        @endforelse
    </div>

    @component('components.modal', ["id"=>'addProjet', 'title'=> 'Ajouter un projet'])
    <form class="row" wire:submit="store">
        <div class="col-md-3 mb-3">
            <label class="form-label">Client_id</label>
            <input type="text" disabled class="form-control" wire:model="projetForm.client_id"
                placeholder="Nom du projet">
            @error('projetForm.client_id') <span class="text-danger">{{ $message }}</span> @enderror
        </div>
        <div class="col-md-9 mb-3">
            <label class="form-label">Nom</label>
            <input type="text" class="form-control" wire:model="projetForm.name" placeholder="Nom du projet">
            @error('projetForm.name') <span class="text-danger">{{ $message }}</span> @enderror
        </div>
        <div class="col-md-12 mb-3">
            <label class="form-label">Description</label>
            <textarea class="form-control" wire:model="projetForm.description" placeholder="Description du projet"
                cols="30" rows="3"></textarea>
            @error('projetForm.description') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
            <button type="submit" class="btn btn-primary">Valider</button>
        </div>
    </form>
    <script>
        window.addEventListener('open-addProjet', event => { $('#addProjet').modal('show'); })
    </script>
    <script>
        window.addEventListener('close-addProjet', event => { $('#addProjet').modal('hide'); })
    </script>
    @endcomponent

    @component('components.modal', ["id"=>'editProjet', 'title'=> 'Editer un projet'])
    <form class="row" wire:submit="update">
        <div class="col-md-3 mb-3">
            <label class="form-label">Client_id</label>
            <input type="text" disabled class="form-control" wire:model="projetForm.client_id"
                placeholder="Nom du projet">
            @error('projetForm.client_id') <span class="text-danger">{{ $message }}</span> @enderror
        </div>
        <div class="col-md-9 mb-3">
            <label class="form-label">Nom</label>
            <input type="text" class="form-control" wire:model="projetForm.name" placeholder="Nom du projet">
            @error('projetForm.name') <span class="text-danger">{{ $message }}</span> @enderror
        </div>
        <div class="col-md-12 mb-3">
            <label class="form-label">Description</label>
            <textarea class="form-control" wire:model="projetForm.description" placeholder="Description du projet"
                cols="30" rows="3"></textarea>
            @error('projetForm.description') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <div class="modal-footer">
            <button type="button" class="btn btn-danger" wire:click="delete()"><i class="ti ti-trash"></i></button>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
            <button type="submit" class="btn btn-primary">Valider</button>
        </div>
    </form>
    <script>
        window.addEventListener('open-editProjet', event => { $('#editProjet').modal('show'); })
    </script>
    <script>
        window.addEventListener('close-editProjet', event => { $('#editProjet').modal('hide'); })
    </script>
    @endcomponent
</div>
