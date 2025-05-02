<div>
    @component('components.layouts.page-header', ['title'=>"Achat: $achat->name", 'breadcrumbs'=>$breadcrumbs])
        <div class="btn-list">
            <a class="btn btn-primary" target="_blank" href="{{ route('achat_pdf',['achat_id'=>$achat->id]) }}">PDF</a>
            <button class="btn btn-icon" wire:click='$refresh'><i class="ti ti-reload"></i> </button>
        </div>
    @endcomponent

    <div class="row g-2">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">{{ $achat->name }}</div>
                    <div class="card-actions">
                        <button class="btn btn-primary btn-icon" wire:click="achat_edit('{{ $achat->id }}')">
                            <i class="ti ti-edit"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <h3>Description</h3>
                    {{ nl2br($achat->description) }}
                </div>

                <table class="table">
                    @if ($achat->provider)
                        <tr>
                            <td> Fournisseur : </td>
                            <td class="text-end "> {{ $achat->provider->name }} </td>
                        </tr>
                    @endif
                    <tr>
                        <td> Date : </td>
                        <td class="text-end fst-italic"> {{ $achat->formatDate() }} </td>
                    </tr>
                    <tr>
                        <td> TOTAL HT </td>
                        <td class="text-end text-danger"> {{ number_format($achat->total(), 0, 2) }} CFA </td>
                    </tr>
                    <tr>
                        <td> TVA </td>
                        <td class="text-end text-danger"> {{ number_format($achat->tva(), 0, 2) }} CFA </td>
                    </tr>
                    <tr>
                        <td> TOTAL TTC </td>
                        <td class="text-end text-danger"> {{ number_format($achat->ttc(), 0, 2) }} CFA </td>
                    </tr>
                </table>

            </div>

            <div class="card mt-2">
                <div class="card-header">
                    <div class="card-title">Factures</div>
                    <div class="card-actions">
                        <button class="btn btn-primary mt-3" wire:click="$dispatch('open-addAchatFacture')"><i class="ti ti-plus"></i> Facture</button>
                    </div>
                </div>
                <div class="card-body">
                    @foreach ($achat->factures as $facture)
                        <div class="d-flex justify-content-between mb-1">
                            <a href="{{ asset($facture->folder) }}" target="_blank">
                                <i class="ti ti-file-pdf"></i>
                                {{ basename($facture->folder) }}
                            </a>
                            <button class="btn btn-ghost-danger btn-icon" wire:click="delete_facture('{{ $facture->id }}')">
                                <i class="ti ti-trash"></i>
                            </button>
                        </div>
                    @endforeach
                </div>
                <div class="card-footer">

                </div>
            </div>

        </div>
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">Liste des articles</div>
                    <div class="card-actions">
                        <button class="btn btn-primary" wire:click="dispatch('open-addAchatArticle')" > <i class="ti ti-plus"></i> article </button>
                        <button class="btn btn-primary" disabled>
                            <i class="ti ti-file-type-pdf"></i> PDF
                        </button>
                    </div>
                </div>
                <table class="table">
                    <thead>
                        <tr>
                            <td width="10px">#</td>
                            <td>Désignation</td>
                            <td class="text-center">Quantité</td>
                            <td class="text-center">Prix HT/TTC</td>
                            <td class="text-center">TVA</td>
                            <td class="text-center">Total</td>
                            <td class="text-end">Action</td>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $total = 0;
                            $tva = 0;
                        @endphp
                        @foreach ($achat->rows as $key => $row)
                            <tr>
                                <td>{{ $key+1 }}</td>
                                <td>
                                    @if ($row->article_id)
                                        <a href="{{ route('article', ['article_id'=>$row->article_id]) }}" target="_blank">
                                    @endif
                                    <div>{{ $row->designation }}</div>
                                    <div class="text-muted">{{ $row->reference }}</div>
                                    @if ($row->article_id)
                                        </a>
                                    @endif
                                </td>
                                <td class="text-center">{{ $row->quantite }}</td>
                                <td class="text-center">
                                    <div>{{ number_format($row->prix, 0, 2) }} <span style="font-size: 10px">HT</span> </div>
                                    <div class="text-danger">{{ number_format($row->prix + $row->prix * $row->tva, 0, 2)}} <span style="font-size: 10px">TTC</span></div>
                                </td>
                                <td class="text-center">
                                    @if ($row->tva)
                                        <div class="text-light">_</div>
                                        <div>{{ number_format(( $row->prix * $row->tva)*$row->quantite, 0, 2) }}</div>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <div>{{ number_format($row->prix *$row->quantite, 0, 2) }}</div>
                                    <div>{{ number_format(($row->prix + $row->prix * $row->tva)*$row->quantite, 0, 2) }}</div>
                                </td>
                                <td class="text-end">
                                    <button class="btn btn-primary btn-icon" wire:click="row_edit('{{ $row->id }}')">
                                        <i class="ti ti-edit"></i>
                                    </button>
                                    <button class="btn btn-danger btn-icon" wire:click="row_delete('{{ $row->id }}')">
                                        <i class="ti ti-trash"></i>
                                    </button>
                                </td>
                            </tr>
                            @php
                                $total+= ($row->prix + $row->prix * $row->tva)*$row->quantite;
                                $tva+= $row->prix * $row->tva*$row->quantite;
                            @endphp
                        @endforeach
                    </tbody>
                </table>
            </div>

            @component('components.modal', ["id"=>'addAchatArticle', 'title'=> "Ajouter un article à l'achat", 'class'=>'modal-xl'])
                <div class="row g-2">
                    <div class="col-md">
                        <div class="input-icon">
                            <input type="text" class="form-control form-control-rounded" wire:model.live="search" placeholder="Chercher">
                            <span class="input-icon-addon">
                                <i class="ti ti-search"></i>
                            </span>
                        </div>
                    </div>
                    <div class="col-auto">
                        @if ($row_toggle)
                            <button class="btn btn-primary" wire:click="$toggle('row_toggle')">Choisir un article</button>
                        @else
                            <button class="btn btn-primary" wire:click="$toggle('row_toggle')">Ajouter un champ</button>
                        @endif
                        <button class="btn btn-icon" wire:click='$refresh'><i class="ti ti-reload"></i> </button>
                    </div>
                    <div class="w-100"></div>
                    @if ($row_toggle)
                        <form class="row"wire:submit="achat_row_add" >
                            @include('_form.achat_row_form')
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                                <button type="submit" class="btn btn-primary">Valider</button>
                            </div>
                        </form>
                    @else
                        @foreach ($articles as $article)
                            <div class="col-md-6">
                                @component('components.stock.article_card', ['article'=> $article])
                                    <form class="row mt-1" wire:submit="article_add('{{ $article->id }}')">
                                        <div class="col">
                                            <input type="number" min="0" class="form-control" wire:model="a_form.quantite" value="1">
                                        </div>
                                        {{-- <div class="col">
                                            @if ($a_form->tva)
                                                <button class="btn btn-primary" wire:click="set_tva">TVA</button>
                                            @else
                                                <button class="btn btn-danger" wire:click="set_tva">TVA</button>
                                            @endif
                                        </div> --}}
                                        <div class="col-auto">
                                            <button class="btn btn-primary" type="submit">
                                                Ajouter
                                            </button>
                                        </div>
                                    </form>
                                @endcomponent
                            </div>
                        @endforeach

                        <div class="col-md-12">
                            {{ $articles->links() }}
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                        </div>
                    @endif
                </div>
                <script> window.addEventListener('open-addAchatArticle', event => { window.$('#addAchatArticle').modal('show'); }) </script>
                <script> window.addEventListener('close-addAchatArticle', event => { window.$('#addAchatArticle').modal('hide'); }) </script>
            @endcomponent

        </div>
    </div>

    @component('components.modal', ["id"=>'editAchat', 'title'=>"Editer l'achat"])
        <form class="row" wire:submit="achat_update">
            @include('_form.achat_form')
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                <button type="submit" class="btn btn-primary">Valider</button>
            </div>
        </form>
        <script> window.addEventListener('open-editAchat', event => { window.$('#editAchat').modal('show'); }) </script>
        <script> window.addEventListener('close-editAchat', event => { window.$('#editAchat').modal('hide'); }) </script>
    @endcomponent

    @component('components.modal', ["id"=>'editAchatRow', 'title'=>"Editer l'article"])
        <form class="row" wire:submit="row_update">
            @include('_form.achat_row_form')

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                <button type="submit" class="btn btn-primary">Valider</button>
            </div>
        </form>
        <script> window.addEventListener('open-editAchatRow', event => { window.$('#editAchatRow').modal('show'); }) </script>
        <script> window.addEventListener('close-editAchatRow', event => { window.$('#editAchatRow').modal('hide'); }) </script>
    @endcomponent

    @component('components.modal', ["id"=>'addAchatFacture', 'title'=>"Ajouter une facture"])
        <form class="row" wire:submit="addFacture">
            <div class="col-md-12 mb-3">
                <label class="form-label">Facture</label>
                <input type="file" class="form-control" wire:model="facture">
                @error('facture') <span class='text-danger'>{{ $message }}</span> @enderror
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                <button type="submit" class="btn btn-primary">Valider</button>
            </div>
        </form>
        <script> window.addEventListener('open-addAchatFacture', event => { window.$('#addAchatFacture').modal('show'); }) </script>
        <script> window.addEventListener('close-addAchatFacture', event => { window.$('#addAchatFacture').modal('hide'); }) </script>
    @endcomponent
</div>
