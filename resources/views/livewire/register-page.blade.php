<div>
    <fieldset>
        <form  wire:submit='register'>
            <div class="col-md-4 mb-3">
                <label class="form-label">Prénom</label>
                <input type="text" class="form-control" wire:model.defer="firstname" placeholder="Prénom">
            </div>
            <div class="col-md-4 mb-3">
                <label class="form-label">Nom</label>
                <input type="text" class="form-control" wire:model.defer="lastname" placeholder="Nom">
            </div>
            <div class="col-md-4 mb-3">
                <label class="form-label">Email</label>
                <input type="text" class="form-control" wire:model.defer="email" placeholder="Email">
            </div>
            <div class="col-md-4 mb-3">
                <label class="form-label">Mot de passe</label>
                <input type="password" class="form-control" wire:model.defer="password" placeholder="Password">
            </div>
            <div class="col-md-4">
                <a href="/" class="btn btn-secondary" wire:navigate>Annuler</a>
                <button class="btn btn-primary" type="submit">Valider</button>
            </div>
        </form>
    </fieldset>
</div>
