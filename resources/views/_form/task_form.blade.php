<div class="row">
   <div class="col mb-3">
       <label class="form-label">Nom de la tache</label>
       <input type="text" class="form-control" wire:model="form.name" placeholder="Nom">
       @error('form.name') <span class='text-danger'>{{ $message }}</span> @enderror
   </div>

   <div class="col-auto md-3">
        <label class="form-label text-white">Favoris</label>
        @if ($form->favoris)
            <button class="btn btn-secondary btn-icon" data-bs-toggle="tooltip" wire:click="toggleFavorite()"
                title="Supprimmer aux favoris">
                <i class="ti ti-heart"></i>
            </button>
        @else
            <button class="btn btn-success btn-icon" data-bs-toggle="tooltip" wire:click="toggleFavorite()"
                title="Ajouter aux favoris">
                <i class="ti ti-heart"></i>
            </button>
        @endif
    </div>

   <div class="w-100"></div>

   <div class="col-6  mb-3">
       <label class="form-label">Status</label>
       <select class="form-control" wire:model="form.statut_id">
           @foreach ($statuses as $status)
                <option value="{{ $status->level }}">{{ $status->name }}</option>
            @endforeach
       </select>
       @error('form.status_id') <span class='text-danger'>{{ $message }}</span> @enderror
   </div>
   <div class="col-6  mb-3">
       <label class="form-label">Priorité</label>
       <select class="form-control" wire:model="form.priority_id">
            @foreach ($priorities as $priority)
                <option value="{{ $priority->level }}">{{ $priority->name }}</option>
            @endforeach
       </select>
       @error('form.priority_id') <span class='text-danger'>{{ $message }}</span> @enderror
   </div>

   <div class="col-md-4 mb-3">
        <label class="form-label">Expiration</label>
        <input type="date" class="form-control" wire:model="form.expiration_date" placeholder="Nom">
        @error('form.expiration_date') <span class='text-danger'>{{ $message }}</span> @enderror
    </div>
   <div class="col-md-4 mb-3">
        <label class="form-label">Début</label>
        <input type="date" class="form-control" wire:model="form.start_date" placeholder="Nom">
        @error('form.start_date') <span class='text-danger'>{{ $message }}</span> @enderror
    </div>
    <div class="col-md-4 mb-3">
        <label class="form-label">Fin</label>
        <input type="date" class="form-control" wire:model="form.end_date" placeholder="Nom">
        @error('form.end_date') <span class='text-danger'>{{ $message }}</span> @enderror
    </div>

    <div class="col-md-12 mb-3">
        <label class="form-label">Description</label>
        <textarea class="form-control" wire:model="form.description" placeholder="Description" data-bs-toggle="autosize"></textarea>
        @error('form.description') <span class='text-danger'>{{ $message }}</span> @enderror
    </div>

   <hr>

   @isset ($clients)
        <div class="col-md-4 mb-3">
            <label class="form-label">Client</label>
            <select class="form-control" wire:model="form.client_id">
                    <option value="">- Select -</option>
                    @foreach ($clients as $client)
                        <option value="{{ $client->id }}">{{ $client->name }}</option>
                    @endforeach
            </select>
            @error('form.client_id') <span class='text-danger'>{{ $message }}</span> @enderror
        </div>
    @endisset
    @isset($projets)
        <div class="col-md-4 mb-3">
            <label class="form-label">Projet</label>
            <select class="form-control" wire:model="form.projet_id">
                    <option value="">- Select -</option>
                    @foreach ($projets as $projet)
                        <option value="{{ $projet->id }}">{{ $projet->name }}</option>
                    @endforeach
            </select>
            @error('form.projet_id') <span class='text-danger'>{{ $message }}</span> @enderror
        </div>
   @endisset

</div>
