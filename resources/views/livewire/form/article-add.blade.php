<div>
    <a class="btn btn-primary" wire:click="add"><i class="ti ti-plus"></i> Article </a>

    @component('components.modal', ["id"=>'addArticle', 'title'=>'Ajouter un article', 'refresh'=>true, "method"=>"store"])
        <form class="row" wire:submit="store">
            @include('_form.article_form',['providers' => $providers, 'brands'=> $brands])
        </form>
        <script> window.addEventListener('open-addArticle', event => { window.$('#addArticle').modal('show'); }) </script>
        <script> window.addEventListener('close-addArticle', event => { window.$('#addArticle').modal('hide'); }) </script>
    @endcomponent

</div>
