<div>
    <div class="card">
        <div class="card-header">
            <div class="card-title">Installations</div>
            <div class="card-actions">
                <button class='btn btn-primary' wire:click="$dispatch('open-addInstallation')">
                    <i class='ti ti-plus'></i>
                    Installation
                </button>
            </div>
        </div>
        <div class="">
            <div class="table-responsive">
                <table class="table table-vcenter table-nowrap">
                    <thead>
                        <tr>
                            <th>Description</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($installations as $installation)
                            <tr>
                                <td>
                                    <div class="fw-bold">{{ $installation->systeme->name }}</div>
                                    <div>{!! nl2br($installation->description) !!}</div>
                                    <div class="table-responsive">

                                        <table class="table table-bordered  mt-2">
                                            <thead>
                                                <tr class="table-secondary">
                                                    <th>Nom</th>
                                                    <th>Attributs</th>
                                                    <th>Actions</th>
                                                </tr>
                                            </thead>
                                            @foreach ($installation->objets as $objet)
                                                <tr class="table-primary">
                                                    <td>
                                                        <div>{{ $objet->name }}</div>
                                                        <div>{{ $objet->description }}</div>
                                                    </td>
                                                    <td>
                                                        <div class="table-responsive">
                                                            <table class="table">
                                                                <tr class="table-secondary">
                                                                    <th>Nom</th>
                                                                    <th>Valeur</th>
                                                                    <th>Actions</th>
                                                                </tr>
                                                                @foreach ($objet->attributs as $attribut)
                                                                    <tr>
                                                                        <td>{{ $attribut['name'] }}</td>
                                                                        <td>{{ $attribut['value'] }}</td>
                                                                        <td></td>
                                                                    </tr>
                                                                @endforeach
                                                            </table>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <button class="btn btn-primary btn-icon" wire:click="add_attribut('{{ $objet->id }}')">
                                                            <i class="ti ti-plus"></i> {{ $objet->id }}
                                                        </button>
                                                        <button class="btn btn-primary btn-icon" >
                                                            <i class="ti ti-edit"></i>
                                                        </button>
                                                    </td>
                                                </tr>

                                            @endforeach
                                        </table>
                                    </div>
                                </td>
                                <td class="text-end">
                                    @livewire('objet-add', ['installation_id' => $installation->id], key($installation->id))
                                    <button class="btn btn-icon btn-secondary" wire:click="edit({{ $installation->id }})">
                                        <i class="ti ti-edit"></i>
                                    </button>
                                    <button class="btn btn-icon btn-danger" wire:click="delete({{ $installation->id }})">
                                        <i class="ti ti-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>


    @component('components.modal', ["id"=>'addInstallation', 'title' => 'Ajouter une installation', 'method'=>'store'])
        <form class="row" wire:submit="store">
            @include('_form.installation_form')
        </form>
        <script> window.addEventListener('open-addInstallation', event => { window.$('#addInstallation').modal('show'); }) </script>
        <script> window.addEventListener('close-addInstallation', event => { window.$('#addInstallation').modal('hide'); }) </script>
    @endcomponent

    @component('components.modal', ["id"=>'editInstallation', 'title' => 'Modifier une installation', 'method'=>'update'])
        <form class="row" wire:submit="update">
            @include('_form.installation_form')
        </form>
        <script> window.addEventListener('open-editInstallation', event => { window.$('#editInstallation').modal('show'); }) </script>
        <script> window.addEventListener('close-editInstallation', event => { window.$('#editInstallation').modal('hide'); }) </script>
    @endcomponent

    @component('components.modal', ["id"=>'editInstallation', 'title' => 'Modifier une installation', 'method'=>'update'])
        <form class="row" wire:submit="update">
            @include('_form.installation_form')
        </form>
        <script> window.addEventListener('open-editInstallation', event => { window.$('#editInstallation').modal('show'); }) </script>
        <script> window.addEventListener('close-editInstallation', event => { window.$('#editInstallation').modal('hide'); }) </script>
    @endcomponent

    @component('components.modal', ["id"=>'addAttribut', 'title' => 'Ajouter un attribut', 'method'=>'store_attribut'])
        <form class="row" wire:submit="store_attribut">
            @include('_form.attribut_form')
        </form>
        <script> window.addEventListener('open-addAttribut', event => { window.$('#addAttribut').modal('show'); }) </script>
        <script> window.addEventListener('close-addAttribut', event => { window.$('#addAttribut').modal('hide'); }) </script>
    @endcomponent

    @component('components.modal', ["id"=>'attributDetail', 'title' => 'Détails d\'un attribut', 'method'=>'show_attribut'])
        <form class="row" wire:submit="show_attribut">
            @include('_form.attribut_form')
        </form>
        <script> window.addEventListener('open-attributDetail', event => { window.$('#attributDetail').modal('show'); }) </script>
        <script> window.addEventListener('close-attributDetail', event => { window.$('#attributDetail').modal('hide'); }) </script>
    @endcomponent
</div>
