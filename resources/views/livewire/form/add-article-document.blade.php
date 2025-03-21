<div>
    <button class='btn btn-primary' wire:click="$dispatch('open-addArticleDocument')" ><i class='ti ti-plus'></i> Document</button>

    @component('components.modal', ["id"=>'addArticleDocument', 'title' => 'Ajouter un document',"method"=>"store"])
        <form class="row" wire:submit="store">
            @include('_form.article_document_form')
        </form>
        <script> window.addEventListener('open-addArticleDocument', event => { window.$('#addArticleDocument').modal('show'); }) </script>
        <script> window.addEventListener('close-addArticleDocument', event => { window.$('#addArticleDocument').modal('hide'); }) </script>
    @endcomponent

</div>
