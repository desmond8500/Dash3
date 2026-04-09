<div>
    <div class="card">
        <div class="card-header">
            <div class="card-title">Installations</div>
            <div class="card-actions">
                <button class='btn btn-primary' wire:click="$dispatch('open-addInstallation')">
                    <i class='ti ti-plus'></i>
                    Installation
                </button>
                <button class='btn btn-primary' wire:click="$dispatch('open-genererInstallation')">
                    <i class='ti ti-plus'></i>
                    Générer
                </button>
                <a class="btn" href="{{ route('installations_pdf',['projet_id'=>$projet_id]) }}" target="_blank">
                    <i class="ti ti-file-pdf"></i>
                    Export PDF
                </a>
            </div>
        </div>
        <div class="p-2">
            @foreach ($installations as $installation)
                <div class="row">
                    <div class="col">
                        <div class="fw-bold">{{ $installation->systeme->name }}</div>
                        <div>{!! nl2br($installation->description) !!}</div>
                    </div>
                    <div class="col-auto">
                        <div class="btn-list">
                            @livewire('objet-add', ['installation_id' => $installation->id], key($installation->id))

                            <button class="btn btn-icon btn-secondary" wire:click="edit({{ $installation->id }})">
                                <i class="ti ti-edit"></i>
                            </button>
                            <button class="btn btn-icon btn-danger" wire:click="delete({{ $installation->id }})">
                                <i class="ti ti-trash"></i>
                            </button>
                            <a class="btn disabled" href="{{ route('installations_pdf',['projet_id'=>$projet_id]) }}" target="_blank" disabled>
                                <i class="ti ti-file-pdf"></i>
                                Export PDF
                            </a>
                        </div>
                    </div>
                    <div class="col-md-12">
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
                                    <td style="padding:5px">
                                        <div class="table-responsive">
                                            <table class="table">
                                                <tbody>
                                                    @foreach ($objet->valeurs as $valeur)
                                                        <tr >
                                                            <td style="padding:0px" class="fw-bold">{{ $valeur['name'] }}</td>
                                                            <td style="padding:0px">{{ $valeur['value'] }}</td>
                                                            <td style="padding:0px" width="80">
                                                                <button class="btn btn-sm btn-primary" wire:click="edit_attribut('{{ $valeur->id }}')">
                                                                    <i class="ti ti-edit"></i>
                                                                </button>
                                                                <button class="btn btn-sm btn-danger" wire:click="delete_attribut('{{ $valeur->id }}')">
                                                                    <i class="ti ti-trash"></i>
                                                                </button>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>


                                        </div>
                                        {{-- @foreach ($objet->valeurs as $valeur)


                                            <div class="row">
                                                <div class="col-auto">{{ $valeur['name'] }}</div>
                                                <div class="col">{{ $valeur['value'] }}</div>
                                                <div class="col-auto">
                                                    <div class="btn btn-sm btn-success" wire:click="edit_attribut('{{ $valeur->id }}')">
                                                        <i class="ti ti-edit"></i>
                                                    </div>
                                                    <div class="btn btn-sm btn-danger" wire:click="delete_attribut('{{ $valeur->id }}')">
                                                        <i class="ti ti-trash"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach --}}
                                    </td>
                                    <td width="110">
                                        <button class="btn btn-primary btn-sm btn-icon" wire:click="add_attribut('{{ $objet->id }}')">
                                            <i class="ti ti-plus"></i>
                                        </button>
                                        <button class="btn btn-primary btn-sm btn-icon" wire:click="edit_objet('{{ $objet->id }}')">
                                            <i class="ti ti-edit"></i>
                                        </button>
                                        @if ($objet->valeurs->count()==0)
                                            <button class="btn btn-danger btn-sm btn-icon" wire:click="delete_objet('{{ $objet->id }}')">
                                                <i class="ti ti-trash"></i>
                                            </button>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </table>
                    </div>
                </div>

            @endforeach

        </div>
    </div>


    @component('components.modal', ["id"=>'addInstallation', 'title' => 'Ajouter une installation', 'method'=>'store'])
        <form class="row" wire:submit="store">
            @include('_form.installation_form')
        </form>
        <script> window.addEventListener('open-addInstallation', event => { window.$('#addInstallation').modal('show'); }) </script>
        <script> window.addEventListener('close-addInstallation', event => { window.$('#addInstallation').modal('hide'); }) </script>
    @endcomponent

    @component('components.modal', ["id"=>'genererInstallation', 'title' => 'Ajouter une installation'])
        @livewire('erp.generer-installation')

        <script> window.addEventListener('open-genererInstallation', event => { window.$('#genererInstallation').modal('show'); }) </script>
        <script> window.addEventListener('close-genererInstallation', event => { window.$('#addInstallation').modal('hide'); }) </script>
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
    @component('components.modal', ["id"=>'editAttribut', 'title' => 'Modifier un attribut', 'method'=>'update_attribut'])
        <form class="row" wire:submit="update_attribut">
            @include('_form.attribut_form')
        </form>
        <script> window.addEventListener('open-editAttribut', event => { window.$('#editAttribut').modal('show'); }) </script>
        <script> window.addEventListener('close-editAttribut', event => { window.$('#editAttribut').modal('hide'); }) </script>
    @endcomponent

    @component('components.modal', ["id"=>'attributDetail', 'title' => 'Détails d\'un attribut', 'method'=>'show_attribut'])
        <form class="row" wire:submit="show_attribut">
            @include('_form.attribut_form')
        </form>
        <script> window.addEventListener('open-attributDetail', event => { window.$('#attributDetail').modal('show'); }) </script>
        <script> window.addEventListener('close-attributDetail', event => { window.$('#attributDetail').modal('hide'); }) </script>
    @endcomponent

    @component('components.modal', ["id"=>'editObjet', 'title' => 'éditer un objet', 'method'=>'update_objet'])
    <form class="row" wire:submit="update_objet">
        @include('_form.objet_form')
    </form>
    <script>
        window.addEventListener('open-editObjet', event => { window.$('#editObjet').modal('show'); })
    </script>
    <script>
        window.addEventListener('close-editObjet', event => { window.$('#editObjet').modal('hide'); })
    </script>
    @endcomponent
</div>
