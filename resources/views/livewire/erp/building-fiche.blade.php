<div>
    <div class="card">
        <div class="card-header">
            <div class="card-title">Fiches</div>
            <div class="card-actions">
                <button class="btn btn-icon" wire:click='$refresh'><i class="ti ti-reload"></i> </button>
            </div>
        </div>
        <div class="card-body">
            <div class="row row-deck g-2">
                @foreach ($fiches as $fiche)
                    <div class="col-md-4">
                        <div class="card p-2">
                            <div class="row">
                                {{-- <div class="col-auto">
                                    <img src="" alt="F" class="avatar avatar-md">
                                </div> --}}
                                <a class="col" href="{{ route('fiche_zone',['fiche_id'=>$fiche->id]) }}">
                                    <div class="card-title">{{ $fiche->titre }}</div>
                                    @isset($fiche->user)
                                        <div class="text-muted">{{ $fiche->user->firstname }} {{ $fiche->user->lastname }}</div>
                                    @endisset
                                </a>
                                <div class="col-auto">
                                    <button class="btn btn-primary btn-icon" wire:click="edit_fiche('{{ $fiche->id }}')">
                                        <i class="ti ti-edit"></i>
                                    </button>
                                    <a class="btn btn-outline-primary btn-icon" href="{{ route('fiche_pdf',['fiche_id'=>$fiche->id]) }}" target="_blank" >
                                        <i class="ti ti-eye"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    @component('components.modal', ["id"=>'editFiche', 'title' => 'Editer la fiche', 'method'=>'update_fiche'])
        <form class="row" wire:submit="update_fiche">
            @include('_form.fiche_form')
            {{-- <div class="modal-footer">
                <a type="button" class="btn btn-danger" wire:click='delete_fiche'>
                    <i class="ti ti-trash"></i>
                </a>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                <button type="submit" class="btn btn-primary">Valider</button>
            </div> --}}
        </form>
        <script> window.addEventListener('open-editFiche', event => { window.$('#editFiche').modal('show'); }) </script>
        <script> window.addEventListener('close-editFiche', event => { window.$('#editFiche').modal('hide'); }) </script>
    @endcomponent
</div>
