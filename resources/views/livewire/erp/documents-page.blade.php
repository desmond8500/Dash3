<div>
    @component('components.layouts.page-header', ['title'=> 'Documents', 'breadcrumbs'=> $breadcrumbs])

    @endcomponent

    <div class="row g-2">
        <div class="col-md-4">
            <div class="card mb-2">
                <div class="card-header">
                    <div class="card-title">Documents</div>
                    <div class="card-actions">

                    </div>
                </div>
            </div>
            @foreach ($fiches as $fiche)
                <a class="card p-2 mb-1" href="{{ route($fiche->route,['name'=> $fiche->name, 'type'=> $fiche->type]) }}" target="_blank">
                    <div class="d-flex-between">
                        <div>{{ $fiche->name }}</div>
                        <i class="ti ti-download"></i>
                    </div>
                </a>
            @endforeach

            {{-- <div>{{ $fiches->links() }}</div> --}}

        </div>
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">Documents</div>
                    <div class="card-actions">
                        <div class="btn-list">
                            <div class="input-icon">
                                <input type="text" class="form-control form-control-rounded" wire:model.live="search" placeholder="Chercher un document...">
                                <span class="input-icon-addon">
                                    <i class="ti ti-search"></i>
                                </span>
                            </div>
                            <button class='btn btn-primary' wire:click="$dispatch('open-addDocument')" ><i class='ti ti-plus'></i> Document</button>

                        </div>
                    </div>
                </div>
                <div class="card-body">
                    @foreach ($documents as $document)
                        <div class="card p-2 mt-1">
                            <div class="row">
                                <div class="col-auto">
                                    @if ($document->extension == 'pdf')
                                        <img src="/assets/images/files/pdf.png" alt="PDF" class="avatar avatar-md">
                                    @elseif($document->extension == 'png' || $document->extension == 'jpg' || $document->extension == 'jpeg' || $document->extension == 'gif')
                                        <img src="{{ $document->path }}" alt="IMG" class="avatar avatar-md">
                                    @endif
                                </div>
                                <div class="col">
                                    <a class="card-title" href="{{ asset($document->path) }}" target="_blank">{{ $document->name }}</a>
                                </div>
                                <div class="col-auto">
                                  <button class="btn btn-outline-primary btn-icon" data-bs-toggle="tooltip" title="Envoyer par mail disabled wire:click="edit('{{ $document->id }}')">
                                    <i class="ti ti-mail"></i>
                                  </button>
                                  <button class="btn btn-outline-primary btn-icon" wire:click="edit('{{ $document->id }}')">
                                    <i class="ti ti-edit"></i>
                                  </button>
                                  <button class="btn btn-outline-danger btn-icon" wire:confirm="Etes vous sur de vouloir supprimer ce fchier ?" wire:click="delete('{{ $document->id }}')">
                                    <i class="ti ti-trash"></i>
                                  </button>
                              </div>
                            </div>
                        </div>
                    @endforeach

                </div>
                <div class="card-footer">

                </div>
            </div>
        </div>


    </div>


    @component('components.modal', ["id"=>'addDocument', 'title' => 'Ajouter un Document', 'method'=>'store'])
        <form class="row" wire:submit="store">
            @include('_form.document_form')
        </form>
        <script> window.addEventListener('open-addDocument', event => { window.$('#addDocument').modal('show'); }) </script>
        <script> window.addEventListener('close-addDocument', event => { window.$('#addDocument').modal('hide'); }) </script>
    @endcomponent
    @component('components.modal', ["id"=>'editDocument', 'title' => 'Editer Document', 'method'=>'update'])
        <form class="row" wire:submit="update">
            @include('_form.document_form')
        </form>
        <script> window.addEventListener('open-editDocument', event => { window.$('#editDocument').modal('show'); }) </script>
        <script> window.addEventListener('close-editDocument', event => { window.$('#editDocument').modal('hide'); }) </script>
    @endcomponent
</div>
