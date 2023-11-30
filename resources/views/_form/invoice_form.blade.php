<div class="row">
    <div class="col-md-12 mb-3">
        <label class="form-label">Description</label>
        <textarea class="form-control" wire:model="description" placeholder="Description du devis" cols="30" rows="3"></textarea>
        @error('description') <span class="text-danger">{{ $message }}</span> @enderror
    </div>
    <div class="col-md-6 mb-3">
        <label class="form-label">Modalités</label>
        <textarea class="form-control" wire:model="modalite" placeholder="Modalités du devis" cols="30" rows="3"></textarea>
        @error('modalite') <span class="text-danger">{{ $message }}</span> @enderror
    </div>
    <div class="col-md-6 mb-3">
        <label class="form-label">Notes</label>
        <textarea class="form-control" wire:model="note" placeholder="Notes du devis" cols="30" rows="3"></textarea>
        @error('note') <span class="text-danger">{{ $message }}</span> @enderror
    </div>
    <div class="col-md-12 mb-3">
        <label class="form-label">Notes</label>
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="taxe" id="" value="{3:option1}">
            <label class="form-check-label" for="">Pas de TVA</label>
          </div>
          <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="taxe" id="" value="option2">
            <label class="form-check-label" for="">TVA</label>
          </div>
          <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="taxe" id="" value="option3" disabled>
            <label class="form-check-label" for="">BRS</label>
          </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
        <button type="submit" class="btn btn-primary">Valider</button>
    </div>
</div>
