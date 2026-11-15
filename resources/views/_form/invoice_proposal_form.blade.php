<div class="row g-3">

    {{-- Description --}}
    <div class="col-12">
        <label class="form-label">Description</label>
        <textarea class="form-control" wire:model="form.description" placeholder="Description"
            data-bs-toggle="autosize"></textarea>

        @error('form.description')
        <span class="text-danger">{{ $message }}</span>
        @enderror
    </div>

    {{-- Détails --}}
    <div class="col-12">
        <label class="form-label">Détails</label>
        <textarea class="form-control" wire:model="form.details" placeholder="Détails"
            data-bs-toggle="autosize"></textarea>

        @error('form.details')
        <span class="text-danger">{{ $message }}</span>
        @enderror
    </div>

    {{-- Options d'affichage --}}
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title mb-0">
                    Options d'affichage
                </h3>
            </div>

            <div class="card-body">
                <div class="row g-3">

                    {{-- Nom du client --}}
                    <div class="col-12 col-sm-6 col-lg-4">
                        <label class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" wire:model="form.client_name" role="switch">
                            <span class="form-check-label">
                                Nom du client
                            </span>
                        </label>

                        @error('form.client_name')
                        <span class="text-danger small">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Logo --}}
                    <div class="col-12 col-sm-6 col-lg-4">
                        <label class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" wire:model="form.logo" role="switch">
                            <span class="form-check-label">
                                Logo
                            </span>
                        </label>

                        @error('form.logo')
                        <span class="text-danger small">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Projet --}}
                    <div class="col-12 col-sm-6 col-lg-4">
                        <label class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" wire:model="form.projet_name" role="switch">
                            <span class="form-check-label">
                                Nom du projet
                            </span>
                        </label>

                        @error('form.projet_name')
                        <span class="text-danger small">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Société --}}
                    <div class="col-12 col-sm-6 col-lg-4">
                        <label class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" wire:model="form.company_name"
                                role="switch">
                            <span class="form-check-label">
                                Nom de la société
                            </span>
                        </label>

                        @error('form.company_name')
                        <span class="text-danger small">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Bas de page --}}
                    <div class="col-12 col-sm-6 col-lg-4">
                        <label class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" wire:model="form.footer" role="switch">
                            <span class="form-check-label">
                                Bas de page
                            </span>
                        </label>

                        @error('form.footer')
                        <span class="text-danger small">{{ $message }}</span>
                        @enderror
                    </div>

                </div>
            </div>
        </div>
    </div>

</div>
