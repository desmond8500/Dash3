<div>
    <div class="card">
        <div class="card-header">
            <div class="card-title">Documents</div>
            <div class="card-actions">
                @livewire('form.add-article-document', ['article_id' => $article_id1])
            </div>
        </div>
        @if (!$documents->isEmpty())
            <div class="p-2">
                @foreach ($documents as $document)
                    @php
                        $file = pathinfo($document->folder);
                    @endphp
                    <div class="row align-items-center mb-1 pb-1 border-bottom">
                        <a class="col-auto" href="{{ asset($document->folder) }}" target="_blank">
                            @if ($file['extension'] == 'pdf')
                                <img src="{{ asset('img/icons/012-pdf.png') }}" alt="F" class="avatar p-1">
                            @else
                                <img src="{{ asset($document->folder) }}" alt="F" class="avatar">
                            @endif
                        </a>
                        <a class="col" href="{{ asset($document->folder) }}" target="_blank">
                            {{ $document->name ?? 'Lien' }}
                        </a>
                        <div class="col-auto">
                            <button class="btn btn-primary btn-icon" wire:click="edit('{{ $document->id }}')">
                                <i class="ti ti-edit"></i>
                            </button>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    @component('components.modal', ["id"=>'editArticleDocument', 'title' => 'Editer un document', 'method'=>'update'])
        <form class="row" wire:submit="update">
            @include('_form.article_document_form')
            {{-- <div class="modal-footer">
                <button type="button" class="btn btn-danger" wire:click="delete">
                    <i class="ti ti-trash"></i>
                </button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                <button type="submit" class="btn btn-primary">Valider</button>
            </div> --}}
        </form>
        <script> window.addEventListener('open-editArticleDocument', event => { window.$('#editArticleDocument').modal('show'); }) </script>
        <script> window.addEventListener('close-editArticleDocument', event => { window.$('#editArticleDocument').modal('hide'); }) </script>
    @endcomponent
</div>
