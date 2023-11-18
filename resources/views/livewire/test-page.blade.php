<div>

<button class="btn btn-primary" wire:click="$dispatch('open-addModal')">Ouvrir</button>

<div>
    @component('components.modal', ["id"=>'addModal', 'method'=>'close'])
        <script> window.addEventListener('open-addModal', event => { $('#addModal').modal('show'); }) </script>
        <script> window.addEventListener('close-addModal', event => { $('#addModal').modal('hide'); }) </script>
    @endcomponent
</div>


</div>
