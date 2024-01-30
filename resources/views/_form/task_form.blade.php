<div class="row">
    <div class="col-md-12">
        <div>
            Projet :{{ $form->projet_id }}
        </div>
    </div>


   <div class="col-md-12 mb-3">
       <label class="form-label">Nom de la tache</label>
       <input type="text" class="form-control" wire:model="form.name" placeholder="Nom">
       @error('form.name') <span class='text-danger'>{{ $message }}</span> @enderror
   </div>

   <div class="col-md-4 mb-3">
       <label class="form-label">Status</label>
       <select class="form-control" wire:model="form.status_id">
           @foreach ($statuses as $status)
        <option value="{{ $status->level }}">{{ $status->name }}</option>
        @endforeach
       </select>
       @error('form.status_id') <span class='text-danger'>{{ $message }}</span> @enderror
   </div>
   <div class="col-md-4 mb-3">
       <label class="form-label">Priorité</label>
       <select class="form-control" wire:model="form.priority_id">
            @foreach ($priorities as $priority)
                <option value="{{ $priority->level }}">{{ $priority->name }}</option>
            @endforeach
       </select>
       @error('form.priority_id') <span class='text-danger'>{{ $message }}</span> @enderror
   </div>

   <div class="col-md-4 mb-3">
        <label class="form-label">Expiration</label>
        <input type="date" class="form-control" wire:model="form.expiration_date" placeholder="Nom">
        @error('form.expiration_date') <span class='text-danger'>{{ $message }}</span> @enderror
    </div>

   <div class="col-md-12 mb-3">
       <label class="form-label">Description</label>
       <textarea class="form-control" wire:model="form.description" placeholder="Description" cols="30" rows="5"></textarea>
       @error('form.description') <span class='text-danger'>{{ $message }}</span> @enderror
   </div>


</div>
