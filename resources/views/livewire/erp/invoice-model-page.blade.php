<div>
    @component('components.layouts.page-header', ['title'=> 'Modèle de devis', 'breadcrumbs'=> $breadcrumbs])

    @endcomponent

    <div class="row g-2">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">Systèmes</div>
                    <div class="card-actions">
                        <button class='btn btn-primary' wire:click="$dispatch('open-addSystem')"><i class='ti ti-plus'></i> Système</button>
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
            </div>


        </div>
        <div class="col-md-8">
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
    </div>

    @component('components.modal', ["id"=>'addSystem', 'title' => 'Ajouter un système'])
        <form class="row" wire:submit="store_system">
            @include('_form.systeme_form')
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                <button type="submit" class="btn btn-primary">Valider</button>
            </div>
        </form>
        <script> window.addEventListener('open-addSystem', event => { $('#addSystem').modal('show'); }) </script>
        <script> window.addEventListener('close-addSystem', event => { $('#addSystem').modal('hide'); }) </script>
    @endcomponent
    @component('components.modal', ["id"=>'editSystem', 'title' => 'Editer un système'])
        <form class="row" wire:submit="update_system">
            @include('_form.systeme_form')
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                <button type="submit" class="btn btn-primary">Valider</button>
            </div>
        </form>
        <script> window.addEventListener('open-editSystem', event => { $('#editSystem').modal('show'); }) </script>
        <script> window.addEventListener('close-editSystem', event => { $('#editSystem').modal('hide'); }) </script>
    @endcomponent

    @component('components.modal', ["id"=>'addModel', 'title' => 'Ajouter un modèle'])
        <form class="row" wire:submit="store_model">
            @include('_form.system_model_form')
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                <button type="submit" class="btn btn-primary">Valider</button>
            </div>
        </form>
        <script> window.addEventListener('open-addModel', event => { $('#addModel').modal('show'); }) </script>
        <script> window.addEventListener('close-addModel', event => { $('#addModel').modal('hide'); }) </script>
    @endcomponent
    @component('components.modal', ["id"=>'editModel', 'title' => 'Editer un système'])
        <form class="row" wire:submit="update_model">
            @include('_form.system_model_form')
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                <button type="submit" class="btn btn-primary">Valider</button>
            </div>
        </form>
        <script> window.addEventListener('open-editModel', event => { $('#editModel').modal('show'); }) </script>
        <script> window.addEventListener('close-editModel', event => { $('#editModel').modal('hide'); }) </script>
    @endcomponent

    @component('components.modal', ["id"=>'addArticle', 'title' => 'Editer un système'])
        <form class="row" wire:submit="update_model">
            @include('_form.system_model_form')
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                <button type="submit" class="btn btn-primary">Valider</button>
            </div>
        </form>
        <script> window.addEventListener('open-addArticle', event => { $('#addArticle').modal('show'); }) </script>
        <script> window.addEventListener('close-addArticle', event => { $('#addArticle').modal('hide'); }) </script>
    @endcomponent
</div>
