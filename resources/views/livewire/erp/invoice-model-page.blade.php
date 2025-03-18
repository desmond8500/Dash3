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

        <div class="col-md-3">
            @if ($selected_system)
                <div class="card mb-3">
                    <div class="card-header">
                        <div class="card-title">{{ $selected_system->name }}</div>
                    </div>
                    <div class="p-2">
                        @foreach ($selected_system->models as $model)
                        <div class="border rounded p-1 mb-1">
                            <div class="row g-1 align-items-center">
                                <a wire:click="select_model('{{ $model->id }}')" class="col">{{ $model->name }}</a>
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


            {{-- <div class="card">
                <div class="card-header">
                    <div class="card-title">Systèmes</div>
                    <div class="card-actions">

                    </div>
                </div>
                <div class="accordion" id="accordionExample">
                    @foreach ($systems as $system)
                        @component('components.accordion-item',['title'=>$system->name, 'id'=> "id$system->id"])
                            <div class="row g-1">
                                <div class="col"></div>
                                <div class="col-auto">
                                    <a class="btn btn-primary btn-icon" wire:click="edit_system('{{ $system->id }}')">
                                        <i class="ti ti-edit"></i>
                                    </a>
                                </div>
                                <div class="col-auto">
                                    <a class="btn btn-primary btn-icon" wire:click="add_model('{{ $system->id }}')">
                                        <i class="ti ti-plus"></i>
                                    </a>
                                </div>
                                @foreach ($system->models as $model)
                                    <div class="border rounded p-1">
                                        <div class="row g-1 align-items-center">
                                            <a wire:click="select_model('{{ $model->id }}')" class="col">{{ $model->name }}</a>
                                            <div class="col-auto">
                                                <span class="btn btn-ghost-success btn-icon" wire:click="edit_model('{{ $model->id }}')">
                                                    <i class="ti ti-edit"></i>
                                                </span>
                                                <span class="btn btn-ghost-danger btn-icon" wire:click="delete_model('{{ $model->id }}')">
                                                    <i class="ti ti-trash"></i>
                                                </span>
                                            </div>
                                        </div>

                                    </div>
                                @endforeach

                            </div>
                        @endcomponent
                    @endforeach
                </div>
            </div> --}}


        </div>
        <div class="col-md-6">
            @if ($selected_model)
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">{{ $selected_model->name }}</div>
                        <div class="card-actions">
                            <button class="btn btn-primary" wire:click="add_article">
                                <i class="ti ti-plus"></i> Article
                            </button>
                        </div>
                    </div>
                    <div class="card-body">

                    </div>
                    <div class="card-footer">

                    </div>
                </div>

            @endif
        </div>
        <div class="col-md-3">
            <div class="row row-deck g-2">
                <div class="col-md-12">
                    <div class="input-icon">
                        <input type="text" class="form-control form-control-rounded" wire:model.live="search" placeholder="Chercher ">
                        <span class="input-icon-addon">
                            <i class="ti ti-search"></i>
                        </span>
                    </div>
                </div>

                @foreach ($articles as $article)
                    <div class="col-md-12">
                        @include('_card.articleCard2', ['article'=> $article])
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    @component('components.modal', ["id"=>'addSystem', 'title' => 'Ajouter un système'])
        <form class="row" wire:submit="store_system">
            @include('_form.systeme_form')
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                <button type="submit" class="btn btn-primary">Valider</button>
            </div>
        </form>
        <script> window.addEventListener('open-addSystem', event => { window.$('#addSystem').modal('show'); }) </script>
        <script> window.addEventListener('close-addSystem', event => { window.$('#addSystem').modal('hide'); }) </script>
    @endcomponent
    @component('components.modal', ["id"=>'editSystem', 'title' => 'Editer un système'])
        <form class="row" wire:submit="update_system">
            @include('_form.systeme_form')
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                <button type="submit" class="btn btn-primary">Valider</button>
            </div>
        </form>
        <script> window.addEventListener('open-editSystem', event => { window.$('#editSystem').modal('show'); }) </script>
        <script> window.addEventListener('close-editSystem', event => { window.$('#editSystem').modal('hide'); }) </script>
    @endcomponent

    @component('components.modal', ["id"=>'addModel', 'title' => 'Ajouter un modèle'])
        <form class="row" wire:submit="store_model">
            @include('_form.system_model_form')
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                <button type="submit" class="btn btn-primary">Valider</button>
            </div>
        </form>
        <script> window.addEventListener('open-addModel', event => { window.$('#addModel').modal('show'); }) </script>
        <script> window.addEventListener('close-addModel', event => { window.$('#addModel').modal('hide'); }) </script>
    @endcomponent
    @component('components.modal', ["id"=>'editModel', 'title' => 'Editer un système'])
        <form class="row" wire:submit="update_model">
            @include('_form.system_model_form')
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                <button type="submit" class="btn btn-primary">Valider</button>
            </div>
        </form>
        <script> window.addEventListener('open-editModel', event => { window.$('#editModel').modal('show'); }) </script>
        <script> window.addEventListener('close-editModel', event => { window.$('#editModel').modal('hide'); }) </script>
    @endcomponent

    @component('components.modal', ["id"=>'addArticle', 'title' => 'Ajouter un article', 'method'=>'add_article', 'class'=>'modal-xl'])
        <form class="row row-deck g-2" wire:submit="add_article">
            @foreach ($articles as $article)
                <div class="col-md-4">
                    @include('_card.articleCard2', ['article'=> $article])
                </div>
            @endforeach

        </form>
        <script> window.addEventListener('open-addArticle', event => { window.$('#addArticle').modal('show'); }) </script>
        <script> window.addEventListener('close-addArticle', event => { window.$('#addArticle').modal('hide'); }) </script>
    @endcomponent


