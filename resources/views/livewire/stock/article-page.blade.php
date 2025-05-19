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
                    <a href="{{ asset($article->image) }}" data-lightbox="avatar"  class="d-block d-sm-none">
                        <img src="{{ asset($article->image) }}" class="ratio ratio-1x1 rounded p-2"  alt="">
                    </a>
                    <a href="{{ asset($article->image) }}" data-lightbox="avatar"  class="d-none d-sm-block">
                        <img src="{{ asset($article->image) }}" class="ratio ratio-1x1 rounded p-2"  alt="">
                    </a>
                </div>
            </div>

            <div class="my-2">
                @foreach ($article->tags->sortBy('name') as $tag)
                    <span class="badge bg-primary text-light me-1 mb-1">
                        {{ $tag->name }}
                        <i class="ti ti-x cursor-pointer" wire:click="detach_tag('{{ $tag->name }}')"></i>
                    </span>
                @endforeach
            </div>

           <button class='btn btn-primary' wire:click="$dispatch('open-attachTag')"><i class='ti ti-plus'></i> Ajouter un
                tag
            </button>

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

                <div class="col-md-12">
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
                                            <a href="{{ asset("storage/$image") }}" data-lightbox="avatarlist">
                                                <img src="{{ asset("storage/$image") }}" class="avatar avatar-md " alt="">
                                            </a>
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

    @component('components.modal', ["id"=>'editArticle', 'title'=>'Editer un article', 'method'=>'update'])
        <form class="row" wire:submit="update">
            @include('_form.article_form')
        </form>
        <script> window.addEventListener('open-editArticle', event => { window.$('#editArticle').modal('show'); }) </script>
        <script> window.addEventListener('close-editArticle', event => { window.$('#editArticle').modal('hide'); }) </script>
    @endcomponent

    {{-- <button class='btn btn-primary' wire:click="$dispatch('open-addTag')" ><i class='ti ti-plus'></i> Ajouter un tag</button>

    @component('components.modal', ["id"=>'addTag', 'title' => 'Ajouter un Tag', 'method' => 'add_tag'])

        @foreach ($tags as $tag)
            <a class="badge bg-primary text-white" wire:click="attach_tag('{{ $tag->name }}')"> {{ $tag->name }}</a>
        @endforeach

        <script> window.addEventListener('open-addTag', event => { window.$('#addTag').modal('show'); }) </script>
        <script> window.addEventListener('close-addTag', event => { window.$('#addTag').modal('hide'); }) </script>
    @endcomponent --}}



    @component('components.modal', ["id"=>'attachTag', 'title' => 'Tags'])
        <div class="row g-1">
            <div class="col">
                <input type="text" class="form-control" wire:model='tag_name' placeholder="Ajouter  un tag">
            </div>
            <div class="col-auto">
                <button class="btn btn-primary" wire:click="add_tag()">
                    <i class="ti ti-plus"></i> Ajouter un nouveau Tag
                </button>
            </div>
            <div class="col-md-12">
                @foreach ($tags->sortBy('name') as $tag)
                    <a class="badge bg-primary text-white" wire:click="attach_tag('{{ $tag->name }}')"> {{ $tag->name }}</a>
                @endforeach

            </div>
        </div>


        <script> window.addEventListener('open-attachTag', event => { window.$('#attachTag').modal('show'); }) </script>
        <script> window.addEventListener('close-attachTag', event => { window.$('#attachTag').modal('hide'); }) </script>
    @endcomponent


</div>
