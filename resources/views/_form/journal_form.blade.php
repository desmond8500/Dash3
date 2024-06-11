<div class="row">
    {{-- <div class="col-md-12">
        <div>
            user_id: {{ $user_id }}
            <div>
                @error('user_id') <span class='text-danger'>{{ $message }}</span> @enderror
            </div>
        </div>
        <div>
            client_id: {{ $client_id }}
            <div>
                @error('client_id') <span class='text-danger'>{{ $message }}</span> @enderror
            </div>
        </div>
        <div>
            projet_id: {{ $projet_id }}
            <div>
                @error('projet_id') <span class='text-danger'>{{ $message }}</span> @enderror
            </div>
        </div>
        <div>
            devis_id: {{ $devis_id}}
            <div>
                @error('devis_id') <span class='text-danger'>{{ $message }}</span> @enderror
            </div>
        </div>
    </div> --}}

    {{-- <div class="col-md-8 mb-3">
        <label class="form-label">Titre</label>
        <input type="text" class="form-control" wire:model="title" placeholder="Titre">
        @error('title') <span class='text-danger'>{{ $message }}</span> @enderror
    </div>

    <div class="col-md-4 mb-3">
        <label class="form-label">Date</label>
        <input type="date" class="form-control" wire:model="date" placeholder="Date">
        @error('date') <span class='text-danger'>{{ $message }}</span> @enderror
    </div>

    <div class="col-md-12 mb-3">
        <label class="form-label">Description</label>
        <textarea class="form-control" wire:model="description" placeholder="Description" cols="30" rows="5"></textarea>
        @error('description') <span class='text-danger'>{{ $message }}</span> @enderror
    </div> --}}

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

