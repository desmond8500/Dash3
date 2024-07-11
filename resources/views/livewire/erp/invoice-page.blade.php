<div>
    @component('components.layouts.page-header', ['title'=>'Devis', 'breadcrumbs'=>$breadcrumbs])
        <div class="btn-list">
            @livewire('form.task-add', ['devis_id' => $devis->id])
            @livewire('form.article-add')
            <button class="btn btn-primary" wire:click="$dispatch('open-addSection')">
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
                        <div>{{ $devis->client_name ?? $devis->projet->client->name.' - '.$devis->projet->name }}</div>
                        <div class="text-primary">#{{ $devis->reference }}</div>
                        <div class="" style="font-size: 13px; font-weight:normal;">
                            <div>{!! nl2br($devis->description) !!}</div>
                        </div>
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
                                <a class="dropdown-item" target="_blank" href="#"> <i class="ti ti-file-type-pdf"></i> Devis PDF </a>
                                <a class="dropdown-item" target="_blank" href="#"> <i class="ti ti-file-type-pdf"></i> Devis Simple PDF </a>
                                <a class="dropdown-item" target="_blank" href="#"> <i class="ti ti-file-type-pdf"></i> Proforma PDF </a>

                                <div class="dropdown-divider"></div>

                                <span class="dropdown-header">Facture</span>
                                <a class="dropdown-item" target="_blank" href="{{ route('facture_pdf',['invoice_id'=>$devis->id, 'type'=>'facture']) }}"> <i class="ti ti-file-type-pdf"></i> Facture PDF </a>
                                {{-- <a class="dropdown-item" target="_blank" href="{{ route('facture_pdf',['invoice_id'=>$devis->id, 'type'=>"Facture d'acompte"]) }}"> <i class="ti ti-file-type-pdf"></i> Facture d'acompte </a> --}}
                                <a class="dropdown-item" target="_blank" href="#"> <i class="ti ti-file-type-pdf"></i> Facture Simple PDF </a>

                                <div class="dropdown-divider"></div>

                                <span class="dropdown-header">Exporter</span>
                                <a class="dropdown-item" target="_blank" href="{{ route('facture_pdf',['invoice_id'=>$devis->id, 'type'=>'quantitatif']) }}"> <i class="ti ti-file-type-pdf"></i> Quantitatif PDF </a>
                                <a class="dropdown-item" target="_blank" href="#"> <i class="ti ti-file-type-pdf"></i> Quantitatif XLS </a>
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
                        @php
                            $total = 0;
                            $total_marge = 0;
                        @endphp
                        @foreach ($sections as $key => $section)
                            @php
                                $subtotal = 0;
                            @endphp
                            <tr>
                                <th scope="col" class="bg-primary-lt" colspan="2">
                                    <div>{{ $section->section }}</div>
                                    <div>Sous Total: {{ $section->total() }}</div>
                                    {{-- @foreach ($section->total as $item)
                                        @dump($item)
                                    @endforeach --}}
                                </th>
                                <th scope="col" class="bg-primary-lt " colspan="6">
                                    <div class="d-flex justify-content-end">
                                        <button class="btn btn-primary mx-1" wire:click="addRow('{{ $section->id }}')">
                                            <i class="ti ti-plus"></i> Article
                                        </button>
                                        <button class="btn btn-primary btn-icon mx-1" wire:click="edit_section('{{ $section->id }}')">
                                            <i class="ti ti-edit"></i>
                                        </button>
                                        <button class="btn btn-danger btn-icon mx-1" wire:click="delete_section('{{ $section->id }}')" wire:confirm="Etes vous sur de vouloir supprimer cette section ?">
                                            <i class="ti ti-trash"></i>
                                        </button>
                                    </div>
                                </th>
                            </tr>

                            <tbody>

                                @foreach ($section->rows as $row)
                                    @php
                                        $total += $row->quantite*$row->prix;
                                        $total_marge += $row->quantite*$row->coef*$row->prix;
                                        $subtotal += $row->quantite*$row->coef*$row->prix;
                                    @endphp
                                    <tr class="">
                                        <td scope="row">
                                            <div>{{ $row->designation }}</div>
                                            <div class="text-muted">{{ nl2br($row->reference) }}</div>
                                        </td>
                                        <td class="text-center">{{ $row->quantite }}</td>
                                        <td class="text-center">{{ $row->coef }}</td>
                                        <td class="text-center">
                                            <div>{{ number_format($row->prix*$row->coef, 0,'.', ' ') }}</div>
                                            <div class="text-muted">{{ number_format($row->prix, 0,'.', ' ') }}</div>
                                        </td>
                                        <td class="text-center">
                                            <div>{{ number_format($row->prix*$row->quantite*$row->coef, 0,'.', ' ') }}</div>
                                            <div class="text-muted">{{ number_format($row->prix*$row->quantite, 0,'.', ' ') }}</div>
                                        </td>
                                        <td class="text-center">
                                            <div></div>
                                            <div>{{ number_format($row->prix*$row->quantite*$row->coef -$row->prix*$row->quantite , 0,'.', ' ') }}</div>
                                        </td>
                                        <td class="text-center " >
                                            <div>
                                                <button class="btn  btn-icon btn-outline-success" wire:click="editRow('{{ $row->id }}')" ><i class="ti ti-edit"></i></button>
                                                <button class="btn btn-icon btn-outline-danger" wire:click="deleteRow('{{ $row->id }}')"><i class="ti ti-trash"></i></button>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                                <tr class="fw-bold">
                                    <td colspan="2">Sous Total</td>
                                    <td colspan="5" class="text-end"> {{ number_format($subtotal, 0,'.', ' ') }}  F</td>
                                </tr>
                            </tbody>

                            @endforeach
                        <tr>
                            <th scope="col" class="bg-primary-lt " colspan="8">
                                <div class="d-flex justify-content-end">
                                    <button class="btn btn-primary" wire:click="addSection()">
                                        <i class="ti ti-plus"></i> Ajouter une section
                                    </button>
                                </div>
                            </th>
                        </tr>
                    </table>
                </div>
                <div class="card-footer">
                    <div class="row">
                        <div class="col">

                        </div>
                        <div class="col-auto">
                            <div class="d-flex justify-content-between">
                                <div class="fw-bold me-3">TOTAL HT:</div>
                                <div>{{ number_format($total, 0,'.', ' ') }} F</div>
                            </div>
                            <div class="d-flex justify-content-between">
                                <div class="fw-bold me-3">MARGE:</div>
                                <div>{{ number_format($total_marge - $total, 0,'.', ' ') }} F</div>
                            </div>
                            <div class="d-flex justify-content-between">
                                <div class="fw-bold me-3">TOTAL TTC:</div>
                                <div>{{ number_format($total_marge, 0,'.', ' ') }} F</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <div class="col-md-4">

            @livewire('erp.invoice-acompte', ['invoice_id' => $devis->id])

            @livewire('erp.invoice-spent', ['invoice_id' => $devis->id])


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

    {{-- Invoice --}}
    @component('components.modal', ["id"=>'editInvoice', 'title'=>'Editer un devis'])
        <form class="row" wire:submit="update_invoice">
            @include('_form.invoice_form')
        </form>

        <script>
            window.addEventListener('open-editInvoice', event => { $('#editInvoice').modal('show'); })
        </script>
        <script>
            window.addEventListener('close-editInvoice', event => { $('#editInvoice').modal('hide'); })
        </script>
    @endcomponent

    {{-- Section --}}
    @component('components.modal', ["id"=>'addSection', 'title'=>'Ajouter une section'])
        @slot('actions')
            @if ($section_tab)
                <button class="btn btn-primary" wire:click="$toggle('section_tab')"> Formulaire </button>
            @else
                <button class="btn btn-primary" wire:click="$toggle('section_tab')"> Générer </button>
            @endif
        @endslot

        @if ($section_tab)
            <div> <b>Systèmes :</b> {{ $systemes->count() }} </div>

            @foreach ($systemes as $systeme)
                <button class="btn btn-primary mb-1" wire:click="sectionGenerate('{{ $systeme->name }}')">{{ $systeme->name }}</button>
            @endforeach

        @else
            <form class="row" wire:submit="sectionStore">
                @include('_form.invoice_section_form')

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                    <button type="submit" class="btn btn-primary">Valider</button>
                </div>
            </form>
            <script>
                window.addEventListener('open-addSection', event => { $('#addSection').modal('show'); })
            </script>
            <script>
                window.addEventListener('close-addSection', event => { $('#addSection').modal('hide'); })
            </script>

        @endif
    @endcomponent

    @component('components.modal', ["id"=>'editSection', 'title'=>'Editer une section'])
        <form class="row" wire:submit="update_section">
            @include('_form.invoice_section_form')

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                <button type="submit" class="btn btn-primary">Valider</button>
            </div>
        </form>
        <script> window.addEventListener('open-editSection', event => { $('#editSection').modal('show'); }) </script>
        <script> window.addEventListener('close-editSection', event => { $('#editSection').modal('hide'); }) </script>
    @endcomponent

    {{-- Rows --}}
    @component('components.modal', ["id"=>'addRow', 'title'=>'Ajouter un article', 'class'=> $row_class])
        @slot('actions')
            <button class="btn btn-primary" wire:click="toggle_row(1)">Formulaire</button>
            <button class="btn btn-primary" wire:click="toggle_row(2)">Générer</button>
            <button class="btn btn-primary" wire:click="toggle_row(3)">Forfaits</button>
        @endslot

        @if ($row_tab==2)
            <div class="row g-2">
                @foreach ($articles as $article)
                    <div class="col-md-4">
                        @include('_card.articleCard')
                    </div>
                @endforeach
                <div class="col-md-12">
                    {{ $articles->links() }}
                </div>
            </div>
        @elseif($row_tab==1)
            <form class="row" wire:submit="storeRow">
                @include('_form.invoice_row_form')
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                    <button type="submit" class="btn btn-primary">Valider</button>
                </div>
            </form>
            <script> window.addEventListener('open-addRow', event => { $('#addRow').modal('show'); }) </script>
            <script> window.addEventListener('close-addRow', event => { $('#addRow').modal('hide'); }) </script>
        @elseif($row_tab==3)
            <div class="row">
                <div class="col-md-12 mb-3">
                    <div class="card card-body card-active">
                        <div class="d-flex justify-content-between">
                            <div>{{ $row_form->designation }}</div>
                            <div>{{ $row_form->prix }}</div>
                        </div>

                    </div>
                </div>
                <div class="col-md-7">
                    <div class="row">
                        <div class="mb-3 col-md-12">
                            <label>Tarif</label>
                            <input type="text" class="form-control" wire:model.live="row_form.prix" placeholder="Prix">
                        </div>
                        <div class="mb-3 col-md-6">
                            <label>Coéficient</label>
                            <input type="text" class="form-control" wire:model="row_form.coef" placeholder="Coef">
                        </div>
                        <div class="mb-3 col-md-6">
                            <label>Quantité</label>
                            <input type="text" class="form-control" wire:model="row_form.quantite" placeholder="Quantite">
                        </div>
                    </div>

                </div>
                <div class="col-md-5">
                    <div class="btn-group mb-1 w-100" role="group" aria-label="Button group with nested dropdown">
                        <button type="button" class="btn btn-primary" wire:click="designation('Main d\'oeuvre')">Main d'oeuvre</button>
                        <div class="btn-group" role="group">
                            <button id="btnGroupDrop1" type="button" class="btn btn-primary btn-icon dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"> </button>
                            <ul class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                                <li><a class="dropdown-item" wire:click="prix(30000)">30 000 CFA</a></li>
                                <li><a class="dropdown-item" wire:click="prix(50000)">50 000 CFA</a></li>
                                <li><a class="dropdown-item" wire:click="prix(100000)">100 000 CFA</a></li>
                                <li><a class="dropdown-item" wire:click="prix(200000)">200 000 CFA</a></li>
                                <li><a class="dropdown-item" wire:click="prix(300000)">300 000 CFA</a></li>
                            </ul>
                        </div>
                    </div>

                    <div class="btn-group mb-1 w-100" role="group" aria-label="Button group with nested dropdown">
                        <button type="button" class="btn btn-primary" wire:click="designation('Accessoires')">Accessoires</button>
                        <div class="btn-group" role="group">
                            <button id="btnGroupDrop1" type="button" class="btn btn-primary btn-icon dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"> </button>
                            <ul class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                                <li><a class="dropdown-item" wire:click="prix(20000)">20 000 CFA</a></li>
                                <li><a class="dropdown-item" wire:click="prix(50000)">50 000 CFA</a></li>
                                <li><a class="dropdown-item" wire:click="prix(100000)">100 000 CFA</a></li>
                                <li><a class="dropdown-item" wire:click="prix(150000)">150 000 CFA</a></li>
                            </ul>
                        </div>
                    </div>

                </div>

                <div class=" mb-3">
                    <label class="form-label">Description</label>
                    <textarea class="form-control" wire:model="row_form.reference" placeholder="Référence de l'article" cols="30"
                        rows="4" data-bs-toggle="autosize"></textarea>
                </div>

                <div class="col-md-12" style="display: flex; justify-items-between">
                    <div class="modal-footer">
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


        @endif
    @endcomponent
    @component('components.modal', ["id"=>'editRow', 'title'=>'Editer un article', 'class'=> $row_class])
        <form class="row" wire:submit="updateRow">
            @include('_form.invoice_row_form')
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                <button type="submit" class="btn btn-primary">Valider</button>
            </div>
        </form>
        <script> window.addEventListener('open-editRow', event => { $('#editRow').modal('show'); }) </script>
        <script> window.addEventListener('close-editRow', event => { $('#editRow').modal('hide'); }) </script>
    @endcomponent

    {{-- Informations --}}
    @component('components.modal.info-modal', ["id"=>'infoModal', 'title'=> 'Information', 'type'=>'success'])

        {!! nl2br($message ?? 'Description') !!}

        <script> window.addEventListener('open-infoModal', event => { $('#infoModal').modal('show'); }) </script>
        <script> window.addEventListener('close-infoModal', event => { $('#infoModal').modal('hide'); }) </script>
    @endcomponent
</div>
