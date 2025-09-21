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

            <div class="card mt-2">
                <div class="card-header">
                    <div class="card-title">Tags</div>
                    <div class="card-actions">
                        <button class='btn btn-primary' wire:click="$dispatch('open-attachTag')"><i class='ti ti-plus'></i> Tag </button>
                    </div>
                </div>
                @if (!$article->tags->isEmpty())
                    <div class="p-2">
                        @foreach ($article->tags->sortBy('name') as $tag)
                            <span class="badge bg-primary text-light me-1 mb-1">
                                {{ $tag->name }}
                                <i class="ti ti-x cursor-pointer" wire:click="detach_tag('{{ $tag->name }}')"></i>
                            </span>
                        @endforeach
                    </div>
                @endif
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
                                            <b>Marque :</b> <a href="{{ route('brand', ['brand_id'=>$article->brand->id]) }}">{{ $article->brand->name }}</a>
                                        </li>
                                    @endif
                                    @if ($article->provider)
                                        <li class="list-group-item d-flex justify-content-between">
                                            <b>Fournisseur :</b>
                                            <a href="{{ route('provider', ['provider_id'=>$article->provider->id]) }}">
                                                {{ $article->provider->name }}
                                            </a>
                                        </li>
                                    @endif
                                    <li class="list-group-item d-flex justify-content-between">
                                        <b>Priorité :</b> {{ $article->priority() }}
                                    </li>
                                </ul>
                            </div>
                            <div class="col-md-12">
                                <div class="p-2">
                                    <h3>Description</h3>
                                    {!! nl2br($article->description) !!}
                                </div>
                            </div>
                            @if ($article->spec)
                            <div class="col-md-12 ">
                                <div class="p-2">
                                    <h3>Spécifications techniques</h3>
                                    {!! nl2br($article->spec) !!}
                                </div>
                            </div>
                            @endif
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
                        <div class="p-2">
                            <div class="row g-1">
                                @foreach ($article->images() as $image)
                                    <div class="col-4 col-xs-4 col-sm-4 col-md-2">
                                        <div class="border rounded p-1 text-center bg-white">
                                            <a href="{{ asset("storage/$image") }}" data-lightbox="avatarlist">
                                                <img src="{{ asset("storage/$image") }}" class="avatar avatar-xl " alt="">
                                            </a>
                                            <div class="d-flex-between mt-2">
                                                <i class="ti ti-trash btn  btn-ghost-danger rounded" wire:click="unset_image('{{ $image }}')" data-bs-toggle="tooltip" title="Supprimer l'image"></i>
                                                <i class="ti ti-photo btn  btn-ghost-primary rounded" wire:click="set_image('{{ $image }}')" data-bs-toggle="tooltip" title="Définir comme image par défaut"></i>
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
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title">Articles associés</div>
                            <div class="card-actions">
                                <button class='btn btn-primary' wire:click="$dispatch('open-addLinkedArticle')"><i class='ti ti-plus'></i> Article </button>
                            </div>
                        </div>
                        @if (!$dependances->isEmpty())
                            <div class="card-body">
                                <div class="row row-deck g-2">
                                    @foreach ($dependances as $dependance)
                                        <div class="col-md-4">
                                            <div>
                                                @include('_card.articleCard1', ['item' => $dependance->dependence])
                                                <div class="d-flex justify-content-between align-items-center mt-2">
                                                    <button class="btn btn-outline-danger btn-icon" wire:click="remove_dependance({{ $dependance->id }})">
                                                        <i class="ti ti-trash"></i>
                                                    </button>
                                                    <div>
                                                        <button class="btn btn-icon btn-primary" wire:click="increase_dependance('{{ $dependance->id }}')"><i class="ti ti-plus"></i></button>
                                                        <div class="btn">{{ $dependance->quantity }}</div>
                                                        <button class="btn btn-icon btn-primary" wire:click="decrease_dependance('{{ $dependance->id }}')"><i class="ti ti-minus"></i></button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>


                            </div>
                        @endif
                    </div>
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
                    <a class="badge bg-primary text-white mb-1 cursor-pointer" wire:click="attach_tag('{{ $tag->name }}')"> {{ ucfirst($tag->name) }}</a>
                @endforeach
            </div>
        </div>

        <script> window.addEventListener('open-attachTag', event => { window.$('#attachTag').modal('show'); }) </script>
        <script> window.addEventListener('close-attachTag', event => { window.$('#attachTag').modal('hide'); }) </script>
    @endcomponent

    @component('components.modal', ["id"=>'addLinkedArticle', 'title' => 'Tags'])
        <div class="row row-deck g-2">
            <div class="col-md-12">
                <input type="text" class="form-control" wire:model.live='article_search' placeholder="Rechercher un article">
            </div>
            @foreach ($articles as $article)
                <div class="col-md-4 cursor-pointer" wire:click="add_dependence({{ $article->id }})">
                    <div class="border border-1 rounded p-2">
                        <div class="row">
                            <div class="col-md-12">
                                <img src="{{ asset($article->image) }}" alt="" max-height="50px" class="rounded">
                            </div>
                            <div class="col-md-12 fw-bold" style="height: 50px">
                                {{ $article->designation }}
                            </div>
                            <div class="text-muted" style="height: 50px">
                                {{ $article->reference }}
                            </div>
                            <div class="text-end text-danger fw-bold ">
                                {{ $article->price }} F
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
            <div class="col-md-12 mt-3">
                {{ $articles->links() }}
            </div>
        </div>

        <script> window.addEventListener('open-addLinkedArticle', event => { window.$('#addLinkedArticle').modal('show'); }) </script>
        <script> window.addEventListener('close-addLinkedArticle', event => { window.$('#addLinkedArticle').modal('hide'); }) </script>
    @endcomponent




</div>
