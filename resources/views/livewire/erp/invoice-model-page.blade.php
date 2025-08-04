<div>
    @component('components.layouts.page-header', ['title'=> 'Modèle de devis', 'breadcrumbs'=> $breadcrumbs])
        <div class="btn-list">
            <button class='btn btn-primary' wire:click="$dispatch('open-addSystem')"><i class='ti ti-plus'></i> Système</button>
            <button class="btn btn-icon" wire:click='$refresh'><i class="ti ti-reload"></i> </button>
        </div>
    @endcomponent

    <div class="row g-2">
        <div class="col-md-12">
            <div class="card p-2">
                <nav class="nav nav-segmented" role="tablist">
                    @foreach ($systems as $systeme)
                        <a class="nav-link" role="tab" wire:click="select_system('{{ $systeme->id }}')" >
                            <i class="ti ti-star"></i>
                            {{ $systeme->name }}
                        </a>
                    @endforeach
                </nav>
            </div>
        </div>

        <div class="col-md-4">
            @if ($selected_system)
                <div class="card mb-3">
                    <div class="card-header">
                        <div class="card-title">{{ $selected_system->name }}</div>
                        <div class="card-actions">
                            <button class="btn btn-primary btn-icon" wire:click="add_model('{{ $selected_system->id }}')">
                                <i class="ti ti-plus"></i>
                            </button>
                            <button class="btn btn-primary btn-icon" wire:click="edit_system('{{ $selected_system->id }}')">
                                <i class="ti ti-edit"></i>
                            </button>
                        </div>
                    </div>
                    <div class="p-2">
                        @foreach ($selected_system->models as $model)
                        <div class="border rounded p-1 mb-1">
                            <div class="row g-1 align-items-center"class="col cursor-pointer">
                                <div class="col" wire:click="select_model('{{ $model->id }}')">
                                    <a  >{{ $model->name }}</a>
                                    <div class="text-muted">{{ $model->description }}</div>
                                </div>
                                <div class="col-auto">
                                    <div class="dropdown open">
                                        <button class="btn btn-action" type="button" id="triggerId" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" >
                                            <i class="ti ti-chevron-down"></i>
                                        </button>
                                        <div class="dropdown-menu" aria-labelledby="triggerId">
                                            <a class="dropdown-item" wire:click="edit_model('{{ $model->id }}')"> <i class="ti ti-edit"></i> Editer</a>
                                            <a class="dropdown-item text-danger" wire:click="delete_model('{{ $model->id }}')"> <i class="ti ti-trash"></i> Supprimer</a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                        @endforeach
                    </div>
                </div>

            @endif

        </div>
        <div class="col-md-8">
            @if ($selected_model)
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">{{ $selected_model->name }}</div>
                        <div class="card-actions">
                            <button class="btn btn-primary" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight" aria-controls="offcanvasRight">
                                <i class="ti ti-plus"></i> Article
                            </button>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table ">
                            <thead>
                                <tr>
                                    <th scope="col">Désignation</th>
                                    <th scope="col" style="width: 10px"class="text-center">Qte/Coef</th>
                                    {{-- <th scope="col" style="width: 10px"class="text-center">Coef</th> --}}
                                    <th scope="col"  class="text-center">Prix</th>
                                    <th scope="col"  class="text-center">Total</th>
                                    <th scope="col"  class="text-center">Marge</th>
                                    <th scope="col" style="width: 10px" class="text-center">_</th>
                                </tr>
                            </thead>
                            @php
                                $total = 0;
                                $total_marge = 0;
                            @endphp

                            <tbody>
                                @foreach ($selected_model->rows->sortBy('priorite_id') as $row)
                                    @php
                                        $total += $row->quantite*$row->prix;
                                        $total_marge += $row->quantite*$row->coef*$row->prix;
                                    @endphp
                                    <tr class="">
                                        <td scope="row">
                                            <div class="row g-0">
                                                <div class="col-auto">
                                                    @isset ($row->article->image)
                                                    <img src="{{ asset($row->article->image) }}" alt="I" class="avatar avatar-sm me-2">
                                                    @else
                                                    <img src="{{ asset("img/icons/packaging.png") }}" alt="I"
                                                        class="avatar avatar-sm me-2 bg-white border border-white">
                                                    @endisset
                                                    <div class="text-center mt-2">{{ $row->article->priority_id ?? null }}</div>
                                                </div>
                                                <div class="col">
                                                    <div>
                                                        @if ($row->article_id)
                                                        <a href="{{ route('article',['article_id'=>$row->article_id]) }}" target="_blank">{{
                                                            $row->designation }}</a>
                                                        @else
                                                        {{ $row->designation }}
                                                        @endif

                                                    </div>
                                                    <div class="text-muted">{!! nl2br($row->reference) !!}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <div>{{ $row->quantite }}</div>
                                            <div>{{ $row->coef }}</div>
                                        </td>
                                        {{-- <td class="text-center">{{ $row->coef }}</td> --}}
                                        <td class="text-center">
                                            <div>{{ number_format($row->prix*$row->coef, 0,'.', ' ') }}</div>
                                            <div class="text-muted">{{ number_format($row->prix, 0,'.', ' ') }}</div>
                                        </td>
                                        <td class="text-center">
                                            <div>{{ number_format($row->prix*$row->quantite*$row->coef, 0,'.', ' ') }}</div>
                                            <div class="text-muted">{{ number_format($row->prix*$row->quantite, 0,'.', ' ') }}</div>
                                        </td>
                                        <td class="text-center">
                                            <div>{{ number_format($row->prix*$row->quantite*$row->coef -$row->prix*$row->quantite , 0,'.', '
                                                ') }}</div>
                                                <div class="badge mt-1">{{ $row->priority() }} </div>
                                        </td>
                                        <td class="text-center " style="vertical-align: middle;">
                                            <div>
                                                <button class="btn  btn-icon btn-outline-success btn-sm mb-2" wire:click="edit_row('{{ $row->id }}')"><i
                                                        class="ti ti-edit"></i></button>
                                                <button class="btn btn-icon btn-outline-danger btn-sm " wire:click="delete_row('{{ $row->id }}')"><i
                                                        class="ti ti-trash"></i></button>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                                <tr class="fw-bold">
                                    <td colspan="3">Total</td>
                                    <td colspan="4" class="text-end"> {{ number_format($total_marge, 0,'.', ' ') }} F</td>
                                </tr>
                                <tr class="fw-bold">
                                    <td colspan="3">Marge</td>
                                    <td colspan="4" class="text-end"> {{ number_format($total_marge- $total, 0,'.', ' ') }} F</td>
                                </tr>
                            </tbody>

                        </table>
                    </div>
                    <div class="card-footer">
                        <button class="btn btn-primary" wire:click="store_custom_article('Main d\'oeuvre')">Main d'oeuvre</button>
                        <button class="btn btn-primary" wire:click="store_custom_article('Accessoires')">Accessoires</button>
                    </div>
                </div>

            @endif
        </div>

    </div>

    @component('components.modal', ["id"=>'addSystem', 'title' => 'Ajouter un système', 'method'=>'store_system'])
        <form class="row" wire:submit="store_system">
            @include('_form.systeme_form')
        </form>
        <script> window.addEventListener('open-addSystem', event => { window.$('#addSystem').modal('show'); }) </script>
        <script> window.addEventListener('close-addSystem', event => { window.$('#addSystem').modal('hide'); }) </script>
    @endcomponent
    @component('components.modal', ["id"=>'editSystem', 'title' => 'Editer un système', 'method'=>'update_system'])
        <form class="row" wire:submit="update_system">
            @include('_form.systeme_form')
        </form>
        <script> window.addEventListener('open-editSystem', event => { window.$('#editSystem').modal('show'); }) </script>
        <script> window.addEventListener('close-editSystem', event => { window.$('#editSystem').modal('hide'); }) </script>
    @endcomponent

    @component('components.modal', ["id"=>'addModel', 'title' => 'Ajouter un modèle', 'method'=>'store_model'])
        <form class="row" wire:submit="store_model">
            @include('_form.system_model_form')
        </form>
        <script> window.addEventListener('open-addModel', event => { window.$('#addModel').modal('show'); }) </script>
        <script> window.addEventListener('close-addModel', event => { window.$('#addModel').modal('hide'); }) </script>
    @endcomponent
    @component('components.modal', ["id"=>'editModel', 'title' => 'Editer un système', 'method'=>'update_model'])
        <form class="row" wire:submit="update_model">
            @include('_form.system_model_form')
        </form>
        <script> window.addEventListener('open-editModel', event => { window.$('#editModel').modal('show'); }) </script>
        <script> window.addEventListener('close-editModel', event => { window.$('#editModel').modal('hide'); }) </script>
    @endcomponent

    @component('components.modal', ["id"=>'addArticle', 'title' => 'Ajouter un article', 'method'=>'add_article', 'class'=>'modal-xl'])
        <form class="row row-deck g-2" wire:submit="add_article">
            @foreach ($articles as $article)
                <div class="col-md-4" wire:click='store_article("{{ $article->id }}")'>
                    @include('_card.articleCard2', ['article'=> $article])
                </div>
            @endforeach
        </form>
        <script> window.addEventListener('open-addArticle', event => { window.$('#addArticle').modal('show'); }) </script>
        <script> window.addEventListener('close-addArticle', event => { window.$('#addArticle').modal('hide'); }) </script>
    @endcomponent

    @component('components.modal', ["id"=>'editRow', 'title' => 'Editer un champ', 'method'=>'update_row', 'class'=>'modal-lg'])
        <form class="row" wire:submit="update_row">
            @include('_form.invoice_row_form', ['nosection'=>true])
        </form>
        <script> window.addEventListener('open-editRow', event => { window.$('#editRow').modal('show'); }) </script>
        <script> window.addEventListener('close-editRow', event => { window.$('#editRow').modal('hide'); }) </script>
    @endcomponent

    <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasRight" aria-labelledby="offcanvasRightLabel" wire:ignore.self>
        <div class="offcanvas-header">
            <h5 id="offcanvasRightLabel">Articles</h5>
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <div>
                <div class="input-icon mb-2 position-sticky">
                    <input type="text" class="form-control form-control-rounded" wire:model.live="search" placeholder="Chercher ">
                    <span class="input-icon-addon">
                        <i class="ti ti-search"></i>
                    </span>
                </div>

                @foreach ($articles as $article)
                    <div class="mb-2" wire:click='store_article("{{ $article->id }}")'>
                        @include('_card.articleCard2', ['article'=> $article])
                    </div>
                @endforeach

            </div>
        </div>
    </div>


