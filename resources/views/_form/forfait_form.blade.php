<div class="col-md-12 mb-3">
    <label class="form-label">Désignation</label>
    <input type="text" class="form-control" wire:model="forfait_form.designation" placeholder="Désignation">
    @error('forfait_form.designation') <span class='text-danger'>{{ $message }}</span> @enderror
</div>

<div class="col-md-12 mb-3">
    <label class="form-label">Description</label>
    <textarea class="form-control" wire:model="forfait_form.description" placeholder="Description" data-bs-toggle="autosize"></textarea>
    @error('forfait_form.description') <span class='text-danger'>{{ $message }}</span> @enderror
</div>

<div class="col-md-7 mb-3">
    <label class="form-label">Prix</label>
    <input type="text" class="form-control" wire:model="forfait_form.price" placeholder="Prix">
    @error('forfait_form.price') <span class='text-danger'>{{ $message }}</span> @enderror
</div>

<div class="col-md-5 mb-3">
    <label class="form-label">Client</label>
    <select class="form-select" wire:model="forfait_form.client_id">
        <option value="">- Select - </option>
        @foreach ($clients as $client)
            <option value="{{ $client->id }}">{{ $client->name }}</option>
        @endforeach
    </select>
    @error('forfait_form.client_id') <span class='text-danger'>{{ $message }}</span> @enderror
</div>
