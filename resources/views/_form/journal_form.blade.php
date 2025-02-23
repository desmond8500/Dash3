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
            <input type="text" class="form-control" wire:model="journalForm.type" placeholder="Type de rapport">
            <a class="btn btn-icon" wire:click=""> <i class="ti ti-x"></i> </a>
            <div class="dropdown">
                <a href="#" class="btn dropdown-toggle" data-bs-toggle="dropdown">Select</a>
                <div class="dropdown-menu">
                    <a class="dropdown-item" wire:click="$set('journalForm.type','Rapport d\'intervention')">Rapport d'intervention</a>
                    <a class="dropdown-item" wire:click="$set('journalForm.type','Rapport de travaux')">Rapport de travaux</a>
                    <a class="dropdown-item" wire:click="$set('journalForm.type','Rapport de visite')">Rapport de visite</a>
                </div>
            </div>
        </div>
        @error('journalForm.type') <span class='text-danger'>{{ $message }}</span> @enderror
    </div>

    <div class="col-md-11 mb-3">
        <label class="form-label">Description</label>
        <textarea class="form-control" wire:model="journalForm.description" data-bs-toggle="autosize" placeholder="Description" data-bs-toggle="autosize"></textarea>
        @error('journalForm.description') <span class='text-danger'>{{ $message }}</span> @enderror
    </div>

    <div class="col-md-1">
        <div class="dropdown open">
            <button class="btn btn-action" type="button" id="triggerId" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" >
                <i class="ti ti-chevron-down"></i>
            </button>
            <div class="dropdown-menu" aria-labelledby="triggerId">
                <a class="dropdown-item" wire:click="$set('journalForm.description', '# Intervenants\n- \n- \n \n# Travaux effectués\n\n# Travaux restants\n ')"></i> Contenu 1</a>
                <a class="dropdown-item" wire:click="$set('journalForm.description', '# Intervenants\n- \n- \n \n# Contexte  \n\n# Travaux restants\n ')"></i> Contenu 2</a>
            </div>
        </div>
    </div>





</div>
