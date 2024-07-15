<div class="col-md-12">
    <div wire:loading>
        <div class="d-flex justify-content-between">
            <div>Chargement <span class="animated-dots"></div>
        </div>
    </div>
</div>
<div class="col-12 mb-3">

    {{-- <img src="{{ asset($badge_form->photo) }}" class="avatar avatar-md rounded" alt="A"> --}}
    {{-- @isset($badge_form->photo)
        @if ($badge_form->photo)
            @foreach (glob(dirname($badge_form->photo)."/*") as $item)
            @endforeach
        @endif
    @endisset --}}


    <input type="file" id="file" accept="image/*"  style="display: none" wire:model="badge_form.photo">
    <label for="file" href="#" class="avatar avatar-upload rounded">
        <i class="ti ti-plus"></i>
        <span class="avatar-upload-text">Add</span>
    </label>
</div>

<hr>

<div class="col-md-6 mb-3">
    <label class="form-label">Prénom</label>
    <input type="text" class="form-control" wire:model="badge_form.prenom" placeholder="Prénom">
    @error('badge_form.prenom') <span class='text-danger'>{{ $message }}</span> @enderror
</div>
<div class="col-md-6 mb-3">
    <label class="form-label">Nom</label>
    <input type="text" class="form-control" wire:model="badge_form.nom" placeholder="Nom">
    @error('badge_form.nom') <span class='text-danger'>{{ $message }}</span> @enderror
</div>
<div class="col-md-6 mb-3">
    <label class="form-label">Fonction</label>
    <input type="text" class="form-control" wire:model="badge_form.fonction" placeholder="Fonction">
    @error('badge_form.fonction') <span class='text-danger'>{{ $message }}</span> @enderror
</div>
<div class="col-md-6 mb-3">
    <label class="form-label">Service</label>
    <input type="text" class="form-control" wire:model="badge_form.service" placeholder="Service">
    @error('badge_form.service') <span class='text-danger'>{{ $message }}</span> @enderror
</div>
<div class="col-md-6 mb-3">
    <label class="form-label">Direction</label>
    <input type="text" class="form-control" wire:model="badge_form.direction" placeholder="Direction">
    @error('badge_form.direction') <span class='text-danger'>{{ $message }}</span> @enderror
</div>
<div class="col-md-6 mb-3">
    <label class="form-label">Matricule</label>
    <input type="text" class="form-control" wire:model="badge_form.matricule" placeholder="Matricule">
    @error('badge_form.matricule') <span class='text-danger'>{{ $message }}</span> @enderror
</div>
<div class="col-md-12 mb-3">
    <label class="form-label">Adresse</label>
    <input type="text" class="form-control" wire:model="badge_form.adresse" placeholder="Adresse">
    @error('badge_form.adresse') <span class='text-danger'>{{ $message }}</span> @enderror
</div>
