<div>
    <div class="col-md-12 mb-3">
        <label class="form-label">Nom</label>
        <input type="text" class="form-control" wire:model="schema_name" placeholder="Nom">
        @error('schema_name') <span class='text-danger'>{{ $message }}</span> @enderror
    </div>
    <div class="col-md-4 mb-3">
        <label class="form-label">Type</label>
        <select class="form-select" wire:model="schema_type">
            <option value="diagram">Diagram</option>
            <option value="rack">Rack</option>
        </select>
        @error('schema_type') <span class='text-danger'>{{ $message }}</span> @enderror
    </div>
    <div class="col-md-12 mb-3">
        <label class="form-label">Description</label>
        <textarea class="form-control" wire:model="schema_description" placeholder="Description" cols="30" rows="5"></textarea>
        @error('schema_description') <span class='text-danger'>{{ $message }}</span> @enderror
    </div>
</div>
