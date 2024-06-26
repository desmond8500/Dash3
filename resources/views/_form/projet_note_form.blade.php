
@error('projet_note_form.projet_id') <span class='text-danger'>{{ $message }}</span> @enderror

<div class="col-md-8 mb-3">
    <label class="form-label">Titre </label>
    <input type="text" class="form-control" wire:model="projet_note_form.titre" placeholder="Nom">
    @error('projet_note_form.titre') <span class='text-danger'>{{ $message }}</span> @enderror
</div>

<div class="col-md-12 mb-3">
    <label class="form-label">Description</label>
    <textarea class="form-control" wire:model="projet_note_form.description" placeholder="Description" cols="30" rows="5"></textarea>
    @error('projet_note_form.description') <span class='text-danger'>{{ message }}</span> @enderror
</div>
