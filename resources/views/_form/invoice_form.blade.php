<div class="row">
    <div class="col-md-8 mb-3">
        <label class="form-label">Client</label>
        <input type="text" class="form-control" wire:model="invoice_form.client_name" placeholder="Nom du client">
        @error('invoice_form.client_name') <span class='text-danger'>{{ $message }}</span> @enderror
    </div>

    <div class="col-md-4 mb-3">
        <label class="form-label">Statut</label>
        <select wire:model="invoice_form.statut" class="form-control">
            <option value="Proforma">Proforma</option>
            <option value="Nouveau">Nouveau</option>
            <option value="En Cours">En Cours</option>
            <option value="En Cours">En Cours</option>
            <option value="En Pause">En Pause</option>
            <option value="Annulé">Annulé</option>
            <option value="A Bl a faire">A Bl a faire</option>
            <option value="A Facturer">A Facturer</option>
            <option value="Terminé">Terminé</option>
        </select>
        @error('invoice_form.statut') <span class='text-danger'>{{ $message }}</span> @enderror
    </div>

    {{-- <div class="col-md-8 mb-3">
        <label class="form-label">Nom du projet</label>
        <input type="text" class="form-control" wire:model="invoice_form.projet_name" placeholder="Nom du projet">
        @error('invoice_form.projet_name') <span class='text-danger'>{{ $message }}</span> @enderror
    </div> --}}

    <div class="col-md-8 mb-3">
        <label class="form-label">Description</label>
        <textarea class="form-control" wire:model="invoice_form.description" placeholder="Description du devis" cols="30" rows="3"></textarea>
        @error('invoice_form.description') <span class="text-danger">{{ $message }}</span> @enderror
    </div>

    <div class="col-md-4 mb-3">
        <label class="form-label">Reference</label>
        <input type="text" class="form-control" wire:model="invoice_form.reference" disabled>
        @error('invoice_form.reference') <span class='text-danger'>{{ $message }}</span> @enderror
    {{-- </div>

    <div class="col-md-4 mb-3"> --}}
        <label class="form-label">Taxes</label>
        <select wire:model="invoice_form.tax" class="form-control">
            <option value="0">Pas de TVA</option>
            <option value="tva">TVA 18%</option>
            <option value="brs">BRS 5%</option>
        </select>
    </div>

    <div class="col-md-6 mb-3">
        <label class="form-label">Modalités</label>
        <textarea class="form-control" wire:model="invoice_form.modalite" placeholder="Modalités du devis" cols="30" rows="3"></textarea>
        @error('invoice_form.modalite') <span class="text-danger">{{ $message }}</span> @enderror
    </div>
    <div class="col-md-6 mb-3">
        <label class="form-label">Notes</label>
        <textarea class="form-control" wire:model="invoice_form.note" placeholder="Notes du devis" cols="30" rows="3"></textarea>
        @error('invoice_form.note') <span class="text-danger">{{ $message }}</span> @enderror
    </div>

    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
        <button type="submit" class="btn btn-primary">Valider</button>
    </div>
</div>
