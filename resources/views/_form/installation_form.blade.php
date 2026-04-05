<div>
    <div class="col-md-12 mb-3">
        <label class="form-label">Type</label>
        <select class="form-select" wire:model="type">
            <option value="">Sélectionnez un type</option>
            @foreach ($systems as $system)
                <option value="{{ $system->id }}">{{ $system->name }}</option>
            @endforeach
        </select>
        @error('type') <span class='text-danger'>{{ $message }}</span> @enderror
    </div>
    <div class="col-md-12 mb-3">
        <label class="form-label">Description</label>
        <textarea class="form-control" wire:model="description" placeholder="Description" cols="30" rows="5"></textarea>
        @error('description') <span class='text-danger'>{{ $message }}</span> @enderror
    </div>

</div>
