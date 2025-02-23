<div class="col-md-12 mb-3">
    <div wire:loading>
        <div class="d-flex justify-content-between">
            <div>Chargement <span class="animated-dots"></div>
        </div>
    </div>
    <input type="file" class="form-control" wire:model="file" accept=".pdf">
    @error('file') <span class='text-danger'>{{ $message }}</span> @enderror
</div>

<div class="col-md-4 mb-3">
    <label class="form-label">Statut</label>
    <select class="form-select" wire:model="status">
        <option value="facture">Facturée</option>
        <option value="paye">Payée</option>
        <option value="acompte">acompte</option>
    </select>
    @error('status') <span class='text-danger'>{{ $message }}</span> @enderror
</div>
<div class="col-md-4 mb-3">
    <label class="form-label">Référence</label>
    <input type="text" class="form-control" wire:model="reference" placeholder="Référence">
    @error('reference') <span class='text-danger'>{{ $message }}</span> @enderror
</div>
<div class="col-md-4 mb-3">
    <label class="form-label">Montant</label>
    <input type="text" class="form-control" wire:model="montant" placeholder="Montant">
    @error('montant') <span class='text-danger'>{{ $message }}</span> @enderror
</div>
<div class="col-md-4 mb-3">
    <label class="form-label">Date</label>
    <input type="date" class="form-control" wire:model="date">
    @error('date') <span class='text-danger'>{{ $message }}</span> @enderror
</div>

<div class="col-md-12 mb-3">
    <label class="form-label">Description</label>
    <textarea class="form-control" wire:model="description" placeholder="Description" data-bs-toggle="autosize"></textarea>
    @error('description') <span class='text-danger'>{{ $message }}</span> @enderror
</div>
