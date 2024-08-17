<div>
    <div class="card">
        <div class="card-header">
            <div class="card-title">Documents</div>
            <div class="card-actions">
                {{-- @livewire('form.add-article-document', ['article_id' => $article_id]) --}}
            </div>
        </div>
        <div class="card-body">
            @foreach ($documents as $document)
                <div class="row align-items-center mb-1">
                    <a class="col-auto" href="{{ asset($document->folder) }}" target="_blank">
                        <img src="{{ asset($document->folder) }}" alt="F" class="avatar">
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
    </div>

    @component('components.modal', ["id"=>'editArticleLink', 'title' => 'Editer un document'])
        <form class="row" wire:submit="update">
            @include('_form.article_document_form')
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" wire:click="delete">
                    <i class="ti ti-trash"></i>
                </button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                <button type="submit" class="btn btn-primary">Valider</button>
            </div>
        </form>
        <script> window.addEventListener('open-editArticleLink', event => { $('#editArticleLink').modal('show'); }) </script>
        <script> window.addEventListener('close-editArticleLink', event => { $('#editArticleLink').modal('hide'); }) </script>
    @endcomponent
</div>
