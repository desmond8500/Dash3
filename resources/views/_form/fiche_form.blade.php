<div class="col-md-12 mb-3">
    <label class="form-label">Type de fiche</label>
    <select class="form-select" wire:model="fiche_form.type">
        <option >Select</option>
        @foreach ($types as $type)
            <option value="{{ $type->route }}" wire:click="select_name('{{ $type->name }}')">{{ $type->name }}</option>
        @endforeach
    </select>
    @error('fiche_form.type') <span class='text-danger'>{{ $message }}</span> @enderror
</div>
<div class="col-md-8 mb-3">
    <label class="form-label">Client</label>
    <input type="text" class="form-control" wire:model="fiche_form.client" placeholder="Client">
    @error('fiche_form.client') <span class='text-danger'>{{ $message }}</span> @enderror
</div>
<div class="col-md-8 mb-3">
    <label class="form-label">Titre</label>
    <input type="text" class="form-control" wire:model="fiche_form.titre" placeholder="Titre">
    @error('fiche_form.titre') <span class='text-danger'>{{ $message }}</span> @enderror
</div>
<div class="col-md-4 mb-3">
    <label class="form-label">Date</label>
    <input type="date" class="form-control" wire:model="fiche_form.date" placeholder="Date">
    @error('fiche_form.date') <span class='text-danger'>{{ $message }}</span> @enderror
</div>
<div class="col-md-6 mb-3">
    <label class="form-label">Téléphone</label>
    <input type="text" class="form-control" wire:model="fiche_form.phone" placeholder="Téléphone">
    @error('fiche_form.phone') <span class='text-danger'>{{ $message }}</span> @enderror
</div>
<div class="col-md-6 mb-3">
    <label class="form-label">Email</label>
    <input type="email" class="form-control" wire:model="fiche_form.email" placeholder="Email">
    @error('fiche_form.email') <span class='text-danger'>{{ $message }}</span> @enderror
</div>

