<div class="row">

    {{-- @isset($clients)
        <div class="col-md-4 mb-3">
            <label class="form-label">Client </label>
            <select class="form-control" wire:model="journalForm.client_id">
                @foreach ($clients as $client)
                    <option value="{{ $client->id }}">{{ $client->name }}</option>
                @endforeach
            </select>
            @error('journalForm.client_id') <span class='text-danger'>{{ $message }}</span> @enderror
        </div>
    @endisset --}}

    <div class="w-100"></div>

    <div class="col-md-8 mb-3">
        <label class="form-label">Titre</label>
        <input type="text" class="form-control" wire:model="journalForm.title" placeholder="Titre">
        @error('journalForm.title') <span class='text-danger'>{{ $message }}</span> @enderror
    </div>

    <div class="col-md-4 mb-3">
        <label class="form-label">Date</label>
        <input type="date" class="form-control" wire:model="journalForm.date" placeholder="Date">
        @error('journalForm.date') <span class='text-danger'>{{ $message }}</span> @enderror
    </div>

    <div class="col-md-12 mb-3">
        <label class="form-label">Type</label>
        <div class="input-group">
            <input type="text" class="form-control" list="datalistTypes" wire:model="journalForm.type" placeholder="Type de rapport">
            <a class="btn btn-icon" wire:click=""> <i class="ti ti-x"></i> </a>
            <datalist id="datalistTypes">
                <option value="Rapport d'intervention" />
                <option value="Rapport de travaux" />
                <option value="Rapport de visite" />
                <option value="Rapport d'incident" />
            </datalist>
            {{-- <div class="dropdown">
                <a href="#" class="btn dropdown-toggle" data-bs-toggle="dropdown">Select</a>
                <div class="dropdown-menu">
                    <a class="dropdown-item" wire:click="$set('journalForm.type','Rapport d\'intervention')">Rapport d'intervention</a>
                    <a class="dropdown-item" wire:click="$set('journalForm.type','Rapport de travaux')">Rapport de travaux</a>
                    <a class="dropdown-item" wire:click="$set('journalForm.type','Rapport de visite')">Rapport de visite</a>
                    <a class="dropdown-item" wire:click="$set('journalForm.type','Rapport d'\incident')">Rapport d'incident</a>
                </div>
            </div> --}}
        </div>
        @error('journalForm.type') <span class='text-danger'>{{ $message }}</span> @enderror
    </div>

    <div class="col-md-5 mb-3">
        <label class="form-label">Projet</label>
        <select class="form-select" wire:model="journalForm.projet_id">
            @foreach ($projets as $projet)
                <option value="{{ $projet->id }}">{{ $projet->name }}</option>
            @endforeach
        </select>
        @error('journalForm.projet_id') <span class='text-danger'>{{ $message }}</span> @enderror
    </div>

    <div class="col-md-12 mb-3">
        <label class="form-label">
            <div class="d-flex justify-content-between align-items-center">
                <div>Description</div>
                <div class="dropdown open">
                    <button class="btn btn-action" type="button" id="triggerId" data-bs-toggle="dropdown" aria-haspopup="true"
                        aria-expanded="false">
                        <i class="ti ti-chevron-down"></i>
                    </button>
                    <div class="dropdown-menu" aria-labelledby="triggerId">
                        <a class="dropdown-item" wire:click="$set('journalForm.description', '# Intervenants\n- \n- \n \n# Objet \n\n# Travaux effectués\n\n# Travaux restants\n ')"></i> Rapport 1</a>
                        <a class="dropdown-item"
                            wire:click="$set('journalForm.description', '# Intervenants\n- \n- \n- \n- \n \n# Objet  \n\n# Points retenus \n \n- \n- \n-  ')"></i>
                            Réunion 1</a>
                    </div>
                </div>
            </div>


        </label>
        <textarea class="form-control" wire:model="journalForm.description" data-bs-toggle="autosize" placeholder="Description" data-bs-toggle="autosize"></textarea>
        @error('journalForm.description') <span class='text-danger'>{{ $message }}</span> @enderror
    </div>

</div>
