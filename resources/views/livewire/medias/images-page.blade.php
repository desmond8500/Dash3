<div>
    @component('components.layouts.page-header', ['title'=> 'Images', 'breadcrumbs'=>$breadcrumbs])
        <button class="btn btn-primary" wire:click="$dispatch('open-addImages')">
            <i class="ti ti-plus"></i> Images
        </button>
    @endcomponent

    <div class="row g-2">
        <div class="col-md-2">

            <div class="input-icon">
                <input type="text" class="form-control form-control-rounded" wire:model.live="search" placeholder="Chercher ">
                <span class="input-icon-addon">
                    <i class="ti ti-search"></i>
                </span>
            </div>

            <hr>
            <h2>Tags</h2>

        </div>
        <div class="col-md-7">
            <div class="card card-body">
                <div class="row row-deck align-items-center g-2">
                    @foreach ($images as $image)
                        <div class="col-md-2" wire:click="select_image('{{ $image->id }}')">
                            <div class="border rounded p-1">
                                <img src="{{ asset($image->path) }}" alt="IMG" class="img-fluid">
                            </div>
                        </div>
                    @endforeach

                </div>
                <div class="mt-3">
                    {{ $images->links() }}
                </div>

            </div>
        </div>

        <div class="col-md-3">
            @if ($selected_image)
                <div class="card p-2">
                    <img src="{{ asset($selected_image->path) }}" class="img-fluid " alt="">
                </div>


                <div class="card mt-2">
                    <div class="card-header">
                        <ul class="nav nav-tabs card-header-tabs nav-fill" data-bs-toggle="tabs">
                            <li class="nav-item">
                                <a href="#tabs-home-ex5" class="nav-link active" data-bs-toggle="tab">
                                    Détails
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="#tabs-profile-ex5" class="nav-link" data-bs-toggle="tab">
                                    Actions
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div class="card-body">
                        <div class="tab-content">
                            <div class="tab-pane active show" id="tabs-home-ex5">
                                <h4>Détails</h4>
                                <div>
                                    <div class="row mb-2">
                                        <div class="col-12">{{ $selected_image->name }}</div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col-3 fw-bold">Taille:</div>
                                        <div class="col-9">{{ $selected_image->size }} octets</div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col-3 fw-bold">Type:</div>
                                        <div class="col-9">{{ $selected_image->type }}</div>
                                    </div>

                                </div>
                            </div>
                            <div class="tab-pane" id="tabs-profile-ex5">
                                <button class="btn btn-danger" wire:click="delete()">Supprimer</button>
                                <button class="btn btn-primary" wire:click="addTag()">
                                    <i class="ti ti-plus"></i> Tag
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

            @endif


        </div>

    </div>

    @component('components.modal', ["id"=>'addImages', 'title' => 'Ajouter une ou des images', 'method' => 'store'])
        <form class="row" wire:submit="store">
            @include('_form.image_form')
        </form>
        <script> window.addEventListener('open-addImages', event => { window.$('#addImages').modal('show'); }) </script>
        <script> window.addEventListener('close-addImages', event => { window.$('#addImages').modal('hide'); }) </script>
    @endcomponent
</div>
