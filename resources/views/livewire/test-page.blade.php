<div>
    <div>Knowing others is intelligence; knowing yourself is true wisdom.</div>

    <button class="btn btn-primary" wire:click="$dispatch('open-modal')">Open</button>
    <button x-on:click="$dispatch('open-modal')">...</button>
     <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-plus" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"> <path stroke="none" d="M0 0h24v24H0z" fill="none"></path> <line x1="12" y1="5" x2="12" y2="19"></line> <line x1="5" y1="12" x2="19" y2="12"></line> </svg>
            Contrat
        </button>

        <div class="modal modal-blur fade" id="exampleModal" tabindex="-1" role="dialog" aria-hidden="true" wire:ignore.self>
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <form wire:submit.prevent=''>
                        <div class="modal-header">
                            <h5 class="modal-title">Add a new team</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            test {{ $number }}
                            <button class="btn btn-primary" wire:click="close()">Close</button>
                            <button class="btn btn-primary" wire:click="incf()">Ajouter</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <script> document.addEventListener('open-modal', event => { $("#exampleModal").modal('show'); }) </script>
        <script> document.addEventListener('close-modal', event => { $("#exampleModal").modal('hide'); }) </script>

</div>
