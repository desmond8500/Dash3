<div class="col-auto">
    <div wire:loading>
        Chargement <div class="spinner-border" role="status"></div>
    </div>
        <label href="#" class="avatar avatar-upload rounded" for="file">
            @if ($contact_form->avatar)
                @if (is_string($contact_form->avatar))
                    <img src="{{ asset($contact_form->avatar) }}" class="avatar">
                @else
                    <img src="{{ $contact_form->avatar->temporaryUrl() }}" class="avatar">
                @endif
            @else
            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"> <path stroke="none" d="M0 0h24v24H0z" fill="none" /> <line x1="12" y1="5" x2="12" y2="19" /> <line x1="5" y1="12" x2="19" y2="12" /> </svg>
        @endif
        <span class="avatar-upload-text">Ajouter</span>
        <input type="file" style="display: none" id="file" accept="image/*" wire:model.defer="contact_form.avatar">
    </label>
</div>

<div class="col-md-5 mb-3">
    <label class="form-label">Prénom</label>
    <input type="text" class="form-control" wire:model="contact_form.firstname" placeholder="Prénom">
    @error('contact_form.firstname') <span class='text-danger'>{{ $message }}</span> @enderror
</div>
<div class="col-md-5 mb-3">
    <label class="form-label">Nom</label>
    <input type="text" class="form-control" wire:model="contact_form.lastname" placeholder="Nom">
    @error('contact_form.lastname') <span class='text-danger'>{{ $message }}</span> @enderror
</div>
<div class="col-md-6 mb-3">
    <label class="form-label">Fonction</label>
    <input type="text" class="form-control" wire:model="contact_form.fonction" placeholder="Fonction">
    @error('contact_form.fonction') <span class='text-danger'>{{ $message }}</span> @enderror
</div>
<div class="col-md-6 mb-3">
    <label class="form-label">Societe</label>
    <input type="text" class="form-control" wire:model="contact_form.societe" placeholder="Entreprise">
    @error('contact_form.societe') <span class='text-danger'>{{ $message }}</span> @enderror
</div>
<div class="w-100"></div>
<div class="col-md-6 mb-3">
    <label class="form-label">Téléphone</label>
    <input type="tel" class="form-control" wire:model="contact_form.phone" placeholder="Téléphone">
    @error('contact_form.phone') <span class='text-danger'>{{ $message }}</span> @enderror
</div>
<div class="col-md-6 mb-3">
    <label class="form-label">Email</label>
    <input type="email" class="form-control" wire:model="contact_form.email" placeholder="Email">
    @error('contact_form.email') <span class='text-danger'>{{ $message }}</span> @enderror
</div>
