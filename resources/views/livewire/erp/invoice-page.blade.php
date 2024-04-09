<div>
    @component('components.layouts.page-header', ['title'=>'Devis', 'breadcrumbs'=>$breadcrumbs])
        <div class="btn-list">
            @livewire('form.task-add', ['devis_id' => $devis->id])
            @livewire('form.article-add')
            <button class="btn btn-primary btn-icon" wire:click="$dispatch('open-addSection')">
                <i class="ti ti-plus"></i> Section
            </button>

            <div class="col-auto md-3">
                @if ($devis->favorite)
                    <button class="btn btn-secondary btn-icon" data-bs-toggle="tooltip" wire:click="toggleFavorite()"
                        title="Supprimmer aux favoris">
                        <i class="ti ti-heart"></i>
                    </button>
                @else
                    <button class="btn btn-success btn-icon" data-bs-toggle="tooltip" wire:click="toggleFavorite()"
                        title="Ajouter aux favoris">
                        <i class="ti ti-heart"></i>
                    </button>
                @endif
            </div>
        </div>
    @endcomponent

    <div class="row g-2">
        <div class="col-md-8">

            <div class="card">
                <div class="card-header">
                    <div class="card-title">
                        <div>{{ $devis->client_name }}</div>
                        <div class="text-primary">#{{ $devis->reference }}</div>
                    </div>
                    <div class="card-actions">
                        <div class="badge mb-1">{{ $devis->statut }}</div>
                        <div class="dropdown">
                            <a href="#" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown">Actions</a>
                            <div class="dropdown-menu">
                                <span class="dropdown-header">Devis</span>
                                <a class="dropdown-item text-success" href="#" wire:click="edit({{ $devis->id }})"> <i class="ti ti-edit"></i> Modifier </a>
                                <a class="dropdown-item text-danger" href="#"> <i class="ti ti-trash"></i> Supprimer </a>

                                <div class="dropdown-divider"></div>

                                <span class="dropdown-header">Devis</span>
                                <a class="dropdown-item" href="#"> <i class="ti ti-file-type-pdf"></i> Devis PDF </a>
                                <a class="dropdown-item" href="#"> <i class="ti ti-file-type-pdf"></i> Devis Simple PDF </a>
                                <a class="dropdown-item" href="#"> <i class="ti ti-file-type-pdf"></i> Proforma PDF </a>

                                <span class="dropdown-header">Facture</span>
                                <a class="dropdown-item" href="#"> <i class="ti ti-file-type-pdf"></i> Facture PDF </a>
                                <a class="dropdown-item" href="#"> <i class="ti ti-file-type-pdf"></i> Facture d'acompte </a>
                                <a class="dropdown-item" href="#"> <i class="ti ti-file-type-pdf"></i> Facture Simple PDF </a>

                                <span class="dropdown-header">Exporter</span>
                                <a class="dropdown-item" href="#"> <i class="ti ti-file-type-pdf"></i> Quantitatif PDF </a>
                                <a class="dropdown-item" href="#"> <i class="ti ti-file-type-pdf"></i> Quantitatif XLS </a>
                                <a class="dropdown-item" href="#"> <i class="ti ti-file-type-pdf"></i> Facture Simple PDF </a>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table ">
                        <thead>
                            <tr>
                                <th scope="col">Désignation</th>
                                <th scope="col" class="text-center">Quantité</th>
                                <th scope="col" class="text-center">Coef</th>
                                <th scope="col" class="text-center">Prix</th>
                                <th scope="col" class="text-center">Total</th>
                                <th scope="col" class="text-center">Marge</th>
                                <th scope="col" style="width: 100px" class="text-center">_</th>
                            </tr>
                        </thead>

                        @foreach ($sections as $section)
                            <tr>
                                <th scope="col" class="bg-primary-lt" colspan="2">
                                    {{ $section->section }}

                                    @if ($section_info)
                                        <span class="danger">{{ $section_info }}</span>
                                    @endif
                                </th>
                                <th scope="col" class="bg-primary-lt " colspan="6">
                                    <div class="d-flex justify-content-end">

                                        <button class="btn btn-danger btn-icon mx-1" wire:click="delete_section('{{ $section->id }}')">
                                            <i class="ti ti-trash"></i>
                                        </button>

                                    </div>
                                </th>
                            </tr>

                            <tbody>
                                @foreach ($section->rows as $row)
                                    <tr class="">
                                        <td scope="row">
                                            <div>{{ $row->designation }}</div>
                                            <div class="text-muted">{{ nl2br($row->reference) }}</div>
                                        </td>
                                        <td class="text-center">{{ $row->quantite }}</td>
                                        <td class="text-center">{{ $row->coef }}</td>
                                        <td class="text-center">{{ number_format($row->prix, 0,'.', ' ') }}</td>
                                        <td class="text-center">{{ number_format($row->prix*$row->quantite*$row->coef, 0,'.', ' ') }}</td>
                                        <td class="text-center">{{ number_format($row->prix*$row->quantite*$row->coef -$row->prix*$row->quantite , 0,'.', ' ') }}</td>
                                        <td class="text-center " >
                                            <div>
                                                <button class="btn  btn-icon btn-outline-success" wire:click="editRow('{{ $row->id }}')" ><i class="ti ti-edit"></i></button>
                                                <button class="btn btn-icon btn-outline-danger" wire:click="deleteRow('{{ $row->id }}')"><i class="ti ti-trash"></i></button>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>


                            @endforeach
                        <tr>
                            <th scope="col" class="bg-primary-lt " colspan="8">
                                <div class="d-flex justify-content-end">
                                    <button class="btn btn-primary" wire:click="$dispatch('open-addSection')">
                                        <i class="ti ti-plus"></i> Ajouter une section
                                    </button>
                                </div>
                            </th>
                        </tr>
                    </table>
                </div>
                <div class="card-footer">
                    <div class="row">
                        <div class="col-auto">
                            @livewire('form.invoice-row-add', ['id' => $section->id])
                        </div>
                        <div class="col"></div>
                    </div>
                </div>
            </div>

        </div>
        <div class="col-md-4">

            @livewire('erp.invoice-acompte', ['invoice_id' => $devis->id], key($devis->id))

            @livewire('erp.invoice-spent', ['invoice_id' => $devis->id], key($devis->id))


            <div class="card mb-1">
                <div class="card-header">
                    <div class="card-title">Documents</div>
                    <div class="card-actions">
                        <button class="btn btn-primary btn-icon" disabled>
                            <i class="ti ti-plus"></i>
                        </button>
                    </div>
                </div>
               <div class="card-body">

                </div>
            </div>


        </div>
    </div>


    @component('components.modal', ["id"=>'addSection', 'title'=>'Ajouter une section'])
        <form class="row" wire:submit="sectionStore">
            @include('_form.invoice_section_form')

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                <button type="submit" class="btn btn-primary">Valider</button>
            </div>
        </form>
        <script> window.addEventListener('open-addSection', event => { $('#addSection').modal('show'); }) </script>
        <script> window.addEventListener('close-addSection', event => { $('#addSection').modal('hide'); }) </script>
    @endcomponent

    @component('components.modal', ["id"=>'editInvoice', 'title'=>'Editer un devis'])
    <form class="row" wire:submit="update_invoice">
        @include('_form.invoice_form')
    </form>

    <script> window.addEventListener('open-editInvoice', event => { $('#editInvoice').modal('show'); }) </script>
    <script> window.addEventListener('close-editInvoice', event => { $('#editInvoice').modal('hide'); }) </script>
    @endcomponent
</div>
