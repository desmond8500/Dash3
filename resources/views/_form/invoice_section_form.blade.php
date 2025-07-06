<div class="col-md-8 mb-3">
    <label class="form-label">Nom de la section</label>
    <input type="text" list="sectionsList" class="form-control" wire:model="section_form.section" placeholder="Nom">

    @error('section_form.section') <span class='text-danger'>{{ $message }}</span> @enderror
</div>

<div class="col-md-4 mb-3">
    <label class="form-label">Ordre</label>
    <input type="number" class="form-control" wire:model="section_form.ordre" placeholder="Ordre">
    @error('section_form.ordre') <span class='text-danger'>{{ $message }}</span> @enderror
</div>

<div class="col-md-4 mb-3">
    <label class="form-label">Statut</label>
    <select class="form-select" wire:model="section_form.status">
        <option value="1">Actif</option>
        <option value="0">Inactif</option>
    </select>
    @error('section_form.status') <span class='text-danger'>{{ $message }}</span> @enderror
</div>
<div class="col-md-6 mb-3">
    <label class="form-label">Devis</label>
    <select class="form-select" wire:model="section_form.invoice_id">
        @foreach ($devis->projet->devis as $devis)
        <option value="{{ $devis->id }}">{{ $devis->description }}</option>
        @endforeach
    </select>
    @error('section_form.invoice_id') <span class='text-danger'>{{ $message }}</span> @enderror
</div>


<div class="col-md-12 mb-3">
    <label class="form-label">Description proposition</label>
    <textarea class="form-control" wire:model="section_form.proposition" placeholder="Description de la proposition"></textarea>
    @error('section_form.proposition') <span class='text-danger'>{{ $message }}</span> @enderror
</div>

