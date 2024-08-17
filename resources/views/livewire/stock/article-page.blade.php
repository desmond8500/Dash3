<div>
    @component('components.layouts.page-header', ['title'=> 'Article', 'breadcrumbs'=> $breadcrumbs])
        <div class="btn-list">
            @livewire('form.provider-add')
            @livewire('form.brand-add')
            <button class="btn btn-icon" wire:click='$refresh'><i class="ti ti-reload"></i> </button>
        </div>

    @endcomponent

    <div class="row g-2">

        <div class="col-md-4">
            <div class="card">
                <div class="card-body-sm">
                    <img src="{{ asset("$article->image") }}" class="ratio ratio-1x1 rounded p-2"   alt="">
                </div>
                <div class="card-footer">
                    @foreach ($article->images() as $image)
                        <img src="{{ asset("storage/$image") }}" class="avatar avatar-md border-dark mt-1 border" alt="">
                    @endforeach
                    <input type="file" id="file" accept="image/*" multiple style="display: none" wire:model="files">
                    <label for="file" href="#" class="avatar avatar-upload rounded">
                        <i class="ti ti-plus"></i>
                        <span class="avatar-upload-text">Ajouter</span>
                    </label>
                    @if ($files)
                        <button class="btn btn-primary" wire:click="store_files">Ajouter</button>
                    @endif
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
                                <button class="btn btn-primary btn-icon" wire:click="$dispatch('open-editArticle')">
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
