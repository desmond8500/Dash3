<div class="col-md-12 mb-3">
    <label class="form-label">Titre</label>
    <input type="text" class="form-control" wire:model="name" placeholder="Titre">
    @error('name') <span class='text-danger'>{{ $message }}</span> @enderror
</div>
<div class="col-md-6 mb-3">
    <label class="form-label">Date de début</label>
    <input type="datetime-local" class="form-control" wire:model="start_date">
    @error('start') <span class='text-danger'>{{ $message }}</span> @enderror
</div>
<div class="col-md-6 mb-3">
    <label class="form-label">Date de fin</label>
    <input type="date" class="form-control" wire:model="end_date">
    @error('end') <span class='text-danger'>{{ $message }}</span> @enderror
</div>
<div class="col-md-6 mb-3">
    <label class="form-label">Heure de début</label>
    <input type="time" class="form-control" wire:model="start_time">
    @error('start') <span class='text-danger'>{{ $message }}</span> @enderror
</div>
<div class="col-md-6 mb-3">
    <label class="form-label">Heure de fin</label>
    <input type="time" class="form-control" wire:model="end_time">
    @error('end') <span class='text-danger'>{{ $message }}</span> @enderror
</div>

<div class="col-md-12 mb-3">
    <label class="form-label">Description</label>
    <textarea class="form-control" wire:model="description" placeholder="Description" cols="30" rows="5"></textarea>
    @error('description') <span class='text-danger'>{{ $message }}</span> @enderror
</div>
