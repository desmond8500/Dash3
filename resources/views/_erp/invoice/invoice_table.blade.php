<div class="card">
    <div class="card-header">
        <div class="card-title">
            <div><span data-bs-toggle="tooltip" title="Client" >{{ $devis->client_name ?? $devis->projet->client->name }}</span> - <span data-bs-toggle="tooltip" title="Nom du projet" >{{ $devis->projet->name }}</span> </div>
            <div class="text-primary">
                #{{ $devis->reference }}
                <span class="fs-5 text-secondary" data-bs-toggle="tooltip" title="Date de création"> {{ $devis->dateFormat($devis->created_at) }}</span>
            </div>
            <div class="" style="font-size: 13px; font-weight:normal;">
                <div>{!! nl2br($devis->description) !!}</div>
                @if($devis->paydate)
                    <div class="text-purple">{{ $devis->formatDate($devis->paydate)  }}</div>
                @endif
            </div>
        </div>
        <div class="card-actions">
            <div class="mb-1">
                @component('components.status',['status'=>$devis->statut, 'invoice_id'=> $devis->id, 'statuses'=>$statuses, 'type'=> "badge text-white bg"])

                @endcomponent
            </div>
            <button class="btn btn-primary btn-icon">
                <i class="ti ti-pdf" wire:click="$dispatch('open-exportPDF')"></i>
            </button>
            <button class="btn btn-primary btn-icon" wire:click="edit({{ $devis->id }})">
                <i class="ti ti-edit"></i>
            </button>

            {{-- <a class="dropdown-item text-success" href="#" > <i class="ti ti-edit"></i> Modifier
            </a>
            <button class="dropdown-item text-danger" href="#"> <i class="ti ti-trash"></i> Supprimer </button> --}}


        </div>
    </div>

    <div class="table-responsive">
        <table class="table ">
            <thead >
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
                // Total
                $total = 0;
                $total_marge = 0;
                $total_equipment = 0;
                $total_cable = 0;
                $total_accessoires = 0;
                $total_mainoeuvre = 0;
                $total_bought = 0;

                // Subtotal
                $subtotal = 0;
                $subtotal_equipment = 0;
                $subtotal_cable = 0;
                $subtotal_accessoires = 0;
                $subtotal_mainoeuvre = 0;
                $subtotal_bought = 0;
            @endphp
            @foreach ($sections->sortBy('ordre') as $key => $section)
                @php
                    $subtotal = 0;
                    $subtotal_equipment = 0;
                    $subtotal_cable = 0;
                    $subtotal_accessoires = 0;
                    $subtotal_mainoeuvre = 0;
                    $subtotal_bought = 0;
                @endphp
                <thead >

                    <tr >
                        <th scope="col" class="bg-primary-lt" colspan="2" >
                            <div>
                                <div class='text-danger' style="font-size: 10px" data-bs-toggle="tooltip" title="Référence de la section">{{ $section->id }}</div>
                                <div>{{ ucfirst($section->section) }}</div>
                            </div>
                        </th>
                        <th scope="col" class="bg-primary-lt " colspan="6">
                            <div class="d-flex justify-content-end">
                                @if ($section->show)
                                    <button class="btn btn-sm rounded btn-dark me-1" data-bs-toggle="tooltip" title="Cacher le contenu de la section" wire:click="section_toggle('{{ $section->id }}')">
                                        <i class="ti ti-eye-off"></i>
                                    </button>
                                @else
                                    <button class="btn btn-sm rounded btn-success me-1" data-bs-toggle="tooltip" title="Afficher le contenu de la section" wire:click="section_toggle('{{ $section->id }}')">
                                        <i class="ti ti-eye"></i>
                                    </button>
                                @endif
                                @if ($section->status)
                                    <button class="btn btn-sm rounded btn-success me-1" data-bs-toggle="tooltip" title="Supprimer de la proposition technique" wire:click="proposition_toggle('{{ $section->id }}')">
                                        <i class="ti ti-circle-check"></i>
                                    </button>
                                @else
                                    <button class="btn btn-sm rounded btn-dark me-1" data-bs-toggle="tooltip" title="Ajouter à la proposition technique" wire:click="proposition_toggle('{{ $section->id }}')">
                                        <i class="ti ti-circle-x"></i>
                                    </button>
                                @endif
                                <button class="btn btn-sm p-1 rounded btn-primary me-1" wire:click="addRow('{{ $section->id }}')">
                                    <i class="ti ti-plus"></i> Article
                                </button>
                                <button class="btn btn-sm p-1 rounded btn-primary btn-icon me-1" wire:click="edit_section('{{ $section->id }}')">
                                    <i class="ti ti-edit"></i>
                                </button>
                                @if (!$section->rows->count())
                                    <button class="btn btn-sm p-1 rounded btn-danger btn-icon me-1" wire:click="delete_section('{{ $section->id }}')"
                                        wire:confirm="Etes vous sur de vouloir supprimer cette section ?">
                                        <i class="ti ti-trash"></i>
                                    </button>
                                @endif
                                <button class="btn btn-sm p-1 btn-primary rounded me-1" disabled data-bs-toggle="tooltip" title="Exporter">
                                    <i class="ti ti-file-type-xls"></i>
                                </button>
                                <button class="btn btn-sm p-1 btn-primary rounded" data-bs-toggle="tooltip" title="Dupliquer la section" wire:click="duplicate_section('{{ $section->id }}')">
                                    <i class="ti ti-copy"></i>
                                </button>
                            </div>
                        </th>
                    </tr>
                </thead>
                @if ($section->proposition)
                    <th>
                        <td colspan="7">
                            <div class="text-muted" style="font-size: 12px;">{!! $section->proposition !!}</div>
                        </td>
                    </th>
                @endif

                @if ($section->show)
                    <tbody>

                        @foreach ($section->rows->sortBy('priorite_id') as $row)
                            @php
                                $total += $row->quantite*$row->prix;
                                $total_bought += $row->bought*$row->prix;
                                $total_marge += $row->quantite*$row->coef*$row->prix;
                                $subtotal += $row->quantite*$row->coef*$row->prix;
                                $subtotal_bought += $row->bought*$row->prix;

                            if ($row->priorite_id >= 0 && $row->priorite_id <= 4) {
                                $subtotal_equipment += $row->quantite*$row->coef*$row->prix;
                                $total_equipment += $row->quantite*$row->coef*$row->prix;

                            }elseif ($row->priorite_id == 5 ) {
                                $subtotal_cable += $row->quantite*$row->coef*$row->prix;
                                $total_cable += $row->quantite*$row->coef*$row->prix;

                            }elseif ($row->priorite_id == 6 ) {
                                $subtotal_accessoires += $row->quantite*$row->coef*$row->prix;
                                $total_accessoires += $row->quantite*$row->coef*$row->prix;

                            }elseif ($row->priorite_id == 7 ) {
                                $subtotal_mainoeuvre += $row->quantite*$row->coef*$row->prix;
                                $total_mainoeuvre += $row->quantite*$row->coef*$row->prix;
                            }

                            @endphp
                            <tr @class(['text-danger' => $row->quantite == 0 || $row->prix == 0])>
                                <td scope="row">
                                    <div class="row g-0">
                                        <div class="col-auto">
                                            @isset ($row->article->image)
                                                <img src="{{ asset($row->article->image) }}" alt="I" class="avatar avatar-sm me-2">
                                            @else
                                                <img src="{{ asset("img/icons/packaging.png") }}" alt="I" class="avatar avatar-md me-2 bg-white border border-white">
                                            @endisset
                                        </div>
                                        <div class="col">
                                            <div>
                                                @if ($row->article_id)
                                                    <a href="{{ route('article',['article_id'=>$row->article_id]) }}" target="_blank">{{ $row->designation }}</a>
                                                @else
                                                    {{ $row->designation }}
                                                @endif

                                            </div>
                                            <div class="text-muted">{!! nl2br($row->reference) !!}</div>

                                        </div>
                                    </div>
                                </td>
                                <td class="text-center">
                                    <div x-data="{ hover: false }" @mouseenter="hover = true" @mouseleave="hover = false"
                                        class="d-flex justify-content-evenly  hover:bg-gray-100 ">

                                        <div x-show="hover" x-transition>
                                            <button class="btn btn-sm rounded" wire:click="decrementRowQuantity({{ $row->id }})"> - </button>
                                        </div>
                                        <span class="">{{ $row->quantite }}</span>
                                        <div x-show="hover" x-transition>
                                            <button class="btn btn-sm rounded" wire:click="incrementRowQuantity({{ $row->id }})"> + </button>
                                        </div>

                                    </div>
                                    <div class="text-success" data-bs-toggle="tooltip" title="Quantitée acheté">{{ $row->bought }}</div>
                                                                    </td>
                                <td class="text-center">
                                    <div x-data="{ hover: false }" @mouseenter="hover = true" @mouseleave="hover = false"
                                        class="d-flex justify-content-evenly  hover:bg-gray-100 ">

                                        <div x-show="hover" x-transition>
                                            <button class="btn btn-sm rounded" wire:click="decrementRowCoef({{ $row->id }})"> - </button>
                                        </div>
                                        <span>{{ $row->coef }}</span>
                                        <div x-show="hover" x-transition>
                                            <button class="btn btn-sm rounded" wire:click="incrementRowCoef({{ $row->id }})"> + </button>
                                        </div>

                                    </div>
                                </td>
                                <td class="text-center">
                                    <div data-bs-toggle="tooltip" title="Prix unitaire avec coeficient de marge">{{ number_format($row->prix*$row->coef, 0,'.', ' ') }}</div>
                                    <div data-bs-toggle="tooltip" title="Prix unitaire sans coeficient de marge" class="text-muted">{{ number_format($row->prix, 0,'.', ' ') }}</div>
                                </td>
                                <td class="text-center">
                                    <div data-bs-toggle="tooltip" title="Prix total sans coeficient de marge">{{ number_format($row->prix*$row->quantite*$row->coef, 0,'.', ' ') }}</div>
                                    <div data-bs-toggle="tooltip" title="Prix total avec coeficient de marge" class="text-muted">{{ number_format($row->prix*$row->quantite, 0,'.', ' ') }}</div>
                                </td>
                                <td class="text-center">
                                    <div>{{ number_format($row->prix*$row->quantite*$row->coef -$row->prix*$row->quantite , 0,'.', ' ') }}</div>
                                    <div class="badge mt-1">{{ $row->priority() }} </div>
                                </td>
                                <td class="text-center ">
                                    <div>
                                        <button class="btn btn-sm btn-icon btn-outline-success" wire:click="editRow('{{ $row->id }}')"><i class="ti ti-edit"></i></button>
                                        <button class="btn btn-sm btn-icon btn-outline-danger" wire:click="deleteRow('{{ $row->id }}')"><i class="ti ti-trash"></i></button>
                                        <div class="dropdown open mt-1 ">
                                            <button class="btn btn-icon btn-outline-primary btn-sm" type="button" id="triggerId" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" >
                                                <i class="ti ti-chevron-down"></i>
                                            </button>
                                            <div class="dropdown-menu" aria-labelledby="triggerId">
                                                <a class="dropdown-item" wire:click="add_to_acompte('{{ $row->id }}')"> <i class="ti ti-plus"></i> Ajouter aux dépenses</a>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        @if ($subtotal_equipment || $subtotal_cable || $subtotal_accessoires || $subtotal_mainoeuvre)
                            <tr class="fw-bold">
                                <td colspan="2" class="bg-indigo-lt">
                                    <div>
                                        <span class="fw-bold">Materiel :</span> {{ number_format($subtotal_equipment, 0,'.', ' ') }} F
                                    </div>
                                    <div>
                                        <span class="fw-bold">Cable :</span> {{ number_format($subtotal_cable, 0,'.', ' ') }} F
                                    </div>
                                </td>
                                <td colspan="2" class="text-end bg-indigo-lt">
                                    <div>
                                        <span class="fw-bold">Accessoires :</span> {{ number_format($subtotal_accessoires, 0,'.', ' ') }} F
                                    </div>
                                    <div>
                                        <span class="fw-bold">Main d'oeuvre :</span> {{ number_format($subtotal_mainoeuvre, 0,'.', ' ') }} F
                                    </div>
                                </td>
                                <td colspan="1" class="bg-azure-lt">
                                    <div>Sous Total</div>
                                    <div>Sous Total Achat :</div>
                                </td>
                                <td colspan="2" class="text-end bg-azure-lt">
                                    <div>{{ number_format($subtotal, 0,'.', ' ') }} F</div>
                                    <div>{{ number_format($subtotal_bought, 0,'.', ' ') }} F</div>
                                </td>
                            </tr>
                        @endif
                    </tbody>
                @endif

            @endforeach
            <tr>
                <th scope="col" class="bg-primary-lt " colspan="8">
                    <div class="d-flex justify-content-end">
                        <button class="btn btn-primary" wire:click="addSection()">
                            <i class="ti ti-plus"></i> Section
                        </button>
                    </div>
                </th>
            </tr>
        </table>
    </div>
    <div class="card-footer p-0">

        <div class="table-responsive mb-2">
            <table class="table  table-bordered bg-white">
                <tr class="fw-bold">
                    <td class="">
                        <div class="d-flex justify-content-between">
                            <span class="fw-bold">Materiel :</span> <span class="text-end">{{ number_format($subtotal_equipment, 0,'.', ' ') }} F</span>
                        </div>
                        <div class="d-flex justify-content-between">
                            <span class="fw-bold">Cable :</span> <span class="text-end">{{ number_format($subtotal_cable, 0,'.', ' ') }} F</span>
                        </div>

                        <div class="d-flex justify-content-between">
                            <span class="fw-bold">Accessoires :</span> <span class="text-end">{{ number_format($subtotal_accessoires, 0,'.', ' ') }} F</span>
                        </div>
                        <div class="d-flex justify-content-between">
                            <span class="fw-bold">Main d'oeuvre :</span> <span class="text-end">{{ number_format($subtotal_mainoeuvre, 0,'.', ' ') }} F</span>
                        </div>
                    </td>
                    <td>
                        <div class="d-flex justify-content-between">
                            <div class="fw-bold me-3">TOTAL HT:</div>
                            <div>{{ number_format($total, 0,'.', ' ') }} F</div>
                        </div>
                        @if ($total_marge - $total)
                            <div class="d-flex justify-content-between">
                                <div class="fw-bold me-3">MARGE:</div>
                                <div>{{ number_format($total_marge - $total, 0,'.', ' ') }} F</div>
                            </div>
                        @endif
                        @if ($devis->tax == 'tva')
                            <div class="d-flex justify-content-between">
                                <div class="fw-bold me-3">TVA :</div>
                                <div>{{ number_format($total_marge*0.18, 0,'.', ' ') }} F</div>
                            </div>
                        @elseif($devis->tax == 'brs')
                            <div class="d-flex justify-content-between">
                                <div class="fw-bold me-3">BRS :</div>
                                <div>{{ number_format($total_marge*0.05, 0,'.', ' ') }} F</div>
                            </div>
                        @else
                            Pas de taxe
                        @endif
                        <div class="d-flex justify-content-between">
                            <div class="fw-bold me-3">TOTAL TTC:</div>
                            @if ($devis->tax == 'tva')
                                @php
                                    $total_marge += $total_marge*0.18;
                                @endphp

                            @elseif($devis->tax == 'brs')
                                @php
                                    $total_marge += $total_marge*0.05;
                                @endphp
                            @endif
                            <div>{{ number_format($total_marge, 0,'.', ' ') }} F</div>

                        </div>

                    </td>

                </tr>
            </table>
        </div>

        <div class="row row-deck g-2">
            <div class="col-md-6 ">
                <div class="card border rounded w-100 p-2">
                    <div class="fw-bold">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>Modalités</div>
                            <div class="dropdown open">
                                <button class="btn btn-action" type="button" id="triggerId" data-bs-toggle="dropdown"
                                    aria-haspopup="true" aria-expanded="false">
                                    <i class="ti ti-chevron-down"></i>
                                </button>
                                <div class="dropdown-menu" aria-labelledby="triggerId">
                                    <a class="dropdown-item" wire:click="edit_modalite()"> <i class="ti ti-edit"></i> Editer
                                        les modalités</a>
                                    <a class="dropdown-item" wire:click="modalite_set(1)"> <i class="ti ti-plus"></i>
                                        Matériel puis reliquat</a>
                                    <a class="dropdown-item" wire:click="modalite_set(2)"> <i class="ti ti-plus"></i>
                                        Acompte de 50%</a>
                                    <a class="dropdown-item" wire:click="modalite_set(3)"> <i class="ti ti-plus"></i>
                                        Acompte de 100%</a>
                                    <a class="dropdown-item" wire:click="modalite_set(0)"> <i class="ti ti-eraser"></i>
                                        Effacer</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div>
                        <x-markdown>
                            {{ $devis->modalite }}
                        </x-markdown>
                    </div>
                </div>
            </div>
            <div class="col-md-6 ">
                <div class="card border rounded w-100 p-2">
                    <div class="fw-bold">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>Notes</div>
                            <div class="dropdown open">
                                <button class="btn btn-action" type="button" id="triggerId" data-bs-toggle="dropdown"
                                    aria-haspopup="true" aria-expanded="false">
                                    <i class="ti ti-chevron-down"></i>
                                </button>
                                <div class="dropdown-menu" aria-labelledby="triggerId">
                                    <a class="dropdown-item" wire:click="edit_note()"> <i class="ti ti-edit"></i> Editer les
                                        notes</a>
                                    <a class="dropdown-item" wire:click="note_set(0)"> <i class="ti ti-eraser"></i>
                                        Supprimer</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div>
                        <x-markdown>
                            {{ $devis->note }}
                        </x-markdown>
                    </div>
                </div>
            </div>
        </div>

    </div>

    @component('components.modal', ["id"=>'editModalite', 'title' => 'Editer les modalités', 'method'=> 'update_modalite'])
        <form class="row" wire:submit="update_modalite">
            <div class="col-md-12 mb-3">
                <label class="form-label">Modalités</label>
                <textarea class="form-control" wire:model="modalite" placeholder="Modalités" data-bs-toggle="autosize" ></textarea>
                @error('modalite') <span class='text-danger'>{{ $message }}</span> @enderror
            </div>
        </form>
        <script> window.addEventListener('open-editModalite', event => { window.$('#editModalite').modal('show'); }) </script>
        <script> window.addEventListener('close-editModalite', event => { window.$('#editModalite').modal('hide'); }) </script>
    @endcomponent

    @component('components.modal', ["id"=>'editNote', 'title' => 'Editer les notes', 'method'=> 'update_note'])
        <form class="row" wire:submit="update_note">
            <div class="col-md-12 mb-3">
                <label class="form-label">Notes</label>
                <textarea class="form-control" wire:model="note" placeholder="Notes" data-bs-toggle="autosize"></textarea>
                @error('note') <span class='text-danger'>{{ $message }}</span> @enderror
            </div>
        </form>
        <script> window.addEventListener('open-editNote', event => { window.$('#editNote').modal('show'); }) </script>
        <script> window.addEventListener('close-editNote', event => { window.$('#editNote').modal('hide'); }) </script>
    @endcomponent

    @component('components.modal', ["id"=>'exportPDF', 'title' => 'Exporter le devis'])
        <div class="row g-2">
            <div class="col-md-12">
                <span class="dropdown-header mb-2">Devis</span>
                <div class="btn-list">
                    <a class="btn mb-1" target="_blank" href="{{ route('facture_pdf',['invoice_id'=>$devis->id, 'type'=>'devis']) }}"> <i class="ti ti-file-type-pdf"></i> Devis PDF </a>
                    <a class="btn mb-1" target="_blank" href="#"> <i class="ti ti-file-type-pdf"></i> Devis Simple PDF </a>
                    <a class="btn mb-1" target="_blank" href="#"> <i class="ti ti-file-type-pdf"></i> Proforma PDF </a>
                </div>
            </div>
            <div class="col-md-12">
                <span class="dropdown-header mb-2">Facture</span>
                <div class="btn-icon">
                    <a class="btn mb-1 " target="_blank" href="{{ route('facture_pdf',['invoice_id'=>$devis->id, 'type'=>'facture']) }}"> <i class="ti ti-file-type-pdf"></i> Facture PDF </a>
                    <a class="btn mb-1 " target="_blank" href="#"> <i class="ti ti-file-type-pdf"></i> Facture Simple PDF </a>
                    <a class="btn mb-1 " target="_blank" href="{{ route('facture_pdf_save',['invoice_id'=>$devis->id, 'type'=>'facture']) }}"> <i class="ti ti-file-type-pdf"></i> Générer Facture </a>
                </div>
            </div>
            <div class="col-md-12">
                <span class="dropdown-header mb-2">Quantité</span>
                <div class="btn-list">
                    <a class="btn " target="_blank" href="{{ route('facture_pdf',['invoice_id'=>$devis->id, 'type'=>'quantitatif']) }}"> <i class="ti ti-file-type-pdf"></i> Quantitatif PDF </a>
                    <a class="btn " target="_blank" href="{{ route('invoice_export',['invoice_id'=>$devis->id]) }}"> <i class="ti ti-file-type-pdf"></i> Exporter Quantitatif XLS </a>
                </div>
            </div>
        </div>

        <script> window.addEventListener('open-exportPDF', event => { window.$('#exportPDF').modal('show'); }) </script>
        <script> window.addEventListener('close-exportPDF', event => { window.$('#exportPDF').modal('hide'); }) </script>
    @endcomponent
</div>
