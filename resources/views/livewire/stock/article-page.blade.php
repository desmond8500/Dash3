<div>
    @component('components.layouts.page-header', ['title'=> 'Article', 'breadcrumbs'=> $breadcrumbs])
        <div class="btn-list">
            @livewire('form.provider-add')
            @livewire('form.brand-add')
        </div>

    @endcomponent

    <div class="row g-2">

        <div class="col-md-4">
            <div class="card">
                <div class="card-body-sm">
                    <div class="d-block d-sm-none">
                        <img src="{{ asset("$article->image") }}" class="ratio ratio-1x1 rounded p-2"   alt="">
                    </div>
                    <div class="d-none d-sm-block">
                        <img src="{{ asset("$article->image") }}" class="ratio ratio-1x1 rounded p-2"   alt="">
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="row g-2">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title">{{ $article->designation }}</div>
                            <div class="card-actions">
                                <button class="btn btn-primary btn-icon" wire:click="edit('{{ $article->id }}')">
                                    <i class="ti ti-edit"></i>
                                </button>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item d-flex justify-content-between">
                                        <b>Référence :</b> {{ $article->reference }}
                                    </li>

                                    <li class="list-group-item d-flex justify-content-between {{ $article->quantity <= $article->quantity_min ? 'text-danger' : '' }}">
                                        <b class="">Quantité :</b> {{ $article->quantity }}
                                    </li>

                                    <li class="list-group-item d-flex justify-content-between">
                                        <b>Prix :</b> {{ number_format($article->price, 0, '.', ' ') }} CFA
                                    </li>
                                </ul>
                            </div>
                            <div class="col-md-6">
                                <ul class="list-group list-group-flush">
                                    @if ($article->brand)
                                        <li class="list-group-item d-flex justify-content-between">
                                            <b>Marque :</b> {{ $article->brand->name }}
                                        </li>
                                    @endif
                                    @if ($article->provider)
                                        <li class="list-group-item d-flex justify-content-between">
                                            <b>Fournisseur :</b>
                                            {{ $article->provider->name }}
                                        </li>
                                    @endif
                                    <li class="list-group-item d-flex justify-content-between">
                                        <b>Priorité :</b> {{ $article->priority() }}
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title">Images</div>
                            <div class="card-actions">
                                <div class="input-group mt-2">
                                    <div wire:loading>
                                        <div class="d-flex justify-content-between">
                                            <div>Chargement <span class="animated-dots"></div>
                                        </div>
                                    </div>
                                    <input type="file" id="file" class="form-control" accept="image/*" multiple wire:model="images">
                                    <button class="btn btn-primary" wire:click="store_files">Ajouter images</button>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row g-1">
                                @foreach ($article->images() as $image)
                                    <div class="col-2">
                                        <div class="border rounded p-1 text-center bg-white">
                                            <img src="{{ asset("storage/$image") }}" class="avatar avatar-md " alt="">
                                            <div class="d-flex-between mt-2">
                                                <i class="ti ti-trash btn btn-sm btn-outline-danger rounded" wire:click="unset_image('{{ $image }}')" data-bs-toggle="tooltip" title="Supprimer l'image"></i>
                                                <i class="ti ti-plus btn btn-sm btn-outline-primary rounded" wire:click="set_image('{{ $image }}')" data-bs-toggle="tooltip" title="Définir comme image par défaut"></i>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>


                    </div>
                </div> --}}

                <div class="col-md-6">
                    @livewire('stock.article-documents', ['article_id' => $article->id])
                </div>

                <div class="col-md-6">
                    @livewire('stock.article-links', ['article_id' => $article->id])
                </div>

            </div>

        </div>

    </div>

    @component('components.modal', ["id"=>'editArticle', 'title'=>'Editer un article'])
        <form class="row" wire:submit="update">
            @include('_form.article_form')
            <div class="modal-footer">
                <button type="button" class="btn btn-danger me-auto" wire:click='delete'>
                    <i class="ti ti-trash"></i>
                </button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                <button type="submit" class="btn btn-primary">Valider</button>
            </div>
        </form>
        <script> window.addEventListener('open-editArticle', event => { $('#editArticle').modal('show'); }) </script>
        <script> window.addEventListener('close-editArticle', event => { $('#editArticle').modal('hide'); }) </script>
    @endcomponent


</div>
