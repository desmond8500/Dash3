<div>
    @component('components.layouts.page-header', ['title'=> "Articles", 'breadcrumbs'=> $breadcrumbs])
        <div class="btn-list">
            @livewire('form.article-add')
            @livewire('form.provider-add')
            @livewire('form.brand-add')
            <button class="btn btn-dark btn-icon disabled" >
                <i class="ti ti-layout-grid"></i>
            </button>
            <button class="btn btn-dark btn-icon disabled" >
                <i class="ti ti-layout-list"></i>
            </button>
        </div>
    @endcomponent

    <div class="row g-2">
        <div class="col-md-3">
            <div class="mb-1">
                <div class="input-group">
                    <input type="text" class="form-control" wire:model.live="search" placeholder="Trouver un article">

                    <button class="btn btn-icon" wire:click='reset_filter()'><i class="ti ti-reload"></i> </button>
                </div>
            </div>

            <div class="card">

                <div wire:ignore.self>
                    <div class="accordion accordion-flush" id="accordionFlushExample">
                        @component('components.accordion-item',['id'=> 'brand', 'title'=>"Marques"])
                            {{-- <div class="input-icon">
                                <input type="text" class="form-control form-control-rounded" wire:model.live="search_brand" placeholder="Chercher ">
                                <span class="input-icon-addon">
                                    <i class="ti ti-search"></i>
                                </span>
                            </div> --}}
                            @foreach ($brands->sortby('name') as $brand)
                                @if ($brand_id == $brand->id)
                                    <button class="btn btn-primary btn-sm rounded mb-1" wire:click="$set('brand_id','{{ $brand->id }}')">{{ $brand->name }}</button>
                                @else
                                    <button class="btn btn-outline-primary btn-sm rounded mb-1" wire:click="$set('brand_id','{{ $brand->id }}')">{{ $brand->name }}</button>
                                @endif
                            @endforeach
                        @endcomponent
                        @component('components.accordion-item',['id'=> 'provider', 'title'=>"Fournisseurs"])
                            @foreach ($providers->sortby('name') as $provider)
                                @if ($provider_id == $provider->id)
                                    <button class="btn btn-primary btn-sm rounded mb-1" wire:click="$set('provider_id','{{ $provider->id }}')">{{ $provider->name }}</button>
                                @else
                                    <button class="btn btn-outline-primary btn-sm rounded mb-1" wire:click="$set('provider_id','{{ $provider->id }}')">{{ $provider->name }}</button>
                                @endif
                            @endforeach
                        @endcomponent
                        @component('components.accordion-item',['id'=> 'priorite', 'title'=>"Priorités"])
                            @foreach ($priorites as $priorite)
                                @if ($priorite_id == $priorite->id)
                                    <button class="btn btn-primary btn-sm rounded mb-1" wire:click="$set('priorite_id','{{ $priorite->id }}')">{{ $priorite->name }}</button>
                                @else
                                    <button class="btn btn-outline-primary btn-sm rounded mb-1" wire:click="$set('priorite_id','{{ $priorite->id }}')">{{ $priorite->name }}</button>
                                @endif
                            @endforeach
                        @endcomponent
                        @component('components.accordion-item',['id'=> 'type', 'title'=>"Types"])
                            <div class="">
                                @foreach ($tags as $tag)
                                <span class="badge bg-primary cursor-pointer text-light mb-1" wire:click="$set('tag','{{ $tag->name }}')">
                                    {{ $tag->name }}
                                </span>
                                @endforeach
                            </div>
                        @endcomponent

                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-9">
            <div class="row row-deck g-2">
                @foreach ($articles as $article)
                    <div class="col-md-6">
                        @include('_card.articleCard',[
                            'edit' => true
                        ])
                    </div>
                @endforeach
                <div class="col-md-12">
                    {{ $articles->links() }}
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
</div>
