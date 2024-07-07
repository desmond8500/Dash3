<div class="row">

    {{-- @isset($clients)
        <div class="col-md-4 mb-3">
            <label class="form-label">Client </label>
            <select class="form-control" wire:model="journalForm.client_id">
                @foreach ($clients as $client)
                    <option value="{{ $client->id }}">{{ $client->name }}</option>
                @endforeach
            </select>
            @error('journalForm.client_id') <span class='text-danger'>{{ $message }}</span> @enderror
        </div>
    @endisset --}}

    <div class="w-100"></div>

    <div class="col-md-8 mb-3">
        <label class="form-label">Titre</label>
        <input type="text" class="form-control" wire:model="journalForm.title" placeholder="Titre">
        @error('journalForm.title') <span class='text-danger'>{{ $message }}</span> @enderror
    </div>

    <div class="col-md-4 mb-3">
        <label class="form-label">Date</label>
        <input type="date" class="form-control" wire:model="journalForm.date" placeholder="Date">
        @error('journalForm.date') <span class='text-danger'>{{ $message }}</span> @enderror
    </div>

    <div class="col-md-12 mb-3">
        <label class="form-label">Description</label>
        <textarea class="form-control" wire:model="journalForm.description" placeholder="Description" cols="30" rows="5"></textarea>
        @error('journalForm.description') <span class='text-danger'>{{ $message }}</span> @enderror
    </div>


</div>

