<div>
    <div class="row mt-2">
        <div class="btn-list">
            @livewire('form.badge-add', ['projet_id' => $projet_id])
            <a class="btn btn-primary" href="{{ route('arp_card_pdfs', ['projet_id'=>$projet_id]) }}" target="_blank">PDF</a>
            <a class="btn btn-primary" wire:click="$dispatch('close-addbadge')" target="_blank">Actualiser</a>
        </div>
    </div>

    <div class="row mt-2 g-2">
        @foreach ($badges as $badge)
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">Badge</div>
                        <div class="card-actions">
                            {{-- <button class="btn btn-primary btn-icon" wire:click="edit('{{ $badge->id }}')">
                                <i class="ti ti-edit"></i>
                            </button> --}}

                            <div class="dropdown open">
                                <button class="btn btn-secondary btn-icon" type="button" id="triggerId" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" >
                                    <i class="ti ti-chevron-down"></i>
                                </button>
                                <div class="dropdown-menu" aria-labelledby="triggerId">
                                    <button class="dropdown-item" wire:click="edit('{{ $badge->id }}')">Editer</button>
                                    <button class="dropdown-item text-danger" wire:click="delete('{{ $badge->id }}')">Supprimer</button>
                                    <a class="dropdown-item" target="_blank" href="{{ route('arp_card_pdf', ['card_id'=>$badge->id]) }}">PDF</a>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3">
                                <img src="{{ asset($badge->photo) }}" class="img-fluid rounded" alt="">
                            </div>
                            <div class="col-md-9">
                                <div class="d-flex justify-content-between">
                                    <div class="fw-bold">Prénom :</div> <div> {{ $badge->prenom }} </div>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <div class="fw-bold">Nom :</div> <div> {{ $badge->nom }}</div>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <div class="fw-bold">Fonction :</div> <div> {{ $badge->fonction }}</div>
                                </div>
                            </div>
                            <div class="col-md-12">

                            </div>
                        </div>
                    </div>
                    <!-- Some borders are removed -->
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">
                            <div class="fw-bold">Service :</div> <div> {{ $badge->service }}</div>
                        </li>
                        <li class="list-group-item">
                            <div class="fw-bold">Direction :</div> <div> {{ $badge->direction }}</div>

                        </li>
                        <li class="list-group-item">
                            <div class="fw-bold">Matricule :</div> <div> {{ $badge->matricule }}</div>

                        </li>
                        <li class="list-group-item">
                            <div class="fw-bold">Adresse :</div> <div> {{ $badge->adresse }}</div>
                        </li>
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
