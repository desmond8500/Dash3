<div class="p-2 row g-2">
    <div class="col">
        <h2>Préférences</h2>
    </div>
    <div class="col-auto">
        @if ($settings->count())
            @if ($form)
                <button class="btn btn-secondary" wire:click="$set('form', 0)">Fermer</button>
            @else
                <button class="btn btn-success" wire:click="$set('form', 1)">Editer</button>
            @endif
        @else
            <button class="btn btn-primary" wire:click='init_settings'>Initialiser</button>
        @endif
    </div>
    <div class="col-md-12">
        @if ($form)
            <div class="row g-2">
                <div class="col-md-2">
                    <label class="form-label">Tableau de bord</label>
                    <select class="form-select" wire:model="dashboard">
                        <option value="0">Select</option>
                        <option value="1">Base</option>
                    </select>
                    @error('dashboard') <span class='text-danger'>{{ $message }}</span> @enderror
                </div>

                <div class="col-md-2">
                    <label class="form-label">Couleur </label>
                    <input type="color" class="form-control" wire:model="color" placeholder="Couleur">
                    @error('color') <span class='text-danger'>{{ $message }}</span> @enderror
                </div>
                {{-- <div class="col-md-2">
                    <label class="form-label">Couleur </label>
                    <input type="color" class="form-control" wire:model="color" placeholder="Couleur">
                    @error('color') <span class='text-danger'>{{ $message }}</span> @enderror
                </div>
                <div class="col-md-2">
                    <label class="form-label">Couleur </label>
                    <input type="color" class="form-control" wire:model="color" placeholder="Couleur">
                    @error('color') <span class='text-danger'>{{ $message }}</span> @enderror
                </div>
                <div class="col-md-2">
                    <label class="form-label">Couleur </label>
                    <input type="color" class="form-control" wire:model="color" placeholder="Couleur">
                    @error('color') <span class='text-danger'>{{ $message }}</span> @enderror
                </div> --}}

                <div class="col-md-2">
                    <label class="form-label">Année fiscale</label>
                    <input type="number" class="form-control" wire:model="year" min="2024" max="2100"  placeholder="Année fiscale">

                    @error('year') <span class='text-danger'>{{ $message }}</span> @enderror
                </div>
                <div class="col-md-2">
                    <label class="form-label">Année fiscale</label>
                    <select class="form-select" wire:model="size">
                        <option value="container-xl">Container XL</option>
                        <option value="container-fluid">Container Fluid</option>
                    </select>
                    @error('size') <span class='text-danger'>{{ $message }}</span> @enderror
                </div>
                <div class="col-md-12 mt-3">
                    <button class="btn btn-primary" wire:click="update">Modifier</button>
                </div>
            </div>
        @else
            <table class="table table-hover">
                <thead class="sticky-top">
                    <tr>
                        <td>Désignation</td>
                        <td>Statut</td>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Tableau de bord</td> <td>{{ $settings->dashboard }}</td>
                    </tr>
                    <tr>
                        <td>Couleur</td> <td>{{ $settings->color }}</td>
                    </tr>
                    {{-- <tr>
                        <td>Couleur 1</td> <td>{{ $settings->color1 }}</td>
                    </tr>
                    <tr>
                        <td>Couleur 2</td> <td>{{ $settings->color2 }}</td>
                    </tr>
                    <tr>
                        <td>Couleur 3</td> <td>{{ $settings->color3 }}</td>
                    </tr> --}}
                    <tr>
                        <td>Année fiscale</td> <td>{{ $settings->year }}</td>
                    </tr>
                    <tr>
                        <td>Taille de page</td> <td>{{ $settings->size }}</td>
                    </tr>
                </tbody>
            </table>
        @endif
    </div>
</div>
