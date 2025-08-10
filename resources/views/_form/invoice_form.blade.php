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
            <option value="En Pause">En Pause</option>
            <option value="Annulé">Annulé</option>
            <option value="Bl a faire">Bl a faire</option>
            <option value="A Facturer">A Facturer</option>
            <option value="Terminé">Terminé</option>
        </select>
        @error('invoice_form.statut') <span class='text-danger'>{{ $message }}</span> @enderror
    </div>

    <div class="col-md-8 mb-3">
        <div class="mb-2">
            <label class="form-label">Description</label>
            <textarea class="form-control" wire:model="invoice_form.description" placeholder="Description du devis" data-bs-toggle="autosize"></textarea>
            @error('invoice_form.description') <span class="text-danger">{{ $message }}</span> @enderror
        </div>
        <div class="row">
            <div class="mb-2 col-md-6">
                <label class="form-label">Date de facturation</label>
                <input type="date" class="form-control" wire:model="invoice_form.facture_date">
                @error('invoice_form.facture_date') <span class='text-danger'>{{ $message }}</span> @enderror
            </div>
            <div class="col-md-6">
                <label class="form-label">Date de paiment</label>
                <input type="date" class="form-control" wire:model="invoice_form.paydate">
                @error('invoice_form.paydate') <span class='text-danger'>{{ $message }}</span> @enderror
            </div>
        </div>

        <div class="mb-2">
            <label class="form-label">Modalités</label>
            <textarea class="form-control" wire:model="invoice_form.modalite" placeholder="Modalités du devis"
                data-bs-toggle="autosize"></textarea>
            @error('invoice_form.modalite') <span class="text-danger">{{ $message }}</span> @enderror
        </div>
        <div class="mb-2">
            <label class="form-label">Notes</label>
            <textarea class="form-control" wire:model="invoice_form.note" placeholder="Notes du devis"
                data-bs-toggle="autosize"></textarea>
            @error('invoice_form.note') <span class="text-danger">{{ $message }}</span> @enderror
        </div>
    </div>

    <div class="col-md-4 mb-2">
        <div class="mb-3">
            <label class="form-label">Reference</label>
            <input type="text" class="form-control" wire:model="invoice_form.reference" disabled>
            @error('invoice_form.reference') <span class='text-danger'>{{ $message }}</span> @enderror
        </div>
        <div class="mb-2">
            <label class="form-label">Taxes</label>
            <select wire:model="invoice_form.tax" class="form-control">
                <option value="0">Pas de TVA</option>
                <option value="tva">TVA 18%</option>
                <option value="brs">BRS 5%</option>
            </select>
        </div>
        <div class="mb-2">
            <label class="form-label">Projet</label>
            <select wire:model="invoice_form.projet_id" class="form-control">
                @isset($devis)
                    @foreach ($devis->projet->client->projets->sortBy('name') as $projet)
                        <option value="{{ $projet->id }}">{{ $projet->name }}</option>
                    @endforeach
                @endisset
                @isset($invoice)
                    @foreach ($invoice->projet->client->projets->sortBy('name') as $projet)
                        <option value="{{ $projet->id }}">{{ $projet->name }}</option>
                    @endforeach
                @endisset
            </select>
        </div>
    </div>
</div>
