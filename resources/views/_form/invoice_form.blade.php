<div class="row">
    <div class="col-md-8 mb-3">
        <label class="form-label">Client</label>
        <input type="text" class="form-control" wire:model="client_name" placeholder="Nom du client">
        @error('client_name') <span class='text-danger'>{{ $message }}</span> @enderror
    </div>

    <div class="col-md-4 mb-3">
        <label class="form-label">Statut</label>
        <select wire:model.live="statut" class="form-control">
            <option value="Proforma">Proforma</option>
            <option value="Nouveau">Nouveau</option>
            <option value="En Cours">En Cours</option>
            <option value="En Cours">En Cours</option>
            <option value="En Pause">En Pause</option>
            <option value="Annulé">Annulé</option>
            <option value="Terminé">Terminé</option>
        </select>
        @error('statut') <span class='text-danger'>{{ $message }}</span> @enderror
        {{ $statut }}
    </div>

    <div class="col-md-8 mb-3">
        <label class="form-label">Nom du projet</label>
        <input type="text" class="form-control" wire:model="projet_name" placeholder="Nom du projet">
        @error('projet_name') <span class='text-danger'>{{ $message }}</span> @enderror
    </div>

    <div class="col-md-4 mb-3">
        <label class="form-label">Reference</label>
        <input type="text" class="form-control" wire:model="reference" disabled>
        @error('reference') <span class='text-danger'>{{ $message }}</span> @enderror
    </div>

    <div class="col-md-8 mb-3">
        <label class="form-label">Description</label>
        <textarea class="form-control" wire:model="description" placeholder="Description du devis" cols="30" rows="3"></textarea>
        @error('description') <span class="text-danger">{{ $message }}</span> @enderror
        {{ $description }}
    </div>

    <div class="col-md-4 mb-3">
        <label class="form-label">Taxes</label>
        <select wire:model="tax" class="form-control">
            <option value="0">Pas de TVA</option>
            <option value="tva">TVA 18%</option>
            <option value="brs">BRS 5%</option>
        </select>
    </div>

    <div class="col-md-6 mb-3">
        <label class="form-label">Modalités</label>
        <textarea class="form-control" wire:model="modalite" placeholder="Modalités du devis" cols="30" rows="3"></textarea>
        @error('modalite') <span class="text-danger">{{ $message }}</span> @enderror
    </div>
    <div class="col-md-6 mb-3">
        <label class="form-label">Notes</label>
        <textarea class="form-control" wire:model="note" placeholder="Notes du devis" cols="30" rows="3"></textarea>
        @error('note') <span class="text-danger">{{ $message }}</span> @enderror
    </div>

    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
        <button type="submit" class="btn btn-primary">Valider</button>
    </div>
</div>
