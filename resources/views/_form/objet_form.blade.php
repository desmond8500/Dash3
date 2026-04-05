<div class="text-start">
    @error('objet_form.installation_id') <span class='text-danger'>{{ $message }}</span> @enderror
    @error('objet_form.parent_id') <span class='text-danger'>{{ $message }}</span> @enderror
    <div class="col-md-12 mb-3">
        <label class="form-label">Nom</label>
        <input type="text" class="form-control" wire:model="objet_form.name" placeholder="Nom">
        @error('objet_form.name') <span class='text-danger'>{{ $message }}</span> @enderror
    </div>
    <div class="col-md-12 mb-3">
        <label class="form-label">Description</label>
        <textarea class="form-control" wire:model="objet_form.description" placeholder="Description" cols="30" rows="5"></textarea>
        @error('objet_form.description') <span class='text-danger'>{{ $message }}</span> @enderror
    </div>
    <div class="col-md-4 mb-3">
        <label class="form-label">Type</label>
        <select class="form-select" wire:model="objet_form.type">
            <option value=""></option>
        </select>
        @error('objet_form.type') <span class='text-danger'>{{ $message }}</span> @enderror
    </div>
</div>
