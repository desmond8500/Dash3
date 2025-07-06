<div>
    @component('components.layouts.page-header', ['title'=>'Devis', 'breadcrumbs'=>$breadcrumbs])
        <div class="btn-list">
            <div class="dropdown open">
                <button class="btn btn-primary" type="button" id="triggerId" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" >
                    <i class="ti ti-chevron-down"></i> Actions
                </button>
                <div class="dropdown-menu" aria-labelledby="triggerId">
                    <a class="dropdown-item" wire:click="$dispatch('open-importRows')" data-bs-toggle="tooltip" title="Ajouter un devis"> <i class="ti ti-file-arrow-left"></i> Importer Devis</a>
                    <a class="dropdown-item" wire:click="$dispatch('open-addSection')" data-bs-toggle="tooltip" title="Ajouter une section"> <i class="ti ti-plus"></i> Section</a>
                    @empty($pvs)
                        <a class="dropdown-item" wire:click="addPv()" title="Ajouter un PV"> <i class="ti ti-plus"></i> Procès Verbal</a>
                    @else
                        <a class="dropdown-item" href="{{ route('pv',['invoice_id'=>$devis->id]) }}" title="Consulter le PV"> <i class="ti ti-file"></i> Procès Verbal</a>
                    @endempty
                </div>
            </div>

            @livewire('form.task-add', ['devis_id' => $devis->id])

            @livewire('form.transaction-add', ['invoice_id' => $devis->id])

            <div class="col-auto md-3">
                @if ($devis->favorite)
                    <a class="btn btn-secondary btn-icon" data-bs-toggle="tooltip" wire:click="toggleFavorite()"
                        title="Supprimmer aux favoris">
                        <i class="ti ti-heart"></i>
                    </a>
                @else
                    <a class="btn btn-success btn-icon" data-bs-toggle="tooltip" wire:click="toggleFavorite()"
                        title="Ajouter aux favoris">
                        <i class="ti ti-heart"></i>
                    </a>
                @endif
            </div>
            <button class="btn btn-icon" wire:click='$refresh'><i class="ti ti-reload"></i> </button>
        </div>
    @endcomponent

    <div class="row g-2">
        <div class="col-md-8">
            @include('_erp.invoice.invoice_table')
        </div>
        <div class="col-md-4">

            <div class="card mb-1">
                @livewire('erp.invoice-documents', ['invoice_id' => $devis->id])
            </div>
            <div class="mb-1">
                @livewire('erp.invoice-bordereau', ['invoice_id' => $devis->id])
            </div>
            <div class="mb-1">
                @livewire('erp.facturelist', ['invoice_id' => $devis->id])
            </div>
            @livewire('erp.invoice-acompte', ['invoice_id' => $devis->id])

            @livewire('erp.invoice-spent', ['invoice_id' => $devis->id])

            <div class="mb-1">
                @livewire('erp.invoice-proposal', ['invoice_id' => $devis->id])
            </div>

        </div>
    </div>

    {{-- Invoice --}}
    @component('components.modal', ["id"=>'editInvoice', 'title'=>'Editer un devis', 'method'=>'update_invoice'])
        <form class="row" wire:submit="update_invoice">
            @include('_form.invoice_form',['nosection'=>false])
        </form>

        <script> window.addEventListener('open-editInvoice', event => { window.$('#editInvoice').modal('show'); }) </script>
        <script> window.addEventListener('close-editInvoice', event => { window.$('#editInvoice').modal('hide'); }) </script>
    @endcomponent

    {{-- Section --}}
    @component('components.modal', ["id"=>'addSection', 'title'=>'Ajouter une section', 'refresh'=>true, 'method'=> 'sectionStore', 'submit'=>'Ajouter'])
        @slot('actions')
            @if ($section_tab)
                <button class="btn btn-primary" wire:click="$toggle('section_tab')"> Formulaire </button>
            @else
                <button class="btn btn-primary" wire:click="$toggle('section_tab')"> Générer </button>
            @endif
        @endslot

        @if ($section_tab)
            <div class="row g-2">
                <div class="col-md-5">
                        @foreach ($systems as $system)
                            <div class="row g-1">
                                <div class="col">
                                    <button class="btn btn-primary mb-1 w-100" wire:click="section_show('{{ $system->id }}')">{{ $system->name }}</button>
                                </div>
                                <div class="col-auto">
                                    <button class="btn btn-primary btn-icon mb-1" wire:click="section_generate('{{ $system->name }}')">
                                        <i class="ti ti-plus"></i>
                                    </button>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="col-md-7">
                        @foreach ($section_system_select->models ?? [] as $model)
                            <div class="card p-2 mb-2" wire:click="section_model_add('{{ $model->id }}')">
                                <div class="fw-bold">{{ $model->name }}</div>
                                <div class="text-muted">{{ $model->description }}</div>

                            </div>
                        @endforeach

                    </div>
                </div>


        @else
            <form class="row" wire:submit="sectionStore">
                @include('_form.invoice_section_form')
            </form>
        @endif
        <script> window.addEventListener('open-addSection', event => { window.$('#addSection').modal('show'); }) </script>
        <script> window.addEventListener('close-addSection', event => { window.$('#addSection').modal('hide'); }) </script>

    @endcomponent

    @component('components.modal', ["id"=>'editSection', 'title'=>'Editer une section', 'method'=>'update_section'])
        <form class="row" wire:submit="update_section">
            @include('_form.invoice_section_form')
        </form>
        <script> window.addEventListener('open-editSection', event => { window.$('#editSection').modal('show'); }) </script>
        <script> window.addEventListener('close-editSection', event => { window.$('#editSection').modal('hide'); }) </script>
    @endcomponent

    {{-- Rows --}}
    @component('components.modal', ["id"=>'addRow', 'title'=>'Ajouter un article', 'class'=> "$row_class"])
        @slot('actions')
            <div class="btn-list">
                <button class="btn btn-primary btn-sm rounded p-1" wire:click="toggle_row(1)">Formulaire</button>
                <button class="btn btn-primary btn-sm rounded p-1" wire:click="toggle_row(2)">Importer</button>
                <button class="btn btn-primary btn-sm rounded p-1" wire:click="toggle_row(3)">Forfaits</button>
                <button class="btn btn-primary btn-sm rounded p-1" wire:click="toggle_row(4)">Forfaits2</button>
            </div>
        @endslot

        @if ($row_tab==2)
            <div class="row g-2">
                <div class="input-icon">
                    <input type="text" class="form-control form-control-rounded" wire:model.live="search" placeholder="Chercher ">
                    <span class="input-icon-addon">
                        <i class="ti ti-search"></i>
                    </span>
                </div>
                @foreach ($articles as $article)
                    <div class="col-md-4 ">
                        @include('_card.articleCard', ['img_class'=>'', 'form'=>true])
                    </div>
                @endforeach
                <div class="col-md-12">
                    {{ $articles->links() }}
                </div>
            </div>
        @elseif($row_tab==1)
            <form class="row" wire:submit="storeRow">
                @include('_form.invoice_row_form',['nosection'=>false])
                <div class="">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                    <button type="submit" class="btn btn-primary">Valider</button>
                </div>
            </form>
            <script> window.addEventListener('open-addRow', event => { window.$('#addRow').modal('show'); }) </script>
            <script> window.addEventListener('close-addRow', event => { window.$('#addRow').modal('hide'); }) </script>
        @elseif($row_tab==3)
            <div class="row">
                <div class="col-md-6">
                    <div class="card card-body card-active mb-3">
                        <div class="d-flex justify-content-between">
                            <div>{{ $row_form->designation }}</div>
                            <div>{{ $row_form->prix }}</div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="mb-3 col-md-6">
                            <label>Tarif</label>
                            <input type="number" min="0" step="10000" class="form-control" wire:model.live="row_form.prix" placeholder="Prix">
                        </div>
                        <div class="mb-3 col-md-6">
                            <label class="">Priorite</label>
                            <select class="form-control" wire:model="row_form.priorite_id">
                                <option value="0">Centrale 1</option>
                                <option value="1">Centrale 2</option>
                                <option value="2">Organe 1</option>
                                <option value="3">Organe 2</option>
                                <option value="4">Organe 3</option>
                                <option value="5">Cable</option>
                                <option value="6">Accessoires</option>
                                <option value="7">Forfait</option>
                            </select>
                            @error('row_form.priorite_id') <span class='text-danger'>{{ $message }}</span> @enderror
                        </div>
                        <div class="mb-3 col-md-6">
                            <label>Coéficient</label>
                            <input type="number" min="1" class="form-control" wire:model="row_form.coef" placeholder="Coef">
                        </div>
                        <div class="mb-3 col-md-6">
                            <label>Quantité</label>
                            <input type="text" min="0" class="form-control" wire:model="row_form.quantite" placeholder="Quantite">
                        </div>
                    </div>

                </div>
                <div class="col-md-6">
                    <div class="dropdown open mb-1">
                        <button class="btn btn-primary text-start w-100" type="button" id="triggerId" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" >
                            <i class="ti ti-chevron-down"></i> Désignation
                        </button>
                        <div class="dropdown-menu" aria-labelledby="triggerId">
                            <a class="dropdown-item" wire:click="designation('Main d\'oeuvre')"> </i> Main d'oeuvre</a>
                            <a class="dropdown-item" wire:click="designation('Forfait accessoires et main d\'oeuvre')"> </i> Forfait accessoires et main d'oeuvre</a>
                            <a class="dropdown-item" wire:click="designation('Forfait Accessoires')"> </i> Forfait Accessoires</a>
                            @foreach ($forfaits as $forfait)
                                <a class="dropdown-item" wire:click="forfait('{{ $forfait->id }}')"> </i>{{ $forfait->designation }}</a>
                            @endforeach
                        </div>
                    </div>
                    <div class="dropdown open mb-1">
                        <button class="btn btn-primary text-start w-100" type="button" id="triggerId" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" >
                            <i class="ti ti-chevron-down"></i> Tarifs
                        </button>
                        <div class="dropdown-menu" aria-labelledby="triggerId">
                            <a class="dropdown-item" wire:click="prix(10000)">10 000 CFA</a>
                            <a class="dropdown-item" wire:click="prix(20000)">20 000 CFA</a>
                            <a class="dropdown-item" wire:click="prix(30000)">30 000 CFA</a>
                            <a class="dropdown-item" wire:click="prix(40000)">40 000 CFA</a>
                            <a class="dropdown-item" wire:click="prix(50000)">50 000 CFA</a>
                            <a class="dropdown-item" wire:click="prix(100000)">100 000 CFA</a>
                            <a class="dropdown-item" wire:click="prix(130000)">130 000 CFA</a>
                            <a class="dropdown-item" wire:click="prix(150000)">150 000 CFA</a>
                            <a class="dropdown-item" wire:click="prix(200000)">200 000 CFA</a>
                        </div>
                    </div>
                </div>

                <div class="col-md-12 mb-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <label class="form-label">Description</label>
                        <div class="dropdown open">
                            <button class="btn btn-action" type="button" id="triggerId" data-bs-toggle="dropdown" aria-haspopup="true"
                                aria-expanded="false">
                                <i class="ti ti-chevron-down"></i>
                            </button>
                            <div class="dropdown-menu" aria-labelledby="triggerId">
                                <a class="dropdown-item" wire:click="$set('row_form.reference','- Tirage \n- Pose \n- Connexion \n- Mise en service')">Main d'œuvre 1</a>
                                <a class="dropdown-item" wire:click="$set('row_form.reference','- Plâtre \n - Goulottes')">Accessoires 1</a>
                            </div>
                        </div>
                    </div>
                    <textarea class="form-control" wire:model="row_form.reference" placeholder="Référence de l'article"  data-bs-toggle="autosize"></textarea>
                </div>

                <div class="col-md-12" style="display: flex; justify-items-between">
                    <div class="">
                        <div class="w-100">
                            <div class="row">
                                <div class="col">
                                    <button class="btn btn-secondary" wire:click="$dispatch('close-editRow')">Fermer</button>
                                </div>
                                <div class="col">
                                    <button class="btn btn-primary" wire:click="generateRow()">Valider</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        @elseif($row_tab==4)

            <div class="row g-2">
                @foreach ($forfaits as $forfait)
                    <div class="col-md-6" wire:click="forfait('{{ $forfait->id }}')">
                        <div class="card p-2">
                            <div class="row">

                                <div class="col">
                                    <div class="badge bg-primary text-white">{{ $forfait->client->name }}</div>
                                    <div class="fw-bold">{{ $forfait->designation }}</div>
                                    <div class="text-muted">@parsedown($forfait->description)</div>
                                    <div class="fs-3 text-end">{{ number_format($forfait->price, 0,'.', ' ') }} F</div>
                                </div>
                                {{-- <div class="col-auto">
                                    <div>
                                        <button class="btn btn-outline-primary btn-icon" wire:click="edit('{{ $forfait->id }}')">
                                            <i class="ti ti-edit"></i>
                                        </button>
                                        <button class="btn btn-outline-danger btn-icon" wire:click="delete('{{ $forfait->id }}')">
                                            <i class="ti ti-trash"></i>
                                        </button>
                                    </div>
                                </div> --}}
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

        @endif
    @endcomponent
    @component('components.modal', ["id"=>'editRow', 'title'=>'Editer un article', 'class'=> $row_class, 'method'=>'updateRow'])
        <form class="row" wire:submit="updateRow">
            @include('_form.invoice_row_form',['nosection'=>false])
        </form>
        <script> window.addEventListener('open-editRow', event => { window.$('#editRow').modal('show'); }) </script>
        <script> window.addEventListener('close-editRow', event => { window.$('#editRow').modal('hide'); }) </script>
    @endcomponent

    @component('components.modal', ["id"=>'importRows', 'title'=>'Importer des articles', 'class'=> $row_class, 'method'=>'import'])
        <form class="row" wire:submit="import">

            <div class="col-md-12 mb-3">
                <label class="form-label">Fichier</label>
                <input type="file" class="form-control" wire:model="file" placeholder="Fichier">
                @error('file') <span class='text-danger'>{{ $message }}</span> @enderror
            </div>

        </form>
        <script> window.addEventListener('open-importRows', event => { window.$('#importRows').modal('show'); }) </script>
        <script> window.addEventListener('close-importRows', event => { window.$('#importRows').modal('hide'); }) </script>
    @endcomponent

    {{-- Informations --}}
    @component('components.modal.info-modal', ["id"=>'infoModal', 'title'=> 'Information', 'type'=>'success'])

        {!! nl2br($message ?? 'Description') !!}

        <script> window.addEventListener('open-infoModal', event => { window.$('#infoModal').modal('show'); }) </script>
        <script> window.addEventListener('close-infoModal', event => { window.$('#infoModal').modal('hide'); }) </script>
    @endcomponent
</div>
