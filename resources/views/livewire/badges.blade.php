<div>
    <div class="d-flex align-items-center justify-content-between">
        <h2>Bagdes</h2>
        <div class="row mt-2">
            <div class="input-icon col">
                <input type="text" class="form-control form-control-rounded" wire:model.live="search" placeholder="Chercher ">
                <span class="input-icon-addon">
                    <i class="ti ti-search"></i>
                </span>
            </div>
            <div class="btn-list col-auto">
                @livewire('form.badge-add', ['projet_id' => $projet_id])
                <a class="btn btn-primary" href="{{ route('arp_card_pdfs', ['projet_id'=>$projet_id]) }}" target="_blank">ARP</a>
                <a class="btn btn-primary" href="{{ route('card_pdfs', ['projet_id'=>$projet_id,'type'=>2]) }}" target="_blank">SCD</a>
                <a class="btn btn-primary" wire:click="$dispatch('close-addbadge')" target="_blank">Actualiser</a>
            </div>
        </div>
    </div>

    <div class="row mt-2 g-2">
        @foreach ($badges as $badge)
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <div class="row align-items-center">
                            <div class="col-auto">
                                <img src="{{ asset($badge->photo) }}" alt="A" class="avatar">
                            </div>
                            <div class="col">
                                <div class="card-title">{{ $badge->prenom }} {{ $badge->nom }}</div>
                                <div class="card-subtitle">{{ $badge->fonction }} </div>
                            </div>
                        </div>

                        <div class="card-actions">
                            <div class="dropdown open">
                                <button class="btn btn-action" type="button" id="triggerId" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" >
                                    <i class="ti ti-dots-vertical"></i>
                                </button>
                                <div class="dropdown-menu" aria-labelledby="triggerId">
                                    <button class="dropdown-item" wire:click="edit('{{ $badge->id }}')"> <i class="ti ti-edit"></i> Editer</button>
                                    <button class="dropdown-item text-danger" wire:click="delete('{{ $badge->id }}')"> <i class="ti ti-trash"></i> Supprimer</button>
                                    <a class="dropdown-item" target="_blank" href="{{ route('arp_card_pdf', ['card_id'=>$badge->id]) }}"> <i class="ti ti-file-type-pdf"></i> PDF</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <ul class="list-group list-group-flush">
                        @if ($badge->service)
                            <li class="list-group-item">
                                <div class="fw-bold">Service :</div> <div> {{ $badge->service }}</div>
                            </li>
                        @endif
                        @if ($badge->direction)
                            <li class="list-group-item">
                                <div class="fw-bold">Direction :</div> <div> {{ $badge->direction }}</div>
                            </li>
                        @endif
                        @if ($badge->matricule)
                            <li class="list-group-item">
                                <div class="fw-bold">Matricule :</div> <div> {{ $badge->matricule }}</div>
                            </li>
                        @endif
                        @if ($badge->adresse)
                            <li class="list-group-item">
                                <div class="fw-bold">Adresse :</div> <div> {{ $badge->adresse }}</div>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>

        @endforeach
    </div>


    @component('components.modal', ["id"=>'editBadge', 'title' => 'Editer un badge'])
        <form class="row" wire:submit="update">
            @include('_form.badge_form')
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                <button type="submit" class="btn btn-primary">Valider</button>
            </div>
        </form>
        <script> window.addEventListener('open-editBadge', event => { $('#editBadge').modal('show'); }) </script>
        <script> window.addEventListener('close-editBadge', event => { $('#editBadge').modal('hide'); }) </script>
    @endcomponent
</div>
