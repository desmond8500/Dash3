<div>
    <button class='btn btn-primary' wire:click="$dispatch('open-addArticleLink')" ><i class='ti ti-plus'></i> Lien</button>

    @component('components.modal', ["id"=>'addArticleLink', 'title' => 'Ajouter un lien', "method"=>"store"])
        <form class="row" wire:submit="store">
            @include('_form.article_link_form')

        </form>
        <script> window.addEventListener('open-addArticleLink', event => { window.$('#addArticleLink').modal('show'); }) </script>
        <script> window.addEventListener('close-addArticleLink', event => { window.$('#addArticleLink').modal('hide'); }) </script>
    @endcomponent
</div>
