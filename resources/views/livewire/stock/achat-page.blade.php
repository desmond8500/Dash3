<div>
    @component('components.layouts.page-header', ['title'=>'Achat', 'breadcrumbs'=>$breadcrumbs])
        {{-- @livewire('form.achat-add') --}}
    @endcomponent

    <div class="row g-2">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">{{ $achat->name }}</div>
                    <div class="card-actions">
                        <button class="btn btn-primary btn-icon" wire:click="edit('{{ $achat->id }}')">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-edit" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"> <path stroke="none" d="M0 0h24v24H0z" fill="none"></path> <path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1"></path> <path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z"></path> <path d="M16 5l3 3"></path> </svg>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    {{ nl2br($achat->description) }}
                </div>
            </div>

        </div>
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">Liste des articles</div>
                    <div class="card-actions">
                        <button class="btn btn-primary" wire:click="dispatch('open-addAchatArticle')" > <i class="ti ti-plus"></i> article </button>
                    </div>
                </div>
                <table class="table">
                    <thead>
                        <tr>
                            <td>#</td>
                            <td>Désignation</td>
                            <td>Quantité</td>
                            <td>Prix HT</td>
                            <td>TVA</td>
                            <td>Prix TTC</td>
                            <td>Total</td>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($achat->rows as $row)
                            <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="card-body">

                </div>
                <div class="card-footer">

                </div>
            </div>

            @component('components.modal', ["id"=>'addAchatArticle', 'title'=> "Ajouter un article à l'achat", 'class'=>'modal-xl'])
                <form class="row" wire:submit="register">

                    @foreach ($articles as $article)
                        <div class="col-md-4">
                            <div class="card p-2">
                                <div class="row">
                                    <div class="col-auto">
                                        <img src="" alt="A" class="avatar avatar-md">
                                    </div>
                                    <div class="col">
                                        <div class="card-title">Titre</div>
                                        <div class="text-muted">Description</div>
                                    </div>
                                    <div class="col-auto">
                                      <button class="btn btn-outline-primary btn-icon" >
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-pencil" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"> <path stroke="none" d="M0 0h24v24H0z" fill="none"></path> <path d="M4 20h4l10.5 -10.5a1.5 1.5 0 0 0 -4 -4l-10.5 10.5v4"></path> <path d="M13.5 6.5l4 4"></path> </svg>
                                      </button>
                                  </div>
                                </div>
                            </div>
                        </div>
                    @endforeach

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                    </div>
                </form>
                <script> window.addEventListener('open-addAchatArticle', event => { $('#addAchatArticle').modal('show'); }) </script>
                <script> window.addEventListener('close-addAchatArticle', event => { $('#addAchatArticle').modal('hide'); }) </script>
            @endcomponent

        </div>
    </div>

    @component('components.modal', ["id"=>'editAchat', 'title'=>"Editer l'achat"])
        <form class="row" wire:submit="update">
            @include('_form.achat_form')
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                <button type="submit" class="btn btn-primary">Valider</button>
            </div>
        </form>
        <script> window.addEventListener('open-editAchat', event => { $('#editAchat').modal('show'); }) </script>
        <script> window.addEventListener('close-editAchat', event => { $('#editAchat').modal('hide'); }) </script>
    @endcomponent
</div>
