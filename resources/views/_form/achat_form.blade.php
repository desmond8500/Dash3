<div class="col-md-12 mb-3">
    <label class="form-label">Fournisseur</label>
    <select class="form-control" wire:model="provider_id">
        <option disabled selected value="0">Selectioner un fournisseur</option>
        @foreach ($providers as $provider)
            <option value="{{ $provider->id }}">{{ $provider->name }}</option>
        @endforeach
    </select>
    @error('provider_id') <span class='text-danger'>{{ $message }}</span> @enderror
</div>
<div class="col-md-8 mb-3">
    <label class="form-label">Titre du document</label>
    <input type="text" class="form-control" wire:model="name" placeholder="Nom">
    @error('name') <span class='text-danger'>{{ $message }}</span> @enderror
</div>
<div class="col-md-4 mb-3">
    <label class="form-label">Date</label>
    <input type="date" class="form-control" wire:model='date'>
    @error('date') <span class='text-danger'>{{ $message }}</span> @enderror
</div>
<div class="col-md-12 mb-3">
    <label class="form-label">Description</label>
    <textarea class="form-control" wire:model="description" placeholder="Description" cols="30" rows="5"></textarea>
    @error('description') <span class='text-danger'>{{ message }}</span> @enderror
</div>
