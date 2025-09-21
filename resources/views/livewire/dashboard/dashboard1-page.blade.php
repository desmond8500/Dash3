<div>
    @component('components.layouts.page-header', ['title'=> 'Dashboard 1'])
        <button class='btn btn-primary' wire:click="$dispatch('open-webpageCategory')"> Catégories</button>
        <button class='btn btn-primary' wire:click="$dispatch('open-addWebpageCategory')"><i class='ti ti-plus'></i> Catégorie</button>
    @endcomponent

    <div class="row g-2">
        <div class="col-12 col-md-8">
            <div class="card">
                <div class="card-header">
                    <div class="card-title"> Pages </div>
                    <div class="card-actions">
                        <button class='btn btn-primary' wire:click="$dispatch('open-addWebpage')"><i class='ti ti-plus'></i> Siteweb </button>
                        @if ($edit_form)
                            <button class='btn btn-success btn-icon' wire:click="$toggle('edit_form')"><i class='ti ti-edit'></i> </button>
                        @else
                            <button class='btn btn-secondary btn-icon' wire:click="$toggle('edit_form')"><i class='ti ti-edit'></i> </button>
                        @endif
                    </div>
                </div>
                <div class="card-body">
                    <div class="row row-deck g-2">
                        <div class="col-md-12">
                            @if ($all)
                                <h2>Favoris</h2>
                            @else
                                <h2>{{ $categorie->name }}</h2>
                            @endif
                        </div>
                        @foreach($websites->sortBy('name') as $website)
                            <div class="col-6 col-md-2 ">
                                <div class="card bg-gray-50 ">
                                    <div class="text-center p-2">
                                        <a href="{{ $website->url ?? $website->webpage->url }}" target="_blank">
                                            <img src="{{ asset($website->logo ?? $website->webpage->logo ?? '') }}" alt="l" class="avatar avatar-xl p-1 bg-white" style="object-fit: contain">
                                        </a>
                                        <div class="mt-2">{{ $website->name ?? $website->webpage->name }}</div>
                                    </div>
                                    @if ($edit_form)
                                        <div class="text-center mb-1">
                                            <button class="btn btn-primary btn-sm" wire:click="edit('{{ $website->id ?? $website->webpage->id }}')">
                                                <i class="ti ti-edit"></i>
                                            </button>
                                            <button class="btn btn-danger btn-sm" wire:click="delete('{{ $website->id ?? $website->webpage->id }}')">
                                                <i class="ti ti-trash"></i>
                                            </button>
                                            @if ($website->favorite)
                                                <button class="btn btn-warning btn-sm" wire:click="favorite('{{ $website->id }}')">
                                                    <i class="ti ti-star"></i>
                                                </button>
                                            @else
                                                <button class="btn btn-secondary btn-sm" wire:click="favorite('{{ $website->id }}')">
                                                    <i class="ti ti-star"></i>
                                                </button>
                                            @endif

                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endforeach

                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="row g-2">
                <div class="col-md-10">
                    <div class="input-icon mb-3">
                        <input type="text" class="form-control form-control-rounded" wire:model.live="searchcat" placeholder="Chercher ">
                        <span class="input-icon-addon">
                            <i class="ti ti-search"></i>
                        </span>
                    </div>
                </div>
                <div class="col-md-2">
                    <button class="btn btn-primary" wire:click="set('all', 1)">Tous</button>
                </div>
                @foreach ($categories->sortBy('name') as $category)
                    <div class="col-md-6">
                        <div @class(['card p-1', 'bg-primary text-white'=>$selected == $category->id])>
                            <div class="row align-items-center" >
                                <div class="col cursor-pointer" wire:click="selectCategory('{{ $category->id }}')">
                                    <div class="fw-bold">{{ $category->name }}</div>
                                </div>
                                <div class="col-auto ">
                                    <div class="dropdown open ">
                                        <button @class(['btn btn-action', 'text-white'=>$selected == $category->id]) type="button" id="triggerId" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" >
                                            <i class="ti ti-chevron-down"></i>
                                        </button>
                                        <div class="dropdown-menu" aria-labelledby="triggerId">
                                            <a class="dropdown-item" wire:click="edit_category('{{ $category->id }}')"> <i class="ti ti-edit"></i> Editer</a>
                                            <a class="dropdown-item text-danger" wire:click="delete_category('{{ $category->id }}')"> <i class="ti ti-trash"></i> Supprimer</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

    </div>

    @component('components.modal', ["id"=>'addWebpageCategory', 'title' => 'Ajouter une catégorie', 'method'=>'store_category'])
        <form class="row" wire:submit="store_category">
            @include('_form.webpage_category_form')
        </form>
        <script> window.addEventListener('open-addWebpageCategory', event => { window.$('#addWebpageCategory').modal('show'); }) </script>
        <script> window.addEventListener('close-addWebpageCategory', event => { window.$('#addWebpageCategory').modal('hide'); }) </script>
    @endcomponent
    @component('components.modal', ["id"=>'editWebpageCategory', 'title' => 'Editer une catégorie', 'method'=>'update_category'])
        <form class="row" wire:submit="update_category">
            @include('_form.webpage_category_form')
        </form>
        <script> window.addEventListener('open-editWebpageCategory', event => { window.$('#editWebpageCategory').modal('show'); }) </script>
        <script> window.addEventListener('close-editWebpageCategory', event => { window.$('#editWebpageCategory').modal('hide'); }) </script>
    @endcomponent
    @component('components.modal', ["id"=>'webpageCategory', 'title' => 'Sélectionner une catégorie'])
        <div class="row" >
            <div class="col-md-12">
                <div class="input-icon mb-3">
                    <input type="text" class="form-control form-control-rounded" wire:model.live="searchcat" placeholder="Chercher ">
                    <span class="input-icon-addon">
                        <i class="ti ti-search"></i>
                    </span>
                </div>
            </div>
            <div class="col-md-6">
                <button class="btn btn-primary" wire:click="set('all', 1)">Tous</button>
            </div>
            @foreach ($categories->sortBy('name') as $category)
                <div class="col-md-6">
                    <div class="card p-2 mb-2 ">
                        <div class="row">
                            <div class="col cursor-pointer" wire:click="selectCategory('{{ $category->id }}')">
                                <div class="card-title">{{ $category->name }}</div>
                            </div>
                            <div class="col-auto ">
                                <div>
                                    <button class="btn btn-outline-primary btn-sm" wire:click="edit_category('{{ $category->id }}')">
                                        <i class="ti ti-edit"></i>
                                    </button>
                                    <button class="btn btn-outline-danger btn-sm" wire:click="edit_category('{{ $category->id }}')">
                                        <i class="ti ti-trash"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach


        </div>
        <script> window.addEventListener('open-webpageCategory', event => { window.$('#webpageCategory').modal('show'); }) </script>
        <script> window.addEventListener('close-webpageCategory', event => { window.$('#webpageCategory').modal('hide'); }) </script>
    @endcomponent



    @component('components.modal', ["id"=>'addWebpage', 'title' => 'Ajouter un Site Web', 'method'=>'store'])
        <form class="row" wire:submit="store">
            @include('_form.webpage_form')
        </form>
        <script> window.addEventListener('open-addWebpage', event => { window.$('#addWebpage').modal('show'); }) </script>
        <script> window.addEventListener('close-addWebpage', event => { window.$('#addWebpage').modal('hide'); }) </script>
    @endcomponent
    @component('components.modal', ["id"=>'editWebpage', 'title' => 'Editer un Site Web', 'method'=>'update'])
        <form class="row" wire:submit="update">
            @include('_form.webpage_form')
        </form>
        <script> window.addEventListener('open-editWebpage', event => { window.$('#editWebpage').modal('show'); }) </script>
        <script> window.addEventListener('close-editWebpage', event => { window.$('#editWebpage').modal('hide'); }) </script>
    @endcomponent
</div>
