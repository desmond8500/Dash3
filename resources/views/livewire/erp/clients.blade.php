<div>
    @component('components.layouts.page-header', ['title'=> 'Clients', 'breadcrumbs' => $breadcrumbs])
        <div class="d-flex">
            <input type="text" class="form-control" wire:model.live="search" placeholder="Rechercher">

            <button type="button" class="btn btn-primary mx-1" data-bs-toggle="modal" data-bs-target="#addClient">
                <i class="ti ti-plus me-2"></i> Client
            </button>
        </div>
    @endcomponent

    <div class="row row-deck g-2">

        @forelse ($clients as $client)
            <div class="col-md-3">
                <div class="card p-2">
                    <div class="row">
                        <div class="col-auto">
                            <img src="{{ $client->avatar }}" alt="A" class="avatar avatar-md">
                        </div>
                        <div class="col-md">
                            <div class="fw-bold">{{ $client->name }}</div>
                            <div class="text-muted">{{ nl2br($client->description) }}</div>
                            <div class="text-primary">{{ $client->type }}</div>
                        </div>
                        <div class="col-auto">
                            <button class="btn  btn-action" wire:click="edit({{ $client }})">
                                <i class="ti ti-edit"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        @empty

        <div class="empty">
            <div class="empty-icon">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"> <path stroke="none" d="M0 0h24v24H0z" fill="none" /> <circle cx="12" cy="12" r="9" /> <line x1="9" y1="10" x2="9.01" y2="10" /> <line x1="15" y1="10" x2="15.01" y2="10" /> <path d="M9.5 15.25a3.5 3.5 0 0 1 5 0" /> </svg>
            </div>
            <p class="empty-title">Pas de client trouvé</p>
            <p class="empty-subtitle text-secondary">
                Ajoutez de nouveaux clients ou changez de critères de recherche.
            </p>
            <div class="empty-action">
                <button class="btn btn-primary" wire:click='clientSearch()'>
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"> <path stroke="none" d="M0 0h24v24H0z" fill="none" /> <circle cx="10" cy="10" r="7" /> <line x1="21" y1="21" x2="15" y2="15" /> </svg>
                    Rechercher de nouveau
                </button>
            </div>
        </div>

        @endforelse
    </div>

    @component('components.modal', ["id"=>'addClient', 'title'=>'Ajouter un client'])
        <form class="row" wire:submit="store">
            <div class="col-auto mb-3">
                @if ($clientForm->avatar)
                    @if(!is_string($clientForm->avatar))
                        <img src="{{ $clientForm->avatar->temporaryUrl() }}" alt="" class="avatar rounded avatar-upload">
                    @endif
                @else
                    <input type="file" id="file" accept="image/*" style="display: none" wire:model="clientForm.avatar">
                    <label  for="file" href="#" class="avatar avatar-upload rounded">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"> <path stroke="none" d="M0 0h24v24H0z" fill="none" /> <path d="M12 5l0 14" /> <path d="M5 12l14 0" /> </svg>
                        <span class="avatar-upload-text">Add</span>
                    </label>
                @endif
            </div>
            <div class="col mb-3">
                <label class="form-label">Nom du client</label>
                <input type="text" class="form-control" wire:model='clientForm.name' />
                @error('clientForm.name') <span class="text-danger">{{ $message }}</span> @enderror
            </div>
            <div class="w-100"></div>

            <div class="col-md-4 mb-3">
                <label class="form-label">Type de client</label>
                <select class="form-control" wire:model="clientForm.type">
                    <option value="Entreprise">Entreprise</option>
                    <option value="Particulier">Particulier</option>
                </select>
            </div>

            <div class="col-md-8 mb-3">
                <label class="form-label">Adresse</label>
                <input type="text" class="form-control" wire:model="clientForm.address" placeholder="Adresse du client">
            </div>

            <div class="col-md-12 mb-3">
                <label class="form-label">Description</label>
                <textarea class="form-control" wire:model="clientForm.description" placeholder="Description du client" id="" cols="30" rows="3"></textarea>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                <button type="submit" class="btn btn-primary">Valider</button>
            </div>
        </form>
        <script> window.addEventListener('open-addClient', event => { $('#addClient').modal('show'); }) </script>
        <script> window.addEventListener('close-addClient', event => { $('#addClient').modal('hide'); }) </script>
    @endcomponent
    @component('components.modal', ["id"=>'editClient', 'title'=>'Modifier un client'])
        <form class="row" wire:submit="update">
            <div class="col-auto mb-3">
                @if ($clientForm->avatar)
                    @if(!is_string($clientForm->avatar))
                        <img src="{{ $clientForm->avatar->temporaryUrl() }}" alt="A1" class="avatar rounded avatar-upload">
                    @else
                        <img  href="#" src="{{ $clientForm->avatar }}" alt="A" class="avatar rounded avatar-upload">
                        <input type="file" id="file" accept="image/*" style="display: none" wire:model="clientForm.avatar">
                        <label for="file"  class="avatar avatar-upload rounded">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"> <path stroke="none" d="M0 0h24v24H0z" fill="none" /> <path d="M12 5l0 14" /> <path d="M5 12l14 0" /> </svg>
                            <span class="avatar-upload-text">Add</span>
                        </label>
                    @endif
                @else
                    <input type="file" id="file" accept="image/*" style="display: none" wire:model="clientForm.avatar">
                    <label for="file" class="avatar avatar-upload rounded">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2"
                            stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M12 5l0 14" />
                            <path d="M5 12l14 0" />
                        </svg>
                        <span class="avatar-upload-text">Add</span>
                    </label>
                @endif
            </div>
            <div class="col mb-3">
                <label class="form-label">Nom du client</label>
                <input type="text" class="form-control" wire:model='clientForm.name' />
                @error('clientForm.name') <span class="text-danger">{{ $message }}</span> @enderror
            </div>
            <div class="w-100"></div>

            <div class="col-md-4 mb-3">
                <label class="form-label">Type de client</label>
                <select class="form-control" wire:model="clientForm.type">
                    <option value="Entreprise">Entreprise</option>
                    <option value="Particulier">Particulier</option>
                </select>
            </div>

            <div class="col-md-8 mb-3">
                <label class="form-label">Adresse</label>
                <input type="text" class="form-control" wire:model="clientForm.address" placeholder="Adresse du client">
            </div>

            <div class="col-md-12 mb-3">
                <label class="form-label">Description</label>
                <textarea class="form-control" wire:model="clientForm.description" placeholder="Description du client" id="" cols="30" rows="3"></textarea>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-danger" wire:click="delete()">
                    <i class="ti ti-trash"></i>
                </button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                <button type="submit" class="btn btn-primary">Valider</button>
            </div>
        </form>
        <script> window.addEventListener('open-editClient', event => { $('#editClient').modal('show'); }) </script>
        <script> window.addEventListener('close-editClient', event => { $('#editClient').modal('hide'); }) </script>
    @endcomponent

</div>

