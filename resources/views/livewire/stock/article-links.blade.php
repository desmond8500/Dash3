<div>
    <div class="card">
        <div class="card-header">
            <div class="card-title">Liens</div>
            <div class="card-actions">
                @livewire('form.add-article-link', ['article_id' => $article_id])
            </div>
        </div>
        <div class="card-body">
            @foreach ($links as $link)
                <div class="d-flex-between p-1 pb-1 border-bottom align-items-center">
                    <div>
                        <a href="{{ $link->link }}" target="_blank">{{ $link->name ?? 'Lien' }}</a>
                    </div>
                    <div>
                        <button class="btn btn-primary btn-icon" wire:click="edit('{{ $link->id }}')">
                            <i class="ti ti-edit"></i>
                        </button>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    @component('components.modal', ["id"=>'editArticleLink', 'title' => 'Editer un lien', 'method'=>'update'])
        <form class="row" wire:submit="update">
            @include('_form.article_link_form')
        </form>
        <script> window.addEventListener('open-editArticleLink', event => { window.$('#editArticleLink').modal('show'); }) </script>
        <script> window.addEventListener('close-editArticleLink', event => { window.$('#editArticleLink').modal('hide'); }) </script>
    @endcomponent
</div>
