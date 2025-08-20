<div class="col-md-4 mb-3">
    <label class="form-label">Fournisseur</label>
    <select class="form-select" wire:model="achat_form.provider_id">
        <option disabled selected value="0">Selectioner un fournisseur</option>
        @foreach ($providers as $provider)
            <option value="{{ $provider->id }}">{{ $provider->name }}</option>
        @endforeach
    </select>
    @error('achat_form.provider_id') <span class='text-danger'>{{ $message }}</span> @enderror
</div>
<div class="col-md-3 mb-3">
    <label class="form-label">Statut</label>
    <select class="form-select" wire:model="achat_form.status">
        <option>Prévu</option>
        <option>Acheté</option>
        <option>Annulé</option>
    </select>
    @error('achat_form.provider_id') <span class='text-danger'>{{ $message }}</span> @enderror
</div>
<div class="col-md-5 mb-3">
    @if ($achat_form->journal_id)
        <label class="form-label required">Journal</label>
        <div>{{ $achat_form->journal_id }}</div>
    @endif
</div>
<div class="col-md-8 mb-3">
    <label class="form-label required">Titre du document</label>
    <input type="text" class="form-control" wire:model="achat_form.name" placeholder="Nom">
    @error('achat_form.name') <span class='text-danger'>{{ $message }}</span> @enderror
</div>
<div class="col-md-4 mb-3">
    <label class="form-label">Date</label>
    <input type="date" class="form-control" wire:model='achat_form.date'>
    @error('achat_form.date') <span class='text-danger'>{{ $message }}</span> @enderror
</div>
<div class="col-md-12 mb-3">
    <label class="form-label">Description</label>
    <textarea class="form-control" wire:model="achat_form.description" placeholder="Description" data-bs-toggle="autosize"></textarea>
    @error('achat_form.description') <span class='text-danger'>{{ message }}</span> @enderror
</div>
