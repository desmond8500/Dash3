<div>
    <button class="btn btn-primary" wire:click="$dispatch('open-addJournal')">
        <i class="ti ti-plus"></i> Journal
    </button>

    @component('components.modal', ["id"=>'addJournal', 'title'=> 'Ajouter une entrée au journal', 'method'=>"store"])
        <form class="row" wire:submit="store">
            @include('_form.journal_form')
        </form>
        <script> addEventListener('open-addJournal', event => { $('#addJournal').modal('show'); }) </script>
        <script> addEventListener('close-addJournal', event => { $('#addJournal').modal('hide'); }) </script>
    @endcomponent
</div>
