<div>
    @component('components.layouts.page-header', ['title'=>'Devis', 'breadcrumbs'=>$breadcrumbs])
        <div class="btn-list">
            <button class="btn" wire:click="$dispatch('open-importRows')" data-bs-toggle="tooltip" title="Ajouter un devis">
                Importer Devis
            </button>
            @livewire('form.task-add', ['devis_id' => $devis->id])
            {{-- @livewire('form.article-add') --}}
            <button class="btn btn-primary" wire:click="$dispatch('open-addSection')" data-bs-toggle="tooltip" title="Ajouter une section">
                <i class="ti ti-plus"></i> Section
            </button>

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

            @livewire('erp.invoice-acompte', ['invoice_id' => $devis->id])

            @livewire('erp.invoice-spent', ['invoice_id' => $devis->id])

            <div class="card mb-1">
                @livewire('erp.invoice-documents', ['invoice_id' => $devis->id])
            </div>

            <div class="mb-1">
                @livewire('erp.invoice-bordereau', ['invoice_id' => $devis->id])
            </div>

        </div>
    </div>

    {{-- Invoice --}}
    @component('components.modal', ["id"=>'editInvoice', 'title'=>'Editer un devis'])
        <form class="row" wire:submit="update_invoice">
            @include('_form.invoice_form')
        </form>

        <script> window.addEventListener('open-editInvoice', event => { $('#editInvoice').modal('show'); }) </script>
        <script> window.addEventListener('close-editInvoice', event => { $('#editInvoice').modal('hide'); }) </script>
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
            <div> <b>Systèmes :</b> {{ $systems->count() }} </div>

            @foreach ($systems as $system)
                <button class="btn btn-primary mb-1" wire:click="section_generate('{{ $system->name }}')">{{ $system->name }}</button>
            @endforeach

        @else
            <form class="row" wire:submit="sectionStore">
                @include('_form.invoice_section_form')

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                    <button type="submit" class="btn btn-primary">Valider</button>
                </div>
            </form>
            <script> window.addEventListener('open-addSection', event => { $('#addSection').modal('show'); }) </script>
            <script> window.addEventListener('close-addSection', event => { $('#addSection').modal('hide'); }) </script>

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
    @component('components.modal', ["id"=>'addRow', 'title'=>'Ajouter un article', 'class'=> "$row_class"])
        @slot('actions')
            <button class="btn btn-primary" wire:click="toggle_row(1)">Formulaire</button>
            <button class="btn btn-primary" wire:click="toggle_row(2)">Générer</button>
            <button class="btn btn-primary" wire:click="toggle_row(3)">Forfaits</button>
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
                       <div class="row g-2">
                        <div class="col">
                            @include('_card.articleCard', ['img_class'=>''])
                        </div>
                        <div class="col-auto">
                            <button class="btn btn-primary btn-icon" wire:click="generateArticleRow('{{ $article->id }}')" >
                                <i class="ti ti-plus"></i>
                            </button>
                        </div>
                       </div>

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
                    <div class="dropdown open mb-1">
                        <button class="btn btn-primary text-start w-100" type="button" id="triggerId" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" >
                            <i class="ti ti-chevron-down"></i> Désignation
                        </button>
                        <div class="dropdown-menu" aria-labelledby="triggerId">
                            <a class="dropdown-item" wire:click="designation('Main d\'oeuvre')"> </i> Main d'oeuvre</a>
                            <a class="dropdown-item" wire:click="designation('Forfait Accessoires')"> </i> Forfait Accessoires</a>
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
                            <a class="dropdown-item" wire:click="prix(50000)">50 000 CFA</a>
                            <a class="dropdown-item" wire:click="prix(100000)">100 000 CFA</a>
                            <a class="dropdown-item" wire:click="prix(150000)">150 000 CFA</a>
                            <a class="dropdown-item" wire:click="prix(200000)">200 000 CFA</a>
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

    @component('components.modal', ["id"=>'importRows', 'title'=>'Importer des articles', 'class'=> $row_class])
        <form class="row" wire:submit="import">
            {{-- @include('_form.invoice_row_form') --}}

            <div class="col-md-12 mb-3">
                <label class="form-label">Fichier</label>
                <input type="file" class="form-control" wire:model="file" placeholder="Fichier">
                @error('file') <span class='text-danger'>{{ $message }}</span> @enderror
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                <button type="submit" class="btn btn-primary">Valider</button>
            </div>
        </form>
        <script> window.addEventListener('open-importRows', event => { $('#importRows').modal('show'); }) </script>
        <script> window.addEventListener('close-importRows', event => { $('#importRows').modal('hide'); }) </script>
    @endcomponent

    {{-- Informations --}}
    @component('components.modal.info-modal', ["id"=>'infoModal', 'title'=> 'Information', 'type'=>'success'])

        {!! nl2br($message ?? 'Description') !!}

        <script> window.addEventListener('open-infoModal', event => { $('#infoModal').modal('show'); }) </script>
        <script> window.addEventListener('close-infoModal', event => { $('#infoModal').modal('hide'); }) </script>
    @endcomponent
</div>
